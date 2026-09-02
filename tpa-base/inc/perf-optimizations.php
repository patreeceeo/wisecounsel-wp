<?php
/**
 * TPA Base — Performance Optimizations.
 *
 * PSI mobile target is 90+ on every TPA site. The optimizations in this file
 * apply universally to every TPA child theme without per-client tuning.
 *
 * What lives here:
 *   1. Defer WPForms JS — the form is below-the-fold (final-cta) on every TPA
 *      page; deferring removes ~6s of render-blocking time per PSI.
 *   2. Async-load WPForms CSS via the print-media swap technique — saves ~2s
 *      of render-blocking on the 19.2 KiB wpforms-full.min.css.
 *   3. Dequeue site-wide CSS on the Landing Page template — landing.css is
 *      self-contained (own body/font rules) and the LP uses only .lp-* classes,
 *      so loading 40KB of client.css + the parent style.css on the LP is
 *      render-blocking dead weight.
 *   4. Defer jQuery on frontend — wp_script_add_data('strategy','defer') is
 *      silently dropped when any dependent has inline blocking output, so we
 *      force the attribute via script_loader_tag. Worth ~3-4s LCP on PSI mobile
 *      because jQuery is the longest leaf in the critical request chain.
 *   5. Inline child theme CSS on non-LP pages — collapses client.css + the
 *      parent's enqueue of child style.css into the HTML stream, eliminating
 *      the entire render-blocking external-CSS critical chain. Files > 50 KB
 *      are skipped (would hurt TTFB more than render-blocking saves).
 *
 * Existing child themes inherit these automatically on next parent-theme
 * deploy. The child's own functions.php does not need to duplicate this logic.
 */

// ── 1. Defer WPForms JS ──────────────────────────────────────────────────
add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
    $defer_handles = [
        'wpforms', 'wpforms-modern', 'wpforms-validation',
        'wpforms-mailcheck', 'wpforms-punycode', 'wpforms-utils',
        'wpforms-fields-address', 'jquery-validate', 'mailcheck', 'punycode',
    ];
    $is_wpforms_src = ( strpos( $src, '/wpforms/' ) !== false );
    if ( in_array( $handle, $defer_handles, true ) || $is_wpforms_src ) {
        if ( strpos( $tag, ' defer' ) === false ) {
            $tag = str_replace( ' src=', ' defer src=', $tag );
        }
    }
    return $tag;
}, 10, 3 );

// ── 2. Async-load WPForms CSS (print-media swap) ─────────────────────────
add_filter( 'style_loader_tag', function ( $html, $handle, $href ) {
    $is_wpforms = ( strpos( $handle, 'wpforms' ) !== false ) || ( strpos( $href, '/wpforms/' ) !== false );
    if ( ! $is_wpforms ) {
        return $html;
    }
    $original = $html;
    $async = preg_replace(
        "/media=['\"][^'\"]*['\"]/",
        "media=\"print\" onload=\"this.media='all';this.onload=null;\"",
        $html
    );
    return $async . '<noscript>' . $original . '</noscript>';
}, 10, 3 );

// ── 3. Dequeue site-wide CSS on the Landing Page template ────────────────
// Priority 200 runs after every child theme's enqueue (typically priority 20).
// Handle names match what TPA child themes register; safe no-op if absent.
//
// NOTE: 'tpa-base-style' (which loads child's style.css) is intentionally NOT
// dequeued here — child themes use it to scope LP color overrides (e.g.
// `.landing-page { --lp-primary: #7A8F6A; }`). Block 5 below inlines it on
// the LP so the colors travel without an extra HTTP request.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_page_template( 'page-landing.php' ) ) {
        return;
    }
    // Standard child theme handle pattern: tpa-{slug}-client
    global $wp_styles;
    if ( $wp_styles && ! empty( $wp_styles->registered ) ) {
        foreach ( array_keys( $wp_styles->registered ) as $h ) {
            // Match {slug}-client or any handle ending in '-client'
            if ( substr( $h, -7 ) === '-client' ) {
                wp_dequeue_style( $h );
            }
        }
    }
}, 200 );

// ── 4. Defer jQuery on frontend ──────────────────────────────────────────
// jQuery is enqueued by WPForms (and other plugins) without defer, putting
// it on the LCP critical path. wp_script_add_data('jquery','strategy','defer')
// is silently dropped when any dependent has inline blocking output, so we
// force the defer attribute via script_loader_tag. WPForms' own scripts
// already declare defer, so execution order is preserved (jQuery still runs
// first, then WPForms).
add_filter( 'script_loader_tag', function ( $tag, $handle, $src ) {
    if ( is_admin() ) {
        return $tag;
    }
    if ( $handle === 'jquery-core' || $handle === 'jquery' ) {
        if ( false === stripos( $tag, ' defer' ) ) {
            $tag = preg_replace( '/<script(\s)/', '<script defer$1', $tag, 1 );
        }
    }
    return $tag;
}, 10, 3 );

