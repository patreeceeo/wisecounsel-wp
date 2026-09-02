<?php
/**
 * TPA Base — Header template.
 * <head>, nav with WP Menus, mobile hamburger.
 */

$sections_config = tpa_get_sections_config();
$fonts_url       = $sections_config['fonts_url'] ?? '';

$practice_name = tpa_field( 'site_identity_practice_name', 'option', get_bloginfo( 'name' ) );
$phone         = tpa_field( 'site_identity_phone', 'option' );
$phone_clean   = preg_replace( '/[^0-9]/', '', $phone );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if ( $fonts_url ) : ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="<?php echo esc_url( $fonts_url ); ?>" rel="stylesheet">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<nav class="nav" role="navigation" aria-label="<?php esc_attr_e( 'Main navigation', 'tpa-base' ); ?>">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-brand">
        <?php echo esc_html( $practice_name ); ?>
    </a>

    <?php
    wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'nav-links',
        'fallback_cb'    => false,
        'depth'          => 2,
        'walker'         => new TPA_Nav_Walker(),
    ] );
    ?>

    <?php if ( $phone ) : ?>
        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="nav-phone">
            <?php echo esc_html( $phone ); ?>
        </a>
    <?php endif; ?>

    <button class="nav-toggle" aria-label="<?php esc_attr_e( 'Open menu', 'tpa-base' ); ?>" aria-expanded="false">
        <span></span><span></span><span></span>
    </button>
</nav>

<div class="mobile-menu" aria-hidden="true">
    <?php
    wp_nav_menu( [
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'mobile-menu-links',
        'fallback_cb'    => false,
        'depth'          => 2,
    ] );
    ?>
    <?php if ( $phone ) : ?>
        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="mobile-menu-phone">
            <?php echo esc_html( $phone ); ?>
        </a>
    <?php endif; ?>
</div>
