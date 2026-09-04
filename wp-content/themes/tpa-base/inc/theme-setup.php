<?php
/**
 * TPA Base — Theme setup: menus, supports, image sizes, CPTs.
 */

function tpa_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
    add_theme_support('custom-logo');

    register_nav_menus([
        'primary' => __('Primary Navigation', 'tpa-base'),
        'footer'  => __('Footer Links', 'tpa-base'),
    ]);

    add_image_size('hero-bg', 1920, 1080, true);
    add_image_size('cta-bg', 1920, 800, true);
    add_image_size('bio-photo', 600, 750, true);
    add_image_size('service-card', 800, 600, true);
}
add_action('after_setup_theme', 'tpa_theme_setup');

/**
 * Service CPT removed (2026-04-21) — services are now regular Pages assigned
 * the `page-service.php` template. Keeping this comment as a breadcrumb for
 * sites that may still have legacy service-typed posts during migration.
 */
