<?php
/**
 * TPA Base — Master functions file.
 * Loads includes, enqueues assets, provides helpers.
 */

// ── Includes ──
require_once get_template_directory() . '/inc/theme-setup.php';
require_once get_template_directory() . '/inc/nav-walker.php';
require_once get_template_directory() . '/inc/sections-loader.php';
require_once get_template_directory() . '/inc/perf-optimizations.php';
require_once get_template_directory() . '/inc/tpa-picture.php';
require_once get_template_directory() . '/inc/page-overrides.php';
require_once get_template_directory() . '/inc/upload-optimizations.php';

/**
 * Legal pages (Privacy Policy, Terms & Conditions) must display full content
 * immediately on page load. Both templates ship as long text documents, and
 * the site-wide scroll-reveal animations (.fade-in, [data-anim]) leave the
 * body hidden for seconds before revealing — bad UX for pages users visit
 * with intent to read.
 *
 * Inline <style> in wp_head runs regardless of which page template the child
 * theme uses, and !important overrides any animation rule defined in
 * client.css or elsewhere.
 */
function tpa_is_legal_page() {
    return is_page( [ 'privacy-policy', 'terms-and-conditions' ] );
}

/**
 * Return an animation class name unless on a legal page (Privacy/Terms),
 * which must render content immediately with no opacity-0 starting state.
 *
 * Long legal documents wrap the_content() in one tall .reveal/.fade-in div.
 * The IntersectionObserver threshold (0.15) cannot be crossed when the div
 * is taller than viewport / 0.15, so the .visible class never gets added and
 * the content stays invisible forever.
 *
 * Templates use this in place of hardcoded animation class names:
 *   <div class="inner-body <?php echo tpa_anim_class( 'reveal' ); ?>">
 *
 * @param string $class Animation class to apply on non-legal pages.
 * @return string The class name, or '' on legal pages.
 */
function tpa_anim_class( $class ) {
    return tpa_is_legal_page() ? '' : $class;
}

/**
 * Same as tpa_anim_class() but for the data-anim attribute used by the
 * parent theme's scroll-animations.js. Returns the attribute (with leading
 * space) on non-legal pages, empty string on legal pages.
 *
 * Templates use this in place of a hardcoded data-anim attribute:
 *   <h1 class="inner-page-title"<?php echo tpa_anim_attr(); ?>>
 */
function tpa_anim_attr() {
    return tpa_is_legal_page() ? '' : ' data-anim';
}

add_action( 'wp_head', function () {
    if ( ! tpa_is_legal_page() ) {
        return;
    }
    // Belt-and-suspenders backstop in case a template still emits .reveal /
    // [data-anim] / .fade-in on a legal page (e.g. a child theme that hasn't
    // been migrated to the helpers yet). Force everything visible so the
    // page is never dependent on JS firing.
    echo '<style id="tpa-legal-no-anim">'
        . '.fade-in,[data-anim],.reveal,.reveal-left,.reveal-right,.reveal-scale,'
        . '.inner-content,.inner-page-content,.inner-page-body,.inner-body,.inner-hero-content{'
        . 'opacity:1!important;transform:none!important;animation:none!important;visibility:visible!important;}'
        . '</style>';
}, 100 );

/**
 * Thank You page styling — applied via inline <style> on the thank-you page
 * only. Content is wrapped in .ty-card by populate-thank-you.py; this rule
 * turns the short block of text into a centered card with typographic
 * hierarchy, a subtle divider before the phone line, and branded link
 * styling that inherits from the site's body color (works across all 24
 * palettes without per-site tuning).
 */
add_action( 'wp_head', function () {
    if ( ! is_page( 'thank-you' ) ) {
        return;
    }
    echo '<style id="tpa-thank-you-css">'
        // Hide the hero page title on every child-theme class variant
        // (parent uses .inner-page-title; most children render an H1 inside .inner-hero-content)
        . '.page-thank-you .inner-page-title,.page-thank-you .inner-hero-content h1,.page-thank-you .inner-hero-content,.page-thank-you .inner-page-hero .container{display:none!important;}'
        // Collapse the default section padding on both parent (.inner-page-content) and child (.inner-content) wrappers
        . '.page-thank-you .inner-page-content,.page-thank-you .inner-content{padding:24px 0!important;}'
        . '.ty-card{display:flex;flex-direction:column;justify-content:center;min-height:50vh;max-width:640px;margin:0 auto;padding:32px 24px;text-align:center;box-sizing:border-box;font-family:inherit;}'
        . '.ty-card h2{font-size:clamp(2rem,4vw,2.75rem);line-height:1.2;margin:0 0 20px;letter-spacing:-0.01em;}'
        . '.ty-card h3{font-size:1.1rem;font-weight:400;line-height:1.55;opacity:0.85;margin:0;}'
        . '.ty-card h3:last-of-type{font-size:clamp(1.4rem,2.6vw,1.75rem);font-weight:500;opacity:1;margin:40px 0 10px;padding-top:28px;position:relative;}'
        . '.ty-card h3:last-of-type::before{content:"";position:absolute;top:0;left:50%;transform:translateX(-50%);width:56px;height:1px;background:currentColor;opacity:0.2;}'
        . '.ty-card h5{font-size:1rem;font-weight:400;margin:0;opacity:0.7;letter-spacing:0.02em;}'
        . '.ty-card a{color:inherit;text-decoration:none;border-bottom:1px solid currentColor;padding-bottom:2px;transition:opacity 0.2s ease;}'
        . '.ty-card a:hover{opacity:0.55;}'
        . '@media (max-width:640px){.page-thank-you .inner-page-content,.page-thank-you .inner-content{padding:16px 0!important;}.ty-card{min-height:40vh;padding:24px 20px;}.ty-card h3:last-of-type{margin-top:28px;padding-top:20px;}}'
        . '</style>';
}, 100 );

