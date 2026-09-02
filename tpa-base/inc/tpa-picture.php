<?php
/**
 * TPA Base — <picture> helper.
 *
 * Emits a <picture> element with a WebP <source> and the original JPG/PNG
 * as the <img> fallback. WebP is autodetected by checking for a sibling
 * .webp file on disk; if no .webp exists, the helper collapses to a plain
 * <img> tag so callers don't have to branch.
 *
 * WebPs are generated at build time by the tpa-dev-site skill's webpify.py
 * (Phase 3.X). Universal browser support is ~96% of mobile traffic, with
 * graceful fallback for the remaining ~4% via the inner <img>.
 *
 * Usage:
 *   tpa_picture( 'front-bio-headshot.jpg', 'Therapist headshot', [
 *       'width'  => '500',
 *       'height' => '500',
 *       'loading' => 'eager',
 *       'fetchpriority' => 'high',
 *   ] );
 *
 *   // Or with a custom base directory (e.g. parent theme images):
 *   tpa_picture( 'lp/secure.png', 'Secure', $attrs, 'parent' );
 *
 * @param string $filename  Image filename relative to base dir (no path prefix).
 * @param string $alt       Alt text. Pass '' for purely decorative images.
 * @param array  $attrs     HTML attrs added to <img>: width, height, loading, etc.
 * @param string $base      'child' (default) or 'parent' — which theme's
 *                          assets/images/ directory to source from.
 * @return void             Echoes the <picture> element.
 */
function tpa_picture( $filename, $alt = '', $attrs = [], $base = 'child' ) {
    if ( $base === 'parent' ) {
        $dir = get_template_directory() . '/assets/images/';
        $uri = get_template_directory_uri() . '/assets/images/';
    } else {
        $dir = get_stylesheet_directory() . '/assets/images/';
        $uri = get_stylesheet_directory_uri() . '/assets/images/';
    }

    $webp     = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $filename );
    $has_webp = ( $webp !== $filename ) && file_exists( $dir . $webp );

    $jpg_ver  = file_exists( $dir . $filename ) ? '?ver=' . filemtime( $dir . $filename ) : '';
    $webp_ver = $has_webp ? '?ver=' . filemtime( $dir . $webp ) : '';

    $attr_str = '';
    foreach ( $attrs as $k => $v ) {
        $attr_str .= ' ' . $k . '="' . esc_attr( $v ) . '"';
    }

    echo '<picture>';
    if ( $has_webp ) {
        echo '<source type="image/webp" srcset="' . esc_url( $uri . $webp . $webp_ver ) . '">';
    }
    echo '<img src="' . esc_url( $uri . $filename . $jpg_ver ) . '" alt="' . esc_attr( $alt ) . '"' . $attr_str . '>';
    echo '</picture>';
}

/**
 * Returns the .webp variant URL of a JPG/PNG if a sibling .webp exists.
 * Used for <link rel="preload" type="image/webp"> in template <head> tags.
 *
 * @param string $filename
 * @param string $base 'child' or 'parent'
 * @return string|null URL to .webp if it exists, else null.
 */
function tpa_webp_url( $filename, $base = 'child' ) {
    if ( $base === 'parent' ) {
        $dir = get_template_directory() . '/assets/images/';
        $uri = get_template_directory_uri() . '/assets/images/';
    } else {
        $dir = get_stylesheet_directory() . '/assets/images/';
        $uri = get_stylesheet_directory_uri() . '/assets/images/';
    }
    $webp = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $filename );
    if ( $webp === $filename || ! file_exists( $dir . $webp ) ) return null;
    return $uri . $webp . '?ver=' . filemtime( $dir . $webp );
}

/**
 * Return an inline style="background-image: ..." attribute that serves
 * a WebP via image-set() to capable browsers and falls back to JPG/PNG
 * for the rest. Used for hero/banner sections that load their image via
 * CSS background-image (where <picture> doesn't apply).
 *
 * Two background-image declarations are intentional — modern browsers
 * use the second (image-set), older ones fall back to the first (url).
 *
 * Usage in templates:
 *   <div class="inner-hero-bg" <?php echo tpa_bg_image_style('about-hero-seaside-wm.jpg'); ?>></div>
 *
 * @param string $filename Image filename relative to base dir.
 * @param string $base 'child' (default) or 'parent'.
 * @return string Full HTML attribute including 'style="..."' or empty if image missing.
 */
function tpa_bg_image_style( $filename, $base = 'child' ) {
    if ( $base === 'parent' ) {
        $dir = get_template_directory() . '/assets/images/';
        $uri = get_template_directory_uri() . '/assets/images/';
    } else {
        $dir = get_stylesheet_directory() . '/assets/images/';
        $uri = get_stylesheet_directory_uri() . '/assets/images/';
    }
    if ( ! file_exists( $dir . $filename ) ) {
        return '';
    }
    $jpg_url = $uri . $filename;
    $webp    = preg_replace( '/\.(jpe?g|png)$/i', '.webp', $filename );
    $has_webp = ( $webp !== $filename ) && file_exists( $dir . $webp );

    if ( ! $has_webp ) {
        return 'style="background-image: url(\'' . esc_url( $jpg_url ) . '\');"';
    }

    $webp_url = $uri . $webp;
    $mime     = ( strtolower( substr( $filename, -4 ) ) === '.png' ) ? 'image/png' : 'image/jpeg';

    // Two declarations — older browsers use first (url), newer use second (image-set).
    return 'style="background-image: url(\'' . esc_url( $jpg_url ) . '\'); '
         . 'background-image: image-set('
         . 'url(\'' . esc_url( $webp_url ) . '\') type(\'image/webp\'), '
         . 'url(\'' . esc_url( $jpg_url ) . '\') type(\'' . $mime . '\')'
         . ');"';
}
