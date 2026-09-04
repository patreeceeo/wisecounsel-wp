<?php
/**
 * Template Name: Landing Page
 *
 * Self-contained landing page — own header, footer, and nav.
 * Not connected to the main site navigation.
 * Uses ACF fields with lp_ prefix for all content.
 * Field mapping (old → new section):
 *   lp_pain_*       → Problem section
 *   lp_authority_*  → Solution section
 *   lp_trust_items  → About pillars
 *   lp_trust_image  → About headshot
 *   lp_cta2_*       → What's Next section
 */

// ── Data ──────────────────────────────────────────────────────
$page_id       = get_the_ID();
$child_img     = get_stylesheet_directory_uri() . '/assets/images/';
$child_dir     = get_stylesheet_directory();

// Header / SEO
$nav_links      = tpa_field('lp_nav_links', $page_id, []);
$phone          = tpa_field('lp_phone_override', $page_id) ?: tpa_field('site_identity_phone', 'option');
$phone_clean    = preg_replace('/[^0-9]/', '', $phone);
$practice_name  = tpa_field('site_identity_practice_name', 'option', get_bloginfo('name'));
$therapist_name = tpa_field('site_identity_therapist_name', 'option', $practice_name);
$pt_url         = tpa_field('social_psychology_today', 'option');
$email          = tpa_field('site_identity_email', 'option');
$seo_title      = tpa_field('lp_seo_title', $page_id, get_the_title());
$seo_desc       = tpa_field('lp_seo_description', $page_id);

// Hero
$hero_eyebrow     = tpa_field('lp_hero_eyebrow', $page_id);
$hero_headline    = tpa_field('lp_hero_headline', $page_id);
$hero_sub         = tpa_field('lp_hero_subheadline', $page_id);
// Convention: copy fields have NO fallbacks — blank hides the element.
// Only wiring keeps defaults (URLs → #form, phone → site option, SEO → page title).
$hero_cta_text    = tpa_field('lp_hero_primary_cta_text', $page_id);
$hero_cta_url     = tpa_field('lp_hero_primary_cta_url', $page_id, '#form');
$hero_sec_text    = tpa_field('lp_hero_secondary_cta_text', $page_id);
$hero_headshot    = tpa_field('lp_hero_headshot', $page_id);
$hero_meta_items  = tpa_field('lp_hero_meta_items', $page_id, []);
$show_bilateral   = tpa_field('lp_show_bilateral', $page_id);
// Use get_post_meta fallback for kicker — tpa_field may miss it on some caching stacks
if ( empty($hero_kicker) ) {
    $hero_kicker = get_post_meta( $page_id, 'lp_hero_kicker', true );
}
// Credit under the headshot. Blank = hidden. ('none' honored as blank for legacy data.)
$_lp_credit_raw   = get_post_meta($page_id, 'lp_hero_credit_name', true);
$hero_credit_name = ($_lp_credit_raw === 'none') ? '' : $_lp_credit_raw;
$hero_credit_tagline = tpa_field('lp_hero_credit_tagline', $page_id);

// Problem (mapped from pain fields)
$prob_eyebrow  = tpa_field('lp_problem_eyebrow', $page_id);
$prob_headline = tpa_field('lp_pain_headline', $page_id);
$prob_body     = tpa_field('lp_pain_body', $page_id);
$prob_symptoms = tpa_field('lp_problem_symptoms', $page_id); // one symptom per line
$prob_image    = tpa_field('lp_pain_image', $page_id);
$prob_floater  = tpa_field('lp_problem_floater_quote', $page_id);
$prob_close    = tpa_field('lp_problem_close', $page_id);

// Mid-page CTA band (optional)

// Solution (mapped from authority fields)
$sol_eyebrow  = tpa_field('lp_solution_eyebrow', $page_id);
$sol_headline = tpa_field('lp_authority_headline', $page_id);
$sol_body     = tpa_field('lp_authority_body', $page_id);
$sol_analogy        = tpa_field('lp_solution_analogy', $page_id);
$sol_benefits_intro = tpa_field('lp_solution_benefits_intro', $page_id);
$sol_benefits       = tpa_field('lp_solution_benefits', $page_id, []); // {label, body}
$sol_image    = tpa_field('lp_authority_image', $page_id);
$sol_float    = tpa_field('lp_solution_float_label', $page_id);
$sol_float_q  = tpa_field('lp_solution_float_quote', $page_id);
$sol_cta_text = tpa_field('lp_solution_cta_text', $page_id);
$sol_cta_url  = tpa_field('lp_solution_cta_url', $page_id, '#form');

