<?php
/**
 * TPA Base — Sections Loader.
 * Reads the child theme's sections.json and renders homepage template parts.
 */

/**
 * Get the parsed sections configuration from the child theme.
 *
 * @return array Sections data with 'sections' and 'fonts_url' keys.
 */
function tpa_get_sections_config() {
    static $config = null;
    if ( $config !== null ) {
        return $config;
    }

    $json_path = get_stylesheet_directory() . '/sections.json';

    if ( ! file_exists( $json_path ) ) {
        $config = [ 'sections' => [], 'fonts_url' => '' ];
        return $config;
    }

    $raw    = file_get_contents( $json_path );
    $config = json_decode( $raw, true );

    if ( ! is_array( $config ) ) {
        $config = [ 'sections' => [], 'fonts_url' => '' ];
    }

    return $config;
}

/**
 * Render all homepage sections as defined in sections.json.
 * Called from front-page.php.
 */
function tpa_render_homepage_sections() {
    $config   = tpa_get_sections_config();
    $sections = $config['sections'] ?? [];

    foreach ( $sections as $index => $section ) {
        $part = $section['part'] ?? '';
        if ( empty( $part ) ) {
            continue;
        }

        // Pass section config to template part via query vars
        set_query_var( 'tpa_section', $section );
        set_query_var( 'tpa_section_index', $index );

        get_template_part( 'template-parts/' . sanitize_file_name( $part ) );
    }
}

/**
 * Helper to get current section config inside a template part.
 *
 * @return array Current section config (part, variant, instance, count, etc.)
 */
function tpa_current_section() {
    return get_query_var( 'tpa_section', [] );
}

/**
 * Get child theme image URL by scanning for the image file.
 * Handles both -wm and -final versions.
 *
 * @param string $prefix Image prefix (e.g., 'front-hero', 'front-cta1')
 * @param string $ext    File extension (default: 'jpg')
 * @return string Full URL to the image, or empty string if not found.
 */
function tpa_get_child_image_url( $prefix, $ext = 'jpg' ) {
    $child_dir = get_stylesheet_directory() . '/assets/images/';
    $child_uri = get_stylesheet_directory_uri() . '/assets/images/';

    // Try -final first, then -wm, then without suffix
    $patterns = [
        $child_dir . $prefix . '-*-final.' . $ext,
        $child_dir . $prefix . '-*-wm.' . $ext,
        $child_dir . $prefix . '-*.' . $ext,
        $child_dir . $prefix . '.' . $ext,
    ];

    foreach ( $patterns as $pattern ) {
        $matches = glob( $pattern );
        if ( ! empty( $matches ) ) {
            return $child_uri . basename( $matches[0] );
        }
    }

    return '';
}