/**
 * Universal WPForms brand styling — fleet-wide, dequeue-proof, permanent fix.
 *
 * WPForms "modern" markup ships 600+ CSS rules that load AFTER the theme CSS and
 * default to WPForms' own skin (grey/blue submit, generic inputs). Historically
 * every child theme re-solved this with per-site `.wpforms-*` overrides — and
 * forgot to on nearly every build, so forms shipped unstyled. This hook fixes it
 * ONCE for every site: it styles any WPForms form generically via
 * `.wpforms-container`, mapped to a canonical set of `--form-*` brand tokens that
 * each child defines in its style.css. Emitted inline in wp_head at priority 100
 * (after WPForms' CSS) so it wins the cascade, and it cannot be dequeued.
 *
 * The modern engine renders its skin from `--wpforms-*` custom properties AND has
 * no `!important` on submit/input backgrounds, so BOTH levers here win: we set the
 * modern vars (native rendering for selects/sublabels/chrome) and add `!important`
 * doubled-selector rules for labels/inputs/submit + the hover sweep.
 *
 * Fallback chain: `--form-*` token → common child brand token (`--accent`/
 * `--primary`) → neutral default — so a form is never unstyled even before a child
 * defines tokens. A child that wants a bespoke per-form flourish can still add a
 * higher-specificity override (e.g. `.formcard .wpforms-submit`) and it will win.
 *
 * CHILD CONTRACT — define these in the child style.css `:root` (see tpa-scaffold):
 *   --form-field-bg, --form-field-border, --form-field-text, --form-label,
 *   --form-label-sub, --form-required, --form-radius, --form-focus,
 *   --form-focus-ring, --form-btn-bg, --form-btn-text, --form-btn-bg-hover,
 *   --form-btn-text-hover, --form-btn-radius
 */