// Process
$proc_eyebrow  = tpa_field('lp_process_eyebrow', $page_id);
$proc_headline = tpa_field('lp_process_headline', $page_id);
$proc_intro    = tpa_field('lp_process_intro', $page_id);
$proc_steps    = tpa_field('lp_process_steps', $page_id, []);
$proc_cta_text = tpa_field('lp_process_cta_text', $page_id);
$proc_cta_url  = tpa_field('lp_process_cta_url', $page_id, '#form');

// About (pillars mapped from trust fields; bio is new fields)
$pillars         = tpa_field('lp_trust_items', $page_id, []);   // {title, description}
$pillars_label   = tpa_field('lp_trust_headline', $page_id);
$about_eyebrow   = tpa_field('lp_about_eyebrow', $page_id);
$about_headline  = tpa_field('lp_about_headline', $page_id);
$about_bio       = tpa_field('lp_about_bio', $page_id);
$about_signature = tpa_field('lp_about_signature', $page_id);
$about_creds_raw = tpa_field('lp_about_credentials', $page_id); // textarea, one per line
$about_headshot  = tpa_field('lp_trust_image', $page_id);
$has_about_right = $about_eyebrow || $about_headline || $about_bio || $about_signature || !empty(array_filter(array_map('trim', explode("\n", $about_creds_raw ?? ''))));
$has_about = !empty($pillars) || $about_bio;

// Testimonials
$test_headline = tpa_field('lp_testimonials_headline', $page_id);
$test_intro    = tpa_field('lp_testimonials_intro', $page_id);
$testimonials  = tpa_field('lp_testimonials', $page_id, []);

// FAQ
$faq_eyebrow = tpa_field('lp_faq_eyebrow', $page_id);
$faq_headline = tpa_field('lp_faq_headline', $page_id);
$faq_intro    = tpa_field('lp_faq_intro', $page_id);
$faq_cta_text = tpa_field('lp_faq_cta_text', $page_id);
$faq_cta_url  = tpa_field('lp_faq_cta_url', $page_id, '#form');
$faqs         = tpa_field('lp_faqs', $page_id, []);

// What's Next (mapped from cta2 fields)
$next_eyebrow  = tpa_field('lp_cta2_eyebrow', $page_id);
$next_headline = tpa_field('lp_cta2_headline', $page_id);
$next_lead     = tpa_field('lp_whatnext_lead', $page_id);
$next_steps    = tpa_field('lp_whatnext_steps', $page_id, []); // {title, body}
$next_btn_text = tpa_field('lp_cta2_button_text', $page_id);
$next_btn_url  = tpa_field('lp_cta2_button_url', $page_id, '#form');

// Form
$form_eyebrow    = tpa_field('lp_form_eyebrow', $page_id, "Don't wait");
$form_headline   = tpa_field('lp_form_headline', $page_id);
$form_sub        = tpa_field('lp_form_subheadline', $page_id);
$form_detail     = tpa_field('lp_form_detail', $page_id);
$form_card_title = tpa_field('lp_form_card_title', $page_id);
$form_shortcode  = tpa_field('lp_form_shortcode', $page_id) ?: tpa_field('form_wpforms_shortcode', 'option');

// Fonts — fixed for LP (Philosopher + Lato). Self-hosted when the woff2 files
// are present in tpa-base/assets/fonts (faster: no Google round-trip, no
// render-blocking CSS fetch — the janellerose PSI pattern, now canonical).
// Sites without the font files fall back to Google Fonts unchanged.
$lp_fonts_dir  = get_template_directory() . '/assets/fonts';
$lp_fonts_uri  = get_template_directory_uri() . '/assets/fonts';
$lp_self_fonts = file_exists($lp_fonts_dir . '/philosopher-700-normal.woff2');
$lp_fonts_url  = 'https://fonts.googleapis.com/css2?family=Philosopher:ital,wght@0,400;0,700;1,400;1,700&family=Lato:wght@300;400;700;900&display=swap';

