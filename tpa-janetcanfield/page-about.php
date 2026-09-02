<?php
/**
 * Template Name: About Page
 * Journey design (dashed spine + gold nodes, no images) for the therapy arc,
 * a featured "About Janet" section on its own dark-sage background, and a
 * closing CTA. All content is ACF-editable.
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$child_dir = get_stylesheet_directory() . '/assets/images/';
$id        = get_the_ID();

$journey   = tpa_field('journey_steps', $id, []);
$bio_head  = tpa_field('about_bio_heading', $id, 'About Janet Canfield, MA');
$bio_lead  = tpa_field('about_bio_lead', $id);
$bio_body  = tpa_field('about_bio', $id);
$bio_img   = tpa_field('about_bio_image', $id);
$bio_img_url = $bio_img ? (is_array($bio_img) ? $bio_img['url'] : $bio_img) : $child_img . 'front-headshot.jpg';
$cta_head  = tpa_field('about_cta_heading', $id);
$cta_body  = tpa_field('about_cta_body', $id);

$hero_file = file_exists($child_dir . 'about-hero-wm.jpg') ? 'about-hero-wm.jpg' : 'front-hero-wm.jpg';
$phone_sms = preg_replace('/[^0-9]/', '', tpa_field('site_identity_phone', 'option', '(828) 222-0809'));
?>
<main id="main">
  <section class="inner-hero inner-page-hero">
    <?php tpa_janetcanfield_hero_picture($hero_file); ?>
    <div class="inner-hero-content">
      <span class="inner-hero-twig" aria-hidden="true"></span>
      <h1 class="inner-page-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <?php if ($journey): ?>
  <section class="inner-content">
    <div class="container">
      <div class="journey-intro">
        <span class="twig" aria-hidden="true"></span>
        <h2>What Working Together Looks Like</h2>
      </div>
      <div class="journey">
        <?php foreach ($journey as $i => $step): ?>
        <div class="journey-step">
          <span class="journey-node" aria-hidden="true"><?php echo (int)$i + 1; ?></span>
          <div class="journey-card">
            <h3><?php echo esc_html($step['title'] ?? ''); ?></h3>
            <?php echo tpa_linkify(wp_kses_post($step['body'] ?? '')); ?>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($bio_body || $bio_head): ?>
  <section class="about-janet">
    <div class="container">
      <div class="about-janet-grid">
        <figure class="about-janet-portrait">
          <?php tpa_janetcanfield_photo($bio_img_url, 'Janet Canfield', ['width'=>'300','height'=>'336','loading'=>'lazy','decoding'=>'async']); ?>
        </figure>
        <div class="about-janet-copy">
          <span class="twig" aria-hidden="true"></span>
          <?php if ($bio_head): ?><h2><?php echo esc_html($bio_head); ?></h2><?php endif; ?>
          <?php if ($bio_lead): ?><p class="aj-lead"><?php echo wp_kses_post($bio_lead); ?></p><?php endif; ?>
          <?php echo tpa_linkify(wp_kses_post($bio_body)); ?>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php if ($cta_body || $cta_head): ?>
  <section class="inner-content about-close">
    <div class="container">
      <div class="service-body">
        <div class="svc-close-cta">
          <span class="twig" aria-hidden="true"></span>
          <?php if ($cta_head): ?><h2><?php echo esc_html($cta_head); ?></h2><?php endif; ?>
          <?php echo tpa_linkify(wp_kses_post($cta_body)); ?>
          <div class="svc-cta-btns">
            <a class="svc-cta-btn svc-cta-btn-gold" href="sms:<?php echo esc_attr($phone_sms); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>Text Me &middot; (828) 222-0809</a>
            <a class="svc-cta-btn svc-cta-btn-ghost" href="mailto:janet.e.canfield@gmail.com">Email Me</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <?php get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
