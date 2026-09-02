<?php
/**
 * TPA Page Overrides — client self-serve controls for inner pages.
 *
 * Two per-page controls every client can use from the page editor without
 * touching theme files:
 *
 *   1. Featured Image → replaces the inner-page hero background image.
 *      Both parent templates and child-theme overrides paint the hero via an
 *      inline background-image (many children use a hardcoded slug→file map),
 *      so this hook out-cascades all of them with a !important override —
 *      one file, fleet-wide, no child template edits (same pattern as the
 *      legal no-anim and thank-you hooks in functions.php).
 *
 *   2. "Hide page title" toggle (TPA Page Settings box, editor sidebar) →
 *      hides the hero H1 for pages whose body content carries its own
 *      heading. The ACF group is registered here (not acf-fields.php) so
 *      this file stays fully self-contained and can be dropped into any
 *      older tpa-base copy with a single require line.
 *
 * Deliberately does nothing on the homepage and landing pages — their heroes
 * are ACF-driven and must not be affected by a stray Featured Image.
 *
 * Load guard: this file is required by tpa-base/functions.php AND shipped as
 * an mu-plugin on older sites whose tpa-base predates it — the guard keeps
 * the hooks single-registered when both copies are present.
 */

if ( defined( 'TPA_PAGE_OVERRIDES_LOADED' ) ) {
    return;
}
define( 'TPA_PAGE_OVERRIDES_LOADED', true );

add_action( 'wp_head', function () {
    if ( ! is_page() || is_front_page() || is_page_template( 'page-landing.php' ) ) {
        return;
    }
    $page_id = get_queried_object_id();
    $css     = '';

    $hero = get_the_post_thumbnail_url( $page_id, 'full' );
    if ( $hero ) {
        // CSS backgrounds are discovered late by the preload scanner; on inner
        // pages the hero is usually the LCP element, so preload it explicitly.
        echo '<link rel="preload" as="image" href="' . esc_url( $hero ) . '" fetchpriority="high">';
        $css .= '.inner-hero,.inner-hero-bg,.inner-page-hero,.inner-page-hero-bg{'
              . 'background-image:url(' . esc_url( $hero ) . ')!important;'
              . 'background-size:cover!important;background-position:center!important;}';
    }

    if ( get_post_meta( $page_id, 'tpa_hide_page_title', true ) ) {
        $css .= '.inner-page-title,.inner-hero-content h1,.inner-hero h1{display:none!important;}';
    }

    if ( $css ) {
        echo '<style id="tpa-page-overrides">' . $css . '</style>';
    }
}, 100 );

/**
 * Client self-serve logo swap (TPA Settings → TPA Logo).
 *
 * Child themes hardcode <img src=".../logo*.png"> in header/footer/front-page
 * markup with no shared class names, so this uses CSS image replacement
 * (content:url — supported by all evergreen browsers) keyed on the one thing
 * that IS consistent fleet-wide: logo filenames start with "/logo".
 * `img[src*="/logo"]` deliberately does NOT match body images like
 * about-logo-wm.jpg or third-party badges (psychology-today-logo.png).
 *
 * Landing pages keep their own lp-brand assets — skipped. Sites whose logo is
 * split into separate mark + wordmark <img>s would show the upload twice;
 * those rebrands need a per-site template edit instead.
 */
add_action( 'wp_head', function () {
    if ( ! function_exists( 'get_field' ) || is_page_template( 'page-landing.php' ) ) {
        return;
    }
    $logo   = get_field( 'tpa_logo_override', 'option' );
    $footer = get_field( 'tpa_footer_logo_override', 'option' );
    if ( ! $logo && ! $footer ) {
        return;
    }
    // Header and footer logos are INDEPENDENT: footers usually sit on an
    // inverted background and need their own variant, so the main Logo never
    // touches the footer — it keeps the theme default until Footer logo is set.
    $footer_scope = 'footer img[src*="/logo"],.site-footer img[src*="/logo"],[class*="footer"] img[src*="/logo"]';
    $css = '';
    if ( $logo ) {
        $css .= 'img[src*="/logo"]{content:url(' . esc_url( $logo ) . ');}';
        if ( ! $footer ) {
            $css .= $footer_scope . '{content:normal;}';
        }
    }
    if ( $footer ) {
        $css .= $footer_scope . '{content:url(' . esc_url( $footer ) . ');}';
    }
    echo '<style id="tpa-logo-override">' . $css . '</style>';
}, 100 );

add_action( 'acf/init', function () {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }
    acf_add_local_field_group( [
        'key'        => 'group_tpa_logo_override',
        'title'      => 'TPA Logo',
        'location'   => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tpa-settings' ] ] ],
        'position'   => 'normal',
        'menu_order' => 1,
        'fields'     => [
            [
                'key'           => 'field_tpa_logo_override',
                'label'         => 'Logo',
                'name'          => 'tpa_logo_override',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'instructions'  => 'Replaces the logo in the header and on the homepage. The footer logo is separate — set it below. Transparent PNG with proportions similar to the current logo works best. Remove the image to restore the theme default.',
            ],
            [
                'key'           => 'field_tpa_footer_logo_override',
                'label'         => 'Footer logo (optional)',
                'name'          => 'tpa_footer_logo_override',
                'type'          => 'image',
                'return_format' => 'url',
                'preview_size'  => 'medium',
                'instructions'  => 'Replaces the footer logo (usually an inverted/white variant for a dark footer). Leave empty to keep the current theme footer logo.',
            ],
        ],
    ] );
    acf_add_local_field_group( [
        'key'        => 'group_tpa_page_settings',
        'title'      => 'TPA Page Settings',
        'location'   => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ] ] ],
        'position'   => 'side',
        'menu_order' => 99,
        'fields'     => [
            [
                'key'          => 'field_tpa_hide_page_title',
                'label'        => 'Hide page title',
                'name'         => 'tpa_hide_page_title',
                'type'         => 'true_false',
                'ui'           => 1,
                'instructions' => 'Hide the large title in the hero band. Use when the page content provides its own heading.',
            ],
            [
                'key'     => 'field_tpa_page_settings_hero_note',
                'label'   => 'Hero image',
                'name'    => '',
                'type'    => 'message',
                'message' => 'To change this page\'s hero background, set a Featured Image (right sidebar → Featured Image). Remove it to return to the theme default.',
            ],
        ],
    ] );
} );