// Bilateral body class
$bilateral_class = $show_bilateral ? ' lp-bilateral-active' : '';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo esc_html($seo_title); ?></title>
  <?php if ($seo_desc): ?>
    <meta name="description" content="<?php echo esc_attr($seo_desc); ?>">
  <?php endif; ?>

  <?php
  // Preload hero headshot if available
  if ($hero_headshot):
    $hero_webp = function_exists('tpa_webp_url') ? tpa_webp_url($hero_headshot, 'child') : null;
    if ($hero_webp): ?>
      <link rel="preload" as="image" type="image/webp" href="<?php echo esc_url($hero_webp); ?>" fetchpriority="high">
    <?php else: ?>
      <link rel="preload" as="image" href="<?php echo esc_url($child_img . $hero_headshot); ?>" fetchpriority="high">
    <?php endif;
  endif;
  // Favicons from child theme
  foreach ([
    ['favicon.svg',     'icon',        'image/svg+xml', ''],
    ['favicon-32x32.png','icon',       'image/png',     'sizes="32x32"'],
    ['favicon-192x192.png','icon',     'image/png',     'sizes="192x192"'],
    ['apple-touch-icon.png','apple-touch-icon','','sizes="180x180"'],
  ] as [$f,$rel,$type,$extra]):
    if (file_exists($child_dir . '/assets/images/' . $f)):
      $ver = filemtime($child_dir . '/assets/images/' . $f);
      echo '<link rel="' . $rel . '"' . ($type ? ' type="' . $type . '"' : '') . ($extra ? ' ' . $extra : '') . ' href="' . esc_url($child_img . $f . '?ver=' . $ver) . '">' . "\n";
    endif;
  endforeach;
  ?>

  <?php if ($lp_self_fonts):
    foreach (['philosopher-700-normal', 'philosopher-400-normal', 'lato-400-normal'] as $f): ?>
    <link rel="preload" as="font" type="font/woff2" crossorigin href="<?php echo esc_url($lp_fonts_uri . '/' . $f . '.woff2'); ?>">
    <?php endforeach; ?>
    <style id="lp-fonts"><?php
      foreach ([
        ['Philosopher', 'normal', 400], ['Philosopher', 'normal', 700],
        ['Philosopher', 'italic', 400], ['Philosopher', 'italic', 700],
        ['Lato', 'normal', 300], ['Lato', 'normal', 400],
        ['Lato', 'normal', 700], ['Lato', 'normal', 900],
      ] as [$fam, $style, $weight]) {
        $file = strtolower($fam) . '-' . $weight . '-' . $style . '.woff2';
        echo "@font-face{font-family:'{$fam}';font-style:{$style};font-weight:{$weight};font-display:swap;"
           . 'src:url(' . esc_url($lp_fonts_uri . '/' . $file) . ") format('woff2');}";
      }
    ?></style>
  <?php else: ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?php echo esc_url($lp_fonts_url); ?>" rel="stylesheet" media="print" onload="this.media='all'">
  <noscript><link href="<?php echo esc_url($lp_fonts_url); ?>" rel="stylesheet"></noscript>
  <?php endif; ?>

  <?php wp_head(); ?>
</head>
<body <?php body_class('landing-page' . $bilateral_class); ?>>
<?php wp_body_open(); ?>

<!-- ══ HEADER ══════════════════════════════════════════════════ -->
<header class="lp-header" role="banner">
  <div class="lp-container lp-header-inner">

    <?php // Logo / brand
    $logo_file = $mark_file = '';
    foreach (['logo.svg','logo.webp','logo.png','logo.jpg'] as $f) {
      if (file_exists($child_dir . '/assets/images/' . $f)) { $logo_file = $f; break; }
    }
    foreach (['logo-mark.svg','logo-mark.webp','logo-mark.png','logo-mark.jpg','brand-logo.png','brand-logo.jpg'] as $f) {
      if (file_exists($child_dir . '/assets/images/' . $f)) { $mark_file = $f; break; }
    }
    if (locate_template('template-parts/lp-brand.php', false, false)):
      get_template_part('template-parts/lp-brand');
    else: ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="lp-brand" aria-label="<?php echo esc_attr($practice_name); ?>">
      <?php if ($logo_file): ?>
        <img src="<?php echo esc_url($child_img . $logo_file); ?>" alt="<?php echo esc_attr($practice_name); ?>" class="lp-logo-img" loading="eager">
      <?php else: ?>
        <?php if ($mark_file): ?>
          <img src="<?php echo esc_url($child_img . $mark_file); ?>" alt="" class="lp-logo-mark" width="44" height="44" loading="eager">
        <?php endif; ?>
        <div>
          <span class="lp-logo"><?php echo esc_html($practice_name); ?></span>
          <?php if ($therapist_name && $therapist_name !== $practice_name): ?>
            <span class="lp-logo-tag"><?php echo esc_html($therapist_name); ?></span>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </a>
    <?php endif; ?>

    <?php if (!empty($nav_links)): ?>
    <nav class="lp-nav" aria-label="Landing page navigation">
      <ul class="lp-nav-links">
        <?php foreach ($nav_links as $link): ?>
          <li><a href="#<?php echo esc_attr($link['anchor_id']); ?>"><?php echo esc_html($link['label']); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <?php if ($phone): ?>
    <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="lp-header-phone">
      <span class="lp-phone-call">Call Today</span>
      <?php echo esc_html($phone); ?>
    </a>
    <?php endif; ?>

    <button class="lp-menu-toggle" aria-label="Open menu" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<!-- Mobile menu -->