add_action( 'wp_head', function () {
    if ( is_admin() ) {
        return;
    }
    $css = <<<'CSS'
.wpforms-container{
  --wpforms-field-border-radius:var(--form-radius,6px);
  --wpforms-field-border-style:solid;
  --wpforms-field-border-size:1.5px;
  --wpforms-field-border-width:1.5px;
  --wpforms-field-background-color:var(--form-field-bg,#fff);
  --wpforms-field-border-color:var(--form-field-border,rgba(0,0,0,.16));
  --wpforms-field-text-color:var(--form-field-text,#2b2b2b);
  --wpforms-field-menu-color:var(--form-field-bg,#fff);
  --wpforms-label-color:var(--form-label,#2b2b2b);
  --wpforms-label-sublabel-color:var(--form-label-sub,rgba(0,0,0,.55));
  --wpforms-label-error-color:#b3261e;
  --wpforms-button-border-radius:var(--form-btn-radius,var(--form-radius,9px));
  --wpforms-button-background-color:var(--form-btn-bg,var(--accent,var(--primary,#2d6e5e)));
  --wpforms-button-background-color-alt:var(--form-btn-bg-hover,var(--primary-dark,var(--form-btn-bg,var(--accent,#245a4c))));
  --wpforms-button-text-color:var(--form-btn-text,#fff);
  --wpforms-button-text-color-alt:var(--form-btn-text-hover,var(--form-btn-text,#fff));
  --wpforms-container-padding:0;
  --wpforms-container-border-width:0;
}
.wpforms-container .wpforms-form .wpforms-field{padding:0 !important;margin:0 0 1.05rem !important}
.wpforms-container .wpforms-form .wpforms-field-label{display:block !important;font-family:inherit !important;font-weight:700 !important;font-size:var(--form-label-size,.75rem) !important;letter-spacing:.1em !important;text-transform:uppercase !important;color:var(--form-label,#2b2b2b) !important;opacity:.78 !important;margin:0 0 .45rem !important;line-height:1.3 !important}
.wpforms-container .wpforms-form .wpforms-required-label{color:var(--form-required,var(--accent,var(--primary,#b3261e))) !important}
.wpforms-container .wpforms-form .wpforms-field-description{color:var(--form-label-sub,rgba(0,0,0,.55)) !important;font-size:.82rem !important}
.wpforms-container.wpforms-container-full .wpforms-form input[type=text],
.wpforms-container.wpforms-container-full .wpforms-form input[type=email],
.wpforms-container.wpforms-container-full .wpforms-form input[type=tel],
.wpforms-container.wpforms-container-full .wpforms-form input[type=url],
.wpforms-container.wpforms-container-full .wpforms-form input[type=number],
.wpforms-container.wpforms-container-full .wpforms-form textarea,
.wpforms-container.wpforms-container-full .wpforms-form select{width:100% !important;max-width:100% !important;height:auto !important;line-height:1.4 !important;font-family:inherit !important;font-size:1rem !important;color:var(--form-field-text,#2b2b2b) !important;background:var(--form-field-bg,#fff) !important;border:1.5px solid var(--form-field-border,rgba(0,0,0,.16)) !important;border-radius:var(--form-radius,6px) !important;padding:.85rem 1rem !important;box-shadow:none !important}
.wpforms-container.wpforms-container-full .wpforms-form input:focus,
.wpforms-container.wpforms-container-full .wpforms-form textarea:focus,
.wpforms-container.wpforms-container-full .wpforms-form select:focus{border-color:var(--form-focus,var(--accent,var(--primary,#666))) !important;box-shadow:0 0 0 3px var(--form-focus-ring,rgba(0,0,0,.1)) !important;outline:none !important}
.wpforms-container .wpforms-form textarea{resize:vertical !important;min-height:96px !important}
.wpforms-container .wpforms-form ::placeholder{color:var(--form-field-text,#2b2b2b) !important;opacity:.4 !important}
.wpforms-container .wpforms-submit-container{margin-top:.4rem !important;padding:0 !important}
.wpforms-container .wpforms-form button.wpforms-submit{display:flex !important;align-items:center !important;justify-content:center !important;gap:.5rem !important;width:100% !important;font-family:inherit !important;font-weight:700 !important;font-size:.85rem !important;letter-spacing:.06em !important;text-transform:uppercase !important;color:var(--form-btn-text,#fff) !important;background:var(--form-btn-bg,var(--accent,var(--primary,#2d6e5e))) !important;border:none !important;border-radius:var(--form-btn-radius,var(--form-radius,9px)) !important;padding:1.05rem 2rem !important;cursor:pointer !important;position:relative !important;overflow:hidden !important;z-index:0 !important;text-shadow:none !important;transition:color .35s ease,box-shadow .4s ease !important;box-shadow:0 8px 24px rgba(0,0,0,.14) !important}
.wpforms-container .wpforms-form button.wpforms-submit::after{content:"" !important;position:absolute !important;inset:0 !important;z-index:-1 !important;background:var(--form-btn-bg-hover,var(--primary-dark,var(--accent,#245a4c))) !important;transform:translateX(-100%) !important;transition:transform .45s ease !important}
.wpforms-container .wpforms-form button.wpforms-submit:hover,.wpforms-container .wpforms-form button.wpforms-submit:focus-visible{color:var(--form-btn-text-hover,var(--form-btn-text,#fff)) !important;box-shadow:0 14px 34px rgba(0,0,0,.24) !important}
.wpforms-container .wpforms-form button.wpforms-submit:hover::after,.wpforms-container .wpforms-form button.wpforms-submit:focus-visible::after{transform:translateX(0) !important}
.wpforms-confirmation-container-full{background:var(--form-field-bg,#fff) !important;border:1px solid var(--form-field-border,rgba(0,0,0,.16)) !important;color:var(--form-field-text,#2b2b2b) !important;border-radius:var(--form-radius,8px) !important;padding:1rem 1.2rem !important}
@media (hover:none) and (pointer:coarse){
  .wpforms-container .wpforms-form .wpforms-field-label{font-size:14px !important}
  .wpforms-container .wpforms-form input,.wpforms-container .wpforms-form textarea,.wpforms-container .wpforms-form select{font-size:16px !important}
  .wpforms-container .wpforms-form button.wpforms-submit{min-height:44px !important;font-size:14px !important}
}
CSS;
    echo '<style id="tpa-wpforms-brand">' . $css . '</style>';
}, 100 );

/**
 * Prevent single-word widows on landing-page headlines.
 *
 * Glues the last two words of a headline with a non-breaking space (U+00A0)
 * so the final word can never orphan onto its own line. Safe to pass through
 * esc_html / wp_kses_post — U+00A0 is a regular Unicode char, not an entity.
 *
 * Also collapses any stray whitespace. Returns the input unchanged when it
 * has fewer than two words.
 */
function tpa_lp_no_widow( $text ) {
    if ( ! is_string( $text ) || $text === '' ) {
        return $text;
    }
    $trimmed = trim( preg_replace( '/\s+/', ' ', $text ) );
    if ( strpos( $trimmed, ' ' ) === false ) {
        return $trimmed;
    }
    $pos = strrpos( $trimmed, ' ' );
    return substr( $trimmed, 0, $pos ) . "\xC2\xA0" . substr( $trimmed, $pos + 1 );
}

/**
 * Add `page-{post_name}` to <body class="..."> on pages.
 * WP core emits page-id-N and page-template-* but not the slug, and our
 * wp_head hooks (thank-you styling, legal no-anim) rely on slug targeting.
 */
add_filter( 'body_class', function ( $classes ) {
    if ( is_page() ) {
        $slug = get_post_field( 'post_name', get_queried_object_id() );
        if ( $slug ) {
            $classes[] = 'page-' . sanitize_html_class( $slug );
        }
    }
    return $classes;
} );

// Load ACF fields only if ACF is active
if ( function_exists( 'acf_add_local_field_group' ) ) {
    require_once get_template_directory() . '/inc/acf-fields.php';
    require_once get_template_directory() . '/inc/acf-landing-fields.php';
}

/**
 * Enqueue parent theme styles and scripts.
 */
function tpa_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    $version   = filemtime( $theme_dir . '/assets/css/base.css' );

    // CSS
    wp_enqueue_style( 'tpa-base-style', get_stylesheet_uri(), [], $version );
    wp_enqueue_style( 'tpa-base-css', $theme_uri . '/assets/css/base.css', [], $version );
    wp_enqueue_style( 'tpa-nav-css', $theme_uri . '/assets/css/nav.css', [ 'tpa-base-css' ], $version );
    wp_enqueue_style( 'tpa-animations-css', $theme_uri . '/assets/css/animations.css', [ 'tpa-base-css' ], $version );
    wp_enqueue_style( 'tpa-responsive-css', $theme_uri . '/assets/css/responsive.css', [ 'tpa-base-css' ], $version );
    wp_enqueue_style( 'tpa-forms-css', $theme_uri . '/assets/css/forms.css', [ 'tpa-base-css' ], $version );

    // JS — no jQuery dependency, loaded in footer
    wp_enqueue_script( 'tpa-scroll-animations', $theme_uri . '/assets/js/scroll-animations.js', [], $version, true );
    wp_enqueue_script( 'tpa-parallax', $theme_uri . '/assets/js/parallax.js', [], $version, true );
    wp_enqueue_script( 'tpa-nav', $theme_uri . '/assets/js/nav.js', [], $version, true );
}
add_action( 'wp_enqueue_scripts', 'tpa_enqueue_assets' );

/**
 * Get an ACF field value with fallback for when ACF is not active.
 *
 * @param string     $field_name ACF field name.
 * @param int|string $post_id    Post ID or 'option'.
 * @param mixed      $fallback   Fallback value.
 * @return mixed
 */
function tpa_field( $field_name, $post_id = false, $fallback = '' ) {
    if ( function_exists( 'get_field' ) ) {
        $value = get_field( $field_name, $post_id );
        return ( $value !== null && $value !== '' && $value !== false ) ? $value : $fallback;
    }
    return $fallback;
}

/**
 * Enqueue landing page CSS/JS — only on pages using the Landing Page template.
 * Priority 25 runs after child theme dequeue (priority 20).
 */
function tpa_landing_enqueue() {
    if ( ! is_page_template( 'page-landing.php' ) ) {
        return;
    }
    $dir = get_template_directory();
    $uri = get_template_directory_uri();

    wp_enqueue_style(
        'tpa-landing-critical-css',
        $uri . '/assets/css/landing-critical.css',
        [],
        filemtime( $dir . '/assets/css/landing-critical.css' )
    );
    wp_enqueue_style(
        'tpa-landing-css',
        $uri . '/assets/css/landing.css',
        [],
        filemtime( $dir . '/assets/css/landing.css' )
    );
    wp_enqueue_script(
        'tpa-landing-js',
        $uri . '/assets/js/landing.js',
        [],
        filemtime( $dir . '/assets/js/landing.js' ),
        true
    );
}
add_action( 'wp_enqueue_scripts', 'tpa_landing_enqueue', 25 );

