<?php
/**
 * Wise Counsel — Header.
 * Bespoke "Wise Counsel" nav: dual owl mark (walnut → cream on scroll),
 * wordmark + tagline, centered links, SMS phone chip, Free Consultation pill.
 */
$child_img   = get_stylesheet_directory_uri() . '/assets/images/';
$practice    = tpa_field('site_identity_practice_name', 'option', 'Wise Counsel');
$phone       = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_clean = preg_replace('/[^0-9]/', '', $phone);
$is_front    = is_front_page();
$fonts_url   = 'https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Figtree:wght@400;500;600&display=swap';
// FAQ "Field Notes" uses Caveat for handwritten category labels.
if (is_page_template('page-faq.php')) {
    $fonts_url = 'https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Figtree:wght@400;500;600&family=Caveat:wght@500;600;700&display=swap';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" sizes="64x64" href="<?php echo esc_url($child_img . 'favicon-64.png'); ?>">
    <link rel="apple-touch-icon" href="<?php echo esc_url($child_img . 'favicon-180.png'); ?>">

    <?php if ($is_front): ?>
        <link rel="preload" as="image" media="(max-width: 768px)"
              href="<?php echo esc_url($child_img . 'front-hero-mobile-wm.webp'); ?>"
              type="image/webp" fetchpriority="high">
        <link rel="preload" as="image" media="(min-width: 769px)"
              href="<?php echo esc_url($child_img . 'front-hero-landscape-wm.webp'); ?>"
              type="image/webp" fetchpriority="high">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo esc_url($fonts_url); ?>" rel="stylesheet" media="print" onload="this.media='all'">
    <noscript><link href="<?php echo esc_url($fonts_url); ?>" rel="stylesheet"></noscript>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">Skip to content</a>
<header class="nav">
  <div class="nav-inner">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php echo esc_attr($practice); ?> home">
      <?php // Marks render at most 58px tall, so the assets are 143x160 (2.7x) and
            // go through <picture> for the alpha-preserving WebP. ?>
      <?php tpa_picture('logo-mark-ink.png', '', ['class'=>'brand-mark mark-ink','width'=>'143','height'=>'160','fetchpriority'=>'high','decoding'=>'async']); ?>
      <?php tpa_picture('logo-mark-cream.png', '', ['class'=>'brand-mark mark-cream','width'=>'143','height'=>'160','decoding'=>'async']); ?>
      <span class="brand-text">
        <span class="brand-name">wise <span>counsel</span></span>
        <span class="brand-tag">Janet Canfield &middot; Asheville, NC</span>
      </span>
    </a>
    <nav aria-label="Primary">
      <?php
      // Janet prefers text. The drawer carries the phone CTA on mobile so the
      // header bar itself stays clean (no icon crowding the wordmark).
      $drawer_cta = '<li class="nav-drawer-cta"><a class="drawer-phone" href="sms:' . esc_attr($phone_clean) . '">'
          . '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .35 2 .7 2.9a2 2 0 0 1-.45 2.1L8.1 10a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.45c.9.35 1.9.6 2.9.7a2 2 0 0 1 1.7 2Z"/></svg>'
          . '<span>Text ' . esc_html($phone) . '</span></a></li>';

      wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'nav-links',
          'menu_id'        => 'navLinks',
          'fallback_cb'    => false,
          'depth'          => 2,
          'walker'         => new TPA_Nav_Walker(),
          'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s' . $drawer_cta . '</ul>',
      ]);
      ?>
    </nav>
    <a class="nav-phone" href="sms:<?php echo esc_attr($phone_clean); ?>" aria-label="Text <?php echo esc_attr($phone); ?>">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .35 2 .7 2.9a2 2 0 0 1-.45 2.1L8.1 10a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.45c.9.35 1.9.6 2.9.7a2 2 0 0 1 1.7 2Z"/></svg>
      <span class="nav-phone-num"><?php echo esc_html($phone); ?></span>
    </a>
    <a class="nav-cta" href="#contact">Free Consultation</a>
    <button class="hamburger" id="hamburger" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