<?php if (!empty($nav_links) || $phone): ?>
<div class="lp-mobile-menu" aria-hidden="true">
  <?php if (!empty($nav_links)): ?>
  <ul>
    <?php foreach ($nav_links as $link): ?>
      <li><a href="#<?php echo esc_attr($link['anchor_id']); ?>"><?php echo esc_html($link['label']); ?></a></li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
  <?php if ($phone): ?>
    <a href="tel:<?php echo esc_attr($phone_clean); ?>" class="lp-mobile-phone"><?php echo esc_html($phone); ?></a>
  <?php endif; ?>
</div>
<?php endif; ?>

<main>

<!-- ══ HERO ════════════════════════════════════════════════════ -->
<?php if ($hero_headline): ?>
<section class="lp-hero" id="hero">
  <div class="lp-container lp-hero-grid">

    <div class="lp-hero-text">
      <?php if ($hero_eyebrow): ?>
        <div class="lp-eyebrow lp-reveal d1"><?php echo esc_html($hero_eyebrow); ?></div>
      <?php endif; ?>

      <h1 class="lp-reveal d2"><?php echo wp_kses_post(tpa_lp_no_widow($hero_headline)); ?></h1>

      <?php if ($hero_kicker): ?>
        <div class="lp-hero-tagline lp-reveal d3"><?php echo wp_kses($hero_kicker, ['br' => [], 'em' => [], 'strong' => []]); ?></div>
      <?php endif; ?>

      <?php if ($hero_sub): ?>
        <p class="lp-hero-sub lp-reveal d3"><?php echo wp_kses($hero_sub, ['br' => [], 'span' => ['class' => []], 'em' => [], 'strong' => []]); ?></p>
      <?php endif; ?>

      <!-- Bilateral EMDR animation (shown only when lp_show_bilateral = true) -->
      <div class="lp-bilateral lp-reveal d3" aria-hidden="true">
        <div class="lp-bilateral-track"><div class="lp-bilateral-dot"></div></div>
        <span class="lp-bilateral-tag">Bilateral · Reprocessing</span>
      </div>

      <div class="lp-hero-ctas lp-reveal d4">
        <?php if ($hero_cta_text): ?>
        <a class="lp-btn lp-btn-primary" href="<?php echo esc_url($hero_cta_url); ?>"><?php echo esc_html($hero_cta_text); ?></a>
        <?php endif; ?>
        <?php if ($phone && $hero_sec_text): ?>
        <a class="lp-btn-phone" href="tel:<?php echo esc_attr($phone_clean); ?>">
          <span class="lp-tag"><?php echo esc_html($hero_sec_text); ?></span>
          <span class="lp-num"><?php echo esc_html($phone); ?></span>
        </a>
        <?php endif; ?>
      </div>

      <?php if (!empty($hero_meta_items)): ?>
      <div class="lp-hero-meta lp-reveal d5">
        <?php foreach ($hero_meta_items as $item): ?>
          <div class="lp-hero-meta-item">
            <span class="lp-dot" aria-hidden="true"></span>
            <?php echo esc_html($item['meta_text'] ?? $item['text'] ?? ''); ?>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div><!-- .lp-hero-text -->

    <?php if ($hero_headshot): ?>
    <div class="lp-hero-visual lp-reveal d3">
      <div class="lp-hero-leaf" aria-hidden="true"></div>
      <div class="lp-hero-frame">
        <div class="lp-hero-frame-inner">
          <?php tpa_picture($hero_headshot, esc_attr($therapist_name), [
            'width'        => '500',
            'height'       => '625',
            'loading'      => 'eager',
            'fetchpriority'=> 'high',
          ], 'child'); ?>
        </div>
      </div>
      <?php if ($hero_credit_name): ?>
        <span class="lp-hero-credit"><?php echo esc_html($hero_credit_name); ?></span>
      <?php endif; ?>
      <?php if ($hero_credit_tagline): ?>
        <span class="lp-hero-credit-tagline"><?php echo esc_html($hero_credit_tagline); ?></span>
      <?php endif; ?>
    </div>
    <?php endif; ?>

  </div><!-- .lp-hero-grid -->
</section>
<?php endif; ?>

<!-- (Trust-badges stripe removed from the LP template — 2026-06-29.) -->

