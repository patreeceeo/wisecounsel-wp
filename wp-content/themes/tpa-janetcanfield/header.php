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
/* ── Fonts ────────────────────────────────────────────────────────────────
 * Self-hosted variable woff2, latin subset (SIL OFL — assets/fonts/LICENSE.txt).
 *
 * Google Fonts put four levels on the critical path:
 *   HTML → litespeed css_async.min.js → fonts.googleapis.com → fonts.gstatic.com
 * and LiteSpeed's CSS-async rewrite parked the <link> inside a <noscript> whose
 * loader never fired, so the live site rendered in system serif/sans with zero
 * @font-face rules. Same-origin woff2 collapses the chain to HTML → woff2 and
 * drops two cross-origin handshakes. Same pattern tpa-base/page-landing.php
 * already calls canonical.
 *
 * Variable files carry the whole 400–700 range the CSS uses (500/600/700 +
 * italics) in one request per family/style instead of one per weight.
 * Non-preloaded faces are fetched lazily by the browser, only if the page
 * actually paints a glyph in them — declaring them costs nothing.
 */
$fonts_dir  = get_stylesheet_directory() . '/assets/fonts';
$fonts_uri  = get_stylesheet_directory_uri() . '/assets/fonts';
$self_fonts = file_exists($fonts_dir . '/figtree-wght-normal.woff2');

// [ family, style, basename, preload? ] — preload only the two faces that paint
// above the fold (body copy + headings). Italics and Caveat load on demand.
$font_faces = [
    ['Figtree',  'normal', 'figtree-wght-normal',  true],
    ['Alegreya', 'normal', 'alegreya-wght-normal', true],
    ['Alegreya', 'italic', 'alegreya-wght-italic', false],
    ['Figtree',  'italic', 'figtree-wght-italic',  false],
];
// FAQ "Field Notes" uses Caveat for handwritten category labels.
if (is_page_template('page-faq.php')) {
    $font_faces[] = ['Caveat', 'normal', 'caveat-wght-normal', false];
}

// Fallback for a deploy where the woff2 files never landed.
$fonts_url = 'https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Figtree:wght@400;500;600'
    . (is_page_template('page-faq.php') ? '&family=Caveat:wght@500;600;700' : '')
    . '&display=swap';
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

    <?php if ($self_fonts):
        // Latin subset range, matching what Google Fonts serves for these families.
        $latin = 'U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,'
               . 'U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,'
               . 'U+2212,U+2215,U+FEFF,U+FFFD';
        foreach ($font_faces as [$fam, $style, $file, $preload]):
            if (!$preload) continue; ?>
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="<?php echo esc_url($fonts_uri . '/' . $file . '.woff2'); ?>">
    <?php endforeach; ?>
    <style id="tpa-fonts" data-no-optimize="1"><?php
        foreach ($font_faces as [$fam, $style, $file, $preload]) {
            $src = $fonts_uri . '/' . $file . '.woff2';
            echo "@font-face{font-family:'{$fam}';font-style:{$style};"
               . "font-weight:400 700;font-display:swap;"
               . "src:url('" . esc_url($src) . "') format('woff2');"
               . "unicode-range:{$latin}}";
        }
    ?></style>
    <?php else: ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="<?php echo esc_url($fonts_url); ?>" rel="stylesheet">
    <?php endif; ?>

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
      <?php // Neither mark is the LCP element — the hero is. Two fetchpriority=high
            // resources dilute the signal, and the cream mark is display:none until
            // .nav.scrolled, so it has no claim on the first viewport at all. ?>
      <?php tpa_picture('logo-mark-ink.png', '', ['class'=>'brand-mark mark-ink','width'=>'143','height'=>'160','decoding'=>'async']); ?>
      <?php tpa_picture('logo-mark-cream.png', '', ['class'=>'brand-mark mark-cream','width'=>'143','height'=>'160','fetchpriority'=>'low','decoding'=>'async']); ?>
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