// ── 5. Inline child theme CSS on non-LP pages ────────────────────────────
// Collapses two render-blocking external stylesheets into the HTML stream:
//   a) parent's 'tpa-base-style' enqueue (loads child's own style.css via
//      get_stylesheet_uri() — usually 0.3-4 KB, mostly empty/header, but
//      Elizabeth Holman et al. carry real overrides we must preserve)
//   b) any '{slug}-client' handle the child enqueues (typically client.css,
//      ~15-25 KB)
//
// We INLINE rather than DEQUEUE to preserve every byte of the original CSS.
// Files > 50 KB are left external — inlining them would bloat TTFB more than
// the render-blocking removal saves. LP is skipped because block 3 already
// dequeues these handles there (LP uses landing.css instead).
//
// Two-step: phase 1 (priority 100, after child enqueues at priority 20)
// identifies + dequeues. Phase 2 (wp_head priority 5) emits the <style>
// blocks before any other head output.
add_action( 'wp_enqueue_scripts', function () {
    if ( is_admin() ) {
        return;
    }
    $is_lp = is_page_template( 'page-landing.php' );
    $GLOBALS['tpa_inline_css_paths'] = [];

    global $wp_styles;
    if ( ! $wp_styles || empty( $wp_styles->registered ) ) {
        return;
    }
    $stylesheet_uri = get_stylesheet_directory_uri();
    $stylesheet_dir = get_stylesheet_directory();

    foreach ( array_keys( $wp_styles->registered ) as $h ) {
        $is_client     = ( substr( $h, -7 ) === '-client' );
        $is_base_style = ( $h === 'tpa-base-style' );
        if ( ! $is_client && ! $is_base_style ) {
            continue;
        }
        // On LP, only inline base-style (carries .landing-page color overrides);
        // skip *-client because LP uses landing.css instead of client.css.
        if ( $is_lp && $is_client ) {
            continue;
        }

        $reg = $wp_styles->registered[ $h ];
        $url = $reg->src;
        // Only inline files that live in the active child theme directory.
        if ( strpos( $url, $stylesheet_uri ) !== 0 ) {
            continue;
        }
        $rel  = strtok( substr( $url, strlen( $stylesheet_uri ) ), '?' );
        $path = $stylesheet_dir . $rel;
        if ( ! file_exists( $path ) ) {
            continue;
        }
        // 100 KB ceiling — gzip means the wire cost of a 97 KB CSS file is
        // ~24 KB either way; the ceiling is on raw size as a conservative proxy.
        // Raised from 50 KB: abbybailly client.css is 97 KB raw / 24 KB gzipped.
        if ( filesize( $path ) > 100 * 1024 ) {
            continue;
        }

        wp_dequeue_style( $h );
        $GLOBALS['tpa_inline_css_paths'][] = $path;
    }

    // On LP pages, also inline landing-critical.css (above-fold: nav, hero, buttons).
    if ( $is_lp && isset( $wp_styles->registered['tpa-landing-critical-css'] ) ) {
        $reg  = $wp_styles->registered['tpa-landing-critical-css'];
        $pdir = get_template_directory();
        $puri = get_template_directory_uri();
        $url  = $reg->src;
        if ( strpos( $url, $puri ) === 0 ) {
            $rel  = strtok( substr( $url, strlen( $puri ) ), '?' );
            $path = $pdir . $rel;
            if ( file_exists( $path ) && filesize( $path ) <= 100 * 1024 ) {
                wp_dequeue_style( 'tpa-landing-critical-css' );
                $GLOBALS['tpa_inline_css_paths'][] = $path;
            }
        }
    }

    // On LP pages, also inline landing.css (parent theme, no image url() refs,
    // so URL rewriting is a no-op — safe to inline from parent theme dir).
    if ( $is_lp && isset( $wp_styles->registered['tpa-landing-css'] ) ) {
        $reg  = $wp_styles->registered['tpa-landing-css'];
        $pdir = get_template_directory();
        $puri = get_template_directory_uri();
        $url  = $reg->src;
        if ( strpos( $url, $puri ) === 0 ) {
            $rel  = strtok( substr( $url, strlen( $puri ) ), '?' );
            $path = $pdir . $rel;
            if ( file_exists( $path ) && filesize( $path ) <= 100 * 1024 ) {
                wp_dequeue_style( 'tpa-landing-css' );
                $GLOBALS['tpa_inline_css_paths'][] = $path;
            }
        }
    }
}, 100 );

add_action( 'wp_head', function () {
    if ( empty( $GLOBALS['tpa_inline_css_paths'] ) ) {
        return;
    }
    $stylesheet_uri = get_stylesheet_directory_uri();
    foreach ( $GLOBALS['tpa_inline_css_paths'] as $path ) {
        echo "\n<style id=\"tpa-inline-" . esc_attr( basename( $path, '.css' ) ) . "\">";
        $css = file_get_contents( $path );
        // Relative url('../images/') resolves against the page root when inlined,
        // not the CSS file location — rewrite to absolute so images load correctly.
        // Rewrite relative url('../images/file.ext') → absolute url('https://...').
        // Handles unquoted, single-quoted, and double-quoted url() forms.
        $css = preg_replace_callback(
            '/url\(\s*[\'"]?\.\.\/images\/([^\'")\s]+)[\'"]?\s*\)/i',
            function ( $m ) use ( $stylesheet_uri ) {
                return "url('" . $stylesheet_uri . "/assets/images/" . $m[1] . "')";
            },
            $css
        );
        echo $css;
        echo "</style>\n";
    }
}, 5 );