<!-- ══ PROBLEM ══════════════════════════════════════════════════ -->
<?php if ($prob_headline || $prob_body): ?>
<section class="lp-section" id="problem">
  <div class="lp-container">
    <div class="lp-problem-grid">

      <div class="lp-problem-copy lp-fade-up">
        <?php if ($prob_eyebrow): ?>
          <div class="lp-eyebrow" style="margin-bottom:14px"><?php echo esc_html($prob_eyebrow); ?></div>
        <?php endif; ?>

        <?php if ($prob_headline): ?>
          <h2><?php echo wp_kses_post(tpa_lp_no_widow($prob_headline)); ?></h2>
        <?php endif; ?>

        <hr class="lp-rule">

        <?php if ($prob_body): ?>
          <div class="lp-problem-body"><?php echo wp_kses_post($prob_body); ?></div>
        <?php endif; ?>

        <?php
        $symptoms = $prob_symptoms ? array_filter(array_map('trim', explode("\n", $prob_symptoms))) : [];
        if (!empty($symptoms)): ?>
        <div class="lp-problem-symptoms">
          <span class="lp-sym-label">If any of this sounds familiar</span>
          <ul>
            <?php foreach ($symptoms as $sym): ?>
              <li><?php echo esc_html($sym); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>

        <?php if ($prob_close): ?>
          <div class="lp-problem-close"><?php echo wp_kses_post($prob_close); ?></div>
        <?php endif; ?>
      </div><!-- .lp-problem-copy -->

      <?php if ($prob_image): ?>
      <div class="lp-problem-visual lp-fade-up">
        <?php tpa_picture($prob_image, '', ['width' => '800', 'height' => '1067', 'loading' => 'lazy'], 'child'); ?>
        <?php if ($prob_floater): ?>
        <div class="lp-problem-floater">
          <p class="lp-floater-q"><?php echo esc_html($prob_floater); ?></p>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

    </div><!-- .lp-problem-grid -->
  </div>
</section>
<?php endif; ?>


<!-- ══ SOLUTION ═════════════════════════════════════════════════ -->
<?php if ($sol_headline || $sol_body): ?>
<section class="lp-section lp-section-warm" id="solution">
  <div class="lp-container">
    <div class="lp-solution-grid">

      <?php if ($sol_image): ?>
      <div class="lp-solution-visual lp-fade-up">
        <?php tpa_picture($sol_image, '', ['width' => '800', 'height' => '1000', 'loading' => 'lazy'], 'child'); ?>
        <?php if ($sol_float_q): ?>
        <div class="lp-solution-float">
          <?php if ($sol_float): ?>
            <div class="lp-float-label"><?php echo esc_html($sol_float); ?></div>
          <?php endif; ?>
          <p class="lp-float-line"><?php echo wp_kses_post($sol_float_q); ?></p>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <div class="lp-solution-copy lp-fade-up">
        <?php if ($sol_eyebrow): ?>
          <div class="lp-eyebrow" style="margin-bottom:14px"><?php echo esc_html($sol_eyebrow); ?></div>
        <?php endif; ?>
        <?php if ($sol_headline): ?>
          <h2><?php echo wp_kses_post(tpa_lp_no_widow($sol_headline)); ?></h2>
        <?php endif; ?>
        <hr class="lp-rule">
        <?php if ($sol_body): ?>
          <div class="lp-solution-body"><?php echo wp_kses_post($sol_body); ?></div>
        <?php endif; ?>
        <?php if ($sol_analogy): ?>
        <div class="lp-solution-analogy">
          <p><?php echo wp_kses_post($sol_analogy); ?></p>
        </div>
        <?php endif; ?>
        <?php if ($sol_benefits_intro): ?>
        <p class="lp-solution-benefits-intro"><?php echo esc_html($sol_benefits_intro); ?></p>
        <?php endif; ?>
        <?php if (!empty($sol_benefits)): ?>
        <ul class="lp-solution-benefits">
          <?php foreach ($sol_benefits as $b): ?>
            <li>
              <?php if (!empty($b['label'])): ?>
                <strong><?php echo esc_html($b['label']); ?></strong>
              <?php endif; ?>
              <?php echo esc_html($b['body'] ?? $b['description'] ?? ''); ?>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if ($sol_cta_text): ?>
          <a href="<?php echo esc_url($sol_cta_url); ?>" class="lp-btn lp-btn-primary"><?php echo esc_html($sol_cta_text); ?></a>
        <?php endif; ?>
      </div>

    </div><!-- .lp-solution-grid -->
  </div>
</section>
<?php endif; ?>

