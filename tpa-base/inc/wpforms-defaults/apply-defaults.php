<?php
/**
 * TPA WPForms spam defaults — apply to every form on a site.
 *
 * Run via wp-cli on the dev/prelive site:
 *   wp eval-file wp-content/themes/tpa-base/inc/wpforms-defaults/apply-defaults.php
 *
 * Idempotent: safe to re-run. Reports per-form what (if anything) it changed.
 *
 * Sets on EVERY published WPForms form:
 *   - Modern anti-spam protection (antispam_v3)
 *   - Submission time limit: 6 seconds (anti_spam.time_limit)
 *   - Country filter: allow US only (anti_spam.country_filter)
 *   - Keyword filter enabled (anti_spam.keyword_filter)
 *   - Email-field denylist (TPA canonical spam-domain blocklist) on every
 *     field of type "email" — UNION with any existing entries, never clobbers
 *     client-added domains.
 *
 * Country + keyword filters are WPForms Pro features. On Lite they persist as
 * inert JSON and activate automatically once Pro is live on production.
 *
 * Schema verified against a real configured form (edlizvazquez form 16),
 * 2026-06-16. If WPForms changes its settings schema, re-verify against a
 * form configured through the WPForms UI before editing this file.
 */

if ( ! defined( 'ABSPATH' ) ) {
	fwrite( STDERR, "Must be run via wp eval-file.\n" );
	exit( 1 );
}

/** Canonical TPA email-denylist (74 spam domains). Pattern: *@domain. */
$tpa_email_denylist = array(
	'*@rudiplomust.com', '*@xrevelxr.com', '*@wexxon.com', '*@monkeydigital.co',
	'*@gazeta.pl', '*@increaseorganictraffic.com', '*@mail.ru', '*@bk.ru',
	'*@onet.pl', '*@parapsycholomail.com', '*@radiolucencomail.com', '*@duck.com',
	'*@progon.fun', '*@azmail.fun', '*@2mailcache.com', '*@1mailcache.com',
	'*@mozmail.com', '*@op.pl', '*@5way5.com', '*@yandex.kz', '*@rambler.ru',
	'*@3way3.com', '*@disaffectionomail.com', '*@list.ru', '*@counterattractomail.com',
	'*@cocaine-v-toshkente.shop', '*@farironalds.com', '*@93rus.myjino.ru',
	'*@profuslugi24.store', '*@cocaine-ukraine.online', '*@1ti.ru',
	'*@uborka-posle-remonta-msk.store', '*@informers.site', '*@cleanspb-top.store',
	'*@uslugi-remont-otdelka.store', '*@luksclean-ufa.store', '*@dianabykiris.fun',
	'*@russia-cocaine.online', '*@hoopsori.shop', '*@web.de', '*@dostupno-vsem.shop',
	'*@int.pl', '*@alliplnews.art', '*@himchistka-mebeli-msk24.store', '*@gmx.com',
	'*@mailbox.org', '*@alliplnews.my', '*@myagkie-paneli11.ru', '*@me-game.store',
	'*@railugpharow.shop', '*@kypit-v-ukraine.online', '*@cocaines-kyiv.online',
	'*@fishcreeksanitarydistrict.org', '*@premiermgmtcfl.com', '*@packard-inc.com',
	'*@man-diploms-srednee24.com', '*@ventura17.ru', '*@mymaildew.ru',
	'*@tb-strahovanie-ipoteki.ru', '*@sd123f.tech', '*@salpingomyu.ru', '*@m180489.ru',
	'*@fanera-kupit11.ru', '*@triol.site', '*@15h.ru', '*@registry.godaddy',
	'*@kr.slembassy.gov.sl', '*@basailpaurashava.gov.bd', '*@poliziadistato.it',
	'*@nrch.com.au', '*@paxosgroup.com', '*@mccorklesales.com', '*@mail.de',
	'*@peoplepc.com',
);

$forms = get_posts( array(
	'post_type'      => 'wpforms',
	'post_status'    => 'publish',
	'posts_per_page' => -1,
) );

