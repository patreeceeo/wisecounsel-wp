<?php
/**
 * TPA Upload Optimizations — make client uploads as fast as build-time images.
 *
 * The theme's images are pre-sized, pre-compressed, WebP-paired at build time.
 * Client uploads skip all of that, so these filters replicate the pipeline
 * inside WordPress: every image uploaded from wp-admin comes out capped,
 * compressed, and WebP-backed automatically. This is what makes the
 * self-serve controls (Featured Image heroes, logo swap, content images)
 * safe for PageSpeed with zero client training.
 *
 * Applies from install-day forward — existing library items are untouched,
 * and theme-shipped images don't pass through here at all.
 *
 * Requires WebP support in the server's image library (GD/Imagick — standard
 * on PHP 8 hosts). Where absent, WordPress silently falls back to JPEG, so
 * nothing breaks; uploads just stay JPEG.
 *
 * Load guard: required by tpa-base/functions.php AND shipped as an mu-plugin
 * to sites whose tpa-base predates it.
 */

if ( defined( 'TPA_UPLOAD_OPTIMIZATIONS_LOADED' ) ) {
    return;
}
define( 'TPA_UPLOAD_OPTIMIZATIONS_LOADED', true );

// 1. Cap stored dimensions at 1920px (WP default: 2560). Nothing on these
//    sites renders wider than a full-bleed hero.
add_filter( 'big_image_size_threshold', function () {
    return 1920;
} );

// 2. Generate all JPEG-derived subsizes (and the scaled original) as WebP.
//    PNG stays PNG so logo/graphic transparency survives.
add_filter( 'image_editor_output_format', function ( $formats ) {
    $formats['image/jpeg'] = 'image/webp';
    return $formats;
} );

// 3. Compression quality matched to the build pipeline (WP default: 82).
add_filter( 'wp_editor_set_quality', function ( $quality, $mime_type ) {
    return 78;
}, 10, 2 );

// 4. Friendly rejection of absurd uploads — the one case the filters above
//    can't fully absorb (a 40MP original still costs server time and the
//    original file stays on disk).
add_filter( 'wp_handle_upload_prefilter', function ( $file ) {
    $is_image = isset( $file['type'] ) && strpos( $file['type'], 'image/' ) === 0;
    if ( $is_image && isset( $file['size'] ) && $file['size'] > 4 * 1024 * 1024 ) {
        $file['error'] = 'This image is larger than 4MB, which slows the site down for visitors. '
            . 'Please export it smaller (under about 2000px wide as a JPG or PNG) and upload again.';
    }
    return $file;
} );