<!-- ══ PROCESS ══════════════════════════════════════════════════ -->
<?php if (!empty($proc_steps)): ?>
<section class="lp-section" id="process">
  <div class="lp-container">
    <div class="lp-process-intro lp-fade-up">
      <?php if ($proc_eyebrow): ?>
        <div class="lp-eyebrow"><?php echo esc_html($proc_eyebrow); ?></div>
      <?php endif; ?>
      <?php if ($proc_headline): ?>
      <h2 style="margin-top:20px"><?php echo wp_kses_post(tpa_lp_no_widow($proc_headline)); ?></h2>
      <?php endif; ?>
      <?php if ($proc_intro): ?>
        <p><?php echo esc_html($proc_intro); ?></p>
      <?php endif; ?>
    </div>

    <div class="lp-process-steps">
      <?php foreach ($proc_steps as $i => $step): ?>
      <div class="lp-process-step lp-fade-up">
        <div class="lp-process-num"><?php printf('%02d', $i + 1); ?><sup>·</sup></div>
        <h3><?php echo esc_html($step['step_title']); ?></h3>
        <div class="lp-step-desc"><?php echo wpautop( wp_kses_post( $step['step_description'] ) ); ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <?php if ($proc_cta_text): ?>
    <div class="lp-process-cta lp-fade-up">
      <a href="<?php echo esc_url($proc_cta_url); ?>" class="lp-btn lp-btn-primary"><?php echo esc_html($proc_cta_text); ?></a>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ══ ABOUT (pillars + bio) ════════════════════════════════════ -->
<?php if ($has_about): ?>
<section class="lp-section lp-about" id="about">
  <div class="lp-container">
    <div class="lp-about-grid<?php echo !$has_about_right ? ' lp-about-grid--pillars-only' : ''; ?>">

      <?php if (!empty($pillars)): ?>
      <div class="lp-about-left lp-fade-up">
        <div class="lp-pillars-wrap">
          <?php if ($pillars_label): ?>
          <div class="lp-pillars-label"><?php echo esc_html($pillars_label); ?></div>
          <?php endif; ?>
          <?php foreach ($pillars as $p): ?>
          <div class="lp-pillar">
            <?php if (!empty($p['title'])): ?>
              <h3><?php echo esc_html($p['title']); ?></h3>
            <?php endif; ?>
            <?php if (!empty($p['description'])): ?>
              <p><?php echo wp_kses_post($p['description']); ?></p>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="lp-about-right lp-fade-up">
        <?php if ($about_eyebrow): ?>
          <div class="lp-eyebrow"><?php echo esc_html($about_eyebrow); ?></div>
        <?php endif; ?>
        <?php if ($about_headshot): ?>
          <div class="lp-about-headshot">
            <?php tpa_picture($about_headshot, '', ['width' => '280', 'height' => '280', 'loading' => 'lazy'], 'child'); ?>
          </div>
        <?php endif; ?>
        <?php if ($about_headline): ?>
          <h2><?php echo wp_kses_post(tpa_lp_no_widow($about_headline)); ?></h2>
        <?php endif; ?>
        <?php if (!$about_headshot): ?><hr class="lp-rule"><?php endif; ?>
        <?php if ($about_bio): ?>
          <div class="lp-about-bio"><?php echo wp_kses_post($about_bio); ?></div>
        <?php endif; ?>
        <?php if ($about_signature): ?>
          <div class="lp-about-signature"><?php echo esc_html($about_signature); ?></div>
        <?php endif; ?>
        <?php
        $creds = $about_creds_raw ? array_filter(array_map('trim', explode("\n", $about_creds_raw))) : [];
        if (!empty($creds)): ?>
        <div class="lp-credentials">
          <h4>Credentials &amp; Training</h4>
          <ul>
            <?php foreach ($creds as $cred): ?>
              <li><?php echo esc_html($cred); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>

    </div><!-- .lp-about-grid -->
  </div>
</section>
<?php endif; ?>