if ( empty( $forms ) ) {
	echo "No published WPForms forms found.\n";
	return;
}

$total_changed = 0;

foreach ( $forms as $form ) {
	$data = json_decode( $form->post_content, true );
	if ( ! is_array( $data ) ) {
		echo "Form {$form->ID} ({$form->post_title}): could not decode JSON — skipped.\n";
		continue;
	}

	$changes = array();

	if ( ! isset( $data['settings'] ) || ! is_array( $data['settings'] ) ) {
		$data['settings'] = array();
	}

	// 1. Modern anti-spam.
	if ( ( $data['settings']['antispam_v3'] ?? '' ) !== '1' ) {
		$data['settings']['antispam_v3'] = '1';
		$changes[] = 'antispam_v3';
	}

	// 2-4. anti_spam block (time limit, country filter, keyword filter).
	if ( ! isset( $data['settings']['anti_spam'] ) || ! is_array( $data['settings']['anti_spam'] ) ) {
		$data['settings']['anti_spam'] = array();
	}
	$as = &$data['settings']['anti_spam'];

	$want_time = array( 'enable' => '1', 'duration' => '6' );
	if ( ( $as['time_limit'] ?? null ) != $want_time ) {
		$as['time_limit'] = $want_time;
		$changes[] = 'time_limit=6s';
	}

	$want_country = array(
		'enable'        => '1',
		'action'        => 'allow',
		'country_codes' => '["US"]',
		'message'       => 'Sorry, this form does not accept submissions from your country.',
	);
	if ( ( $as['country_filter'] ?? null ) != $want_country ) {
		$as['country_filter'] = $want_country;
		$changes[] = 'country_filter=US';
	}

	if ( ( $as['keyword_filter']['enable'] ?? '' ) !== '1' ) {
		$as['keyword_filter'] = array_merge(
			is_array( $as['keyword_filter'] ?? null ) ? $as['keyword_filter'] : array(),
			array( 'enable' => '1' )
		);
		$changes[] = 'keyword_filter';
	}
	unset( $as );

	// 5. Email-field denylist (union, non-destructive) on every email field.
	if ( isset( $data['fields'] ) && is_array( $data['fields'] ) ) {
		foreach ( $data['fields'] as $fid => &$field ) {
			if ( ( $field['type'] ?? '' ) !== 'email' ) {
				continue;
			}

			$existing = array();
			if ( ! empty( $field['denylist'] ) ) {
				$existing = preg_split( '/\r\n|\r|\n/', $field['denylist'] );
				$existing = array_filter( array_map( 'trim', $existing ), 'strlen' );
			}

			// Union: canonical list first, then any client extras not already present.
			$merged = $tpa_email_denylist;
			foreach ( $existing as $e ) {
				if ( ! in_array( $e, $merged, true ) ) {
					$merged[] = $e;
				}
			}

			$new_denylist  = implode( "\r\n", $merged );
			$field_changed = false;

			if ( ( $field['filter_type'] ?? '' ) !== 'denylist' ) {
				$field['filter_type'] = 'denylist';
				$field_changed = true;
			}
			if ( ( $field['denylist'] ?? '' ) !== $new_denylist ) {
				$field['denylist'] = $new_denylist;
				$field_changed = true;
			}
			if ( $field_changed ) {
				$changes[] = "email-denylist(field {$fid})";
			}
		}
		unset( $field );
	}

	if ( empty( $changes ) ) {
		echo "Form {$form->ID} ({$form->post_title}): already compliant — no change.\n";
		continue;
	}

	wp_update_post( array(
		'ID'           => $form->ID,
		'post_content' => wp_slash( wp_json_encode( $data ) ),
	) );
	$total_changed++;
	echo "Form {$form->ID} ({$form->post_title}): updated [" . implode( ', ', $changes ) . "]\n";
}

echo "\nDone. {$total_changed} form(s) updated, " . ( count( $forms ) - $total_changed ) . " already compliant.\n";