<!-- ══ TESTIMONIALS ═════════════════════════════════════════════ -->
<?php if (!empty($testimonials)): ?>
<section class="lp-section lp-testimonials" id="testimonials">
  <div class="lp-container" style="position:relative">
    <div class="lp-testimonials-intro lp-fade-up">
      <?php if ($test_intro || $test_headline): ?>
        <?php if ($test_headline): ?>
          <h2 style="margin-top:20px"><?php echo wp_kses_post(tpa_lp_no_widow($test_headline)); ?></h2>
        <?php endif; ?>
        <?php if ($test_intro): ?>
          <p><?php echo esc_html($test_intro); ?></p>
        <?php endif; ?>
      <?php endif; ?>
    </div>

    <div class="lp-testimonial-list">
      <?php foreach ($testimonials as $t):
        $name   = !empty($t['name'])   ? $t['name']   : '';
        $detail = !empty($t['detail']) ? $t['detail'] : '';
        $body   = !empty($t['body'])   ? $t['body']   : '';
        $quote  = !empty($t['quote'])  ? $t['quote']  : '';
        $attr   = !empty($t['attribution']) ? $t['attribution'] : '';
        $has_name = !empty($name);
      ?>
      <?php if ($has_name && $body): ?>
      <article class="lp-testimonial lp-fade-up">
        <div class="lp-testimonial-meta">
          <span class="lp-testimonial-name"><?php echo esc_html($name); ?></span>
          <?php if ($detail): ?>
            <span class="lp-testimonial-detail"><?php echo esc_html($detail); ?></span>
          <?php endif; ?>
        </div>
        <div class="lp-testimonial-body"><?php echo wp_kses_post($body); ?></div>
      </article>
      <?php elseif ($quote): ?>
      <div class="lp-testimonial-quote lp-fade-up">
        <em>&ldquo;<?php echo esc_html($quote); ?>&rdquo;</em>
        <?php if ($attr): ?>
          <span class="lp-attribution"><?php echo esc_html($attr); ?></span>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ FAQ ══════════════════════════════════════════════════════ -->
<?php if (!empty($faqs)): ?>
<section class="lp-section" id="faq">
  <div class="lp-container">
    <div class="lp-faq-grid">

      <div class="lp-faq-head lp-fade-up">
        <?php if ($faq_eyebrow): ?>
        <div class="lp-eyebrow"><?php echo esc_html($faq_eyebrow); ?></div>
        <?php endif; ?>
        <?php if ($faq_headline): ?>
        <h2><?php echo wp_kses_post(tpa_lp_no_widow($faq_headline)); ?></h2>
        <?php endif; ?>
        <hr class="lp-rule">
        <?php if ($faq_intro): ?>
          <p><?php echo esc_html($faq_intro); ?></p>
        <?php endif; ?>
        <?php if ($faq_cta_text): ?>
        <a class="lp-btn lp-btn-ghost" href="<?php echo esc_url($faq_cta_url); ?>"><?php echo esc_html($faq_cta_text); ?></a>
        <?php endif; ?>
      </div>

      <div class="lp-faq-list lp-fade-up">
        <?php foreach ($faqs as $i => $faq): ?>
        <details class="lp-faq-item"<?php echo $i === 0 ? ' open' : ''; ?>>
          <summary class="lp-faq-q"><?php echo esc_html($faq['question']); ?></summary>
          <div class="lp-faq-a"><?php echo wp_kses_post($faq['answer']); ?></div>
        </details>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</section>
<?php endif; ?>

<!-- ══ WHAT'S NEXT ═══════════════════════════════════════════════ -->
<?php if ($next_headline || !empty($next_steps)): ?>
<section class="lp-section lp-whatnext" id="next">
  <div class="lp-container" style="position:relative">
    <?php if ($next_eyebrow): ?>
      <div class="lp-eyebrow"><?php echo esc_html($next_eyebrow); ?></div>
    <?php endif; ?>
    <?php if ($next_headline): ?>
      <h2 style="margin-top:20px"><?php echo wp_kses_post(tpa_lp_no_widow($next_headline)); ?></h2>
    <?php endif; ?>
    <?php if ($next_lead): ?>
      <p class="lp-whatnext-lead"><?php echo wp_kses_post($next_lead); ?></p>
    <?php endif; ?>

    <?php if (!empty($next_steps)): ?>
    <div class="lp-whatnext-steps">
      <?php foreach ($next_steps as $i => $step): ?>
      <div class="lp-whatnext-step">
        <div class="lp-whatnext-num"><?php printf('%02d', $i + 1); ?></div>
        <?php if (!empty($step['title'])): ?>
          <h4><?php echo esc_html($step['title']); ?></h4>
        <?php endif; ?>
        <?php if (!empty($step['body'])): ?>
          <p><?php echo wp_kses_post($step['body']); ?></p>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php if ($next_btn_text): ?>
      <div class="lp-whatnext-cta" style="margin-top:36px">
        <a class="lp-btn lp-btn-primary" href="<?php echo esc_url($next_btn_url); ?>"><?php echo esc_html($next_btn_text); ?></a>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- ══ FORM ══════════════════════════════════════════════════════ -->
<?php if ($form_shortcode): ?>
<section class="lp-form-section" id="form">
  <div class="lp-container">
    <div class="lp-form-grid">

      <div class="lp-form-copy lp-fade-up">
        <div class="lp-scarcity">
          <span class="lp-pulse" aria-hidden="true"></span>
          Limited free consults each week
        </div>
        <?php if ($form_eyebrow): ?>
          <div class="lp-eyebrow"><?php echo esc_html($form_eyebrow); ?></div>
        <?php endif; ?>
        <?php if ($form_headline): ?>
          <h2 style="margin-top:24px"><?php echo wp_kses_post(tpa_lp_no_widow($form_headline)); ?></h2>
        <?php endif; ?>
        <hr class="lp-rule">
        <?php if ($form_sub): ?>
          <p><?php echo wp_kses_post($form_sub); ?></p>
        <?php endif; ?>
        <?php if ($form_detail): ?>
          <div class="lp-form-detail"><?php echo wp_kses_post($form_detail); ?></div>
        <?php endif; ?>

        <div class="lp-form-trust">
          <div class="lp-form-trust-item">
            <?php tpa_picture('lp/trust-lock.png', 'Secure', ['class' => 'lp-form-trust-icon', 'loading' => 'lazy'], 'parent'); ?>
            <div class="lp-form-trust-text">
              <h4>100% Secure &amp; Confidential</h4>
              <p>All information is encrypted and protected under HIPAA privacy laws.</p>
            </div>
          </div>
          <div class="lp-form-trust-item">
            <?php tpa_picture('lp/trust-bill.png', 'Payments', ['class' => 'lp-form-trust-icon', 'loading' => 'lazy'], 'parent'); ?>
            <div class="lp-form-trust-text">
              <h4>Payments &amp; Services</h4>
              <p>Out-of-pocket payment accepted. Superbills available for HSA/FSA reimbursement and out-of-network insurance reimbursement.</p>


            </div>
          </div>
        </div>
      </div><!-- .lp-form-copy -->

      <div class="lp-form-card lp-fade-up">
        <?php if ($form_card_title): ?>
        <h3><?php echo esc_html($form_card_title); ?></h3>
        <?php endif; ?>
        <p class="lp-form-sub">Fill out your info below. I&#8217;ll reach out within one business day.</p>
        <?php echo do_shortcode($form_shortcode); ?>
        <p class="lp-form-disclaimer">Your information is encrypted and protected under HIPAA privacy laws. We will never share your details.</p>
      </div>

    </div><!-- .lp-form-grid -->
  </div>
</section>
<?php endif; ?>

</main>

<!-- ══ FOOTER ════════════════════════════════════════════════════ -->
<footer class="lp-footer">
  <div class="lp-container">
    <div class="lp-footer-top">
      <div class="lp-footer-logo">
        <?php
        // Child themes may supply template-parts/lp-footer-brand.php to render a
        // knockout brand lockup (mirrors the header's lp-brand.php hook). Falls
        // back to the auto-detected logo image + practice name when absent.
        if (locate_template('template-parts/lp-footer-brand.php', false, false)):
          get_template_part('template-parts/lp-footer-brand');
        else:
          $footer_logo = $footer_mark = '';
          foreach (['logo.svg','logo.webp','logo.png','logo.jpg'] as $f) {
            if (file_exists($child_dir . '/assets/images/' . $f)) { $footer_logo = $f; break; }
          }
          foreach (['logo-mark.svg','logo-mark.webp','logo-mark.png','logo-mark.jpg','brand-logo.png','brand-logo.jpg'] as $f) {
            if (file_exists($child_dir . '/assets/images/' . $f)) { $footer_mark = $f; break; }
          }
          if ($footer_logo): ?>
            <img src="<?php echo esc_url($child_img . $footer_logo); ?>" alt="<?php echo esc_attr($practice_name); ?>">
          <?php elseif ($footer_mark): ?>
            <img src="<?php echo esc_url($child_img . $footer_mark); ?>" alt="" width="38" height="38">
          <?php endif; ?>
          <div class="lp-footer-name"><?php echo esc_html($practice_name); ?></div>
        <?php endif; ?>
      </div>

      <div class="lp-footer-contact">
        <?php if ($phone): ?>
          <a href="tel:<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($phone); ?></a>
          <span style="opacity:.3">·</span>
        <?php endif; ?>
        <?php if ($email): ?>
          <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        <?php endif; ?>
      </div>
    </div>

    <div class="lp-footer-compliance">
      Free <?php echo esc_html( tpa_field( 'lp_consultation_length', get_the_ID(), '15-minute' ) ); ?> consultations. Session fees are discussed during the call, not collected in advance.
    </div>

    <div class="lp-footer-base">
      <span>&copy; <?php echo esc_html(date('Y') . ' ' . $practice_name); ?></span>
      <div class="lp-footer-legal">
        <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
        <a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>">Terms &amp; Conditions</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
