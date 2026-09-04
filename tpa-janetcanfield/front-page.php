<?php
/**
 * Wise Counsel — Front page ("Wing Split").
 * All copy comes from ACF fields on the front page; images are theme assets.
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$fid       = get_the_ID();

// Hero
$h1_1    = tpa_field('hero_headline_1', $fid, 'You Were Made for');
$h1_2    = tpa_field('hero_headline_2', $fid, 'More Than This');
$kicker  = tpa_field('hero_kicker', $fid, 'Help for Birds of All Feathers');
$tagline = tpa_field('hero_tagline', $fid);
$hcta_t  = tpa_field('hero_cta_text', $fid, 'Request a Consultation');
$hcta_u  = tpa_field('hero_cta_url', $fid, '#contact');

// Bridge
$br_head = tpa_field('bridge_heading', $fid, 'Stop Flying Alone');
$br_body = tpa_field('bridge_body', $fid);

// Text band
$phone      = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_sms  = preg_replace('/[^0-9]/', '', $phone);
$band_text  = tpa_field('band_text', $fid, 'Text Me to Schedule a Free Consultation');
$band_btn   = tpa_field('band_button_text', $fid, $phone);

// Bio
$bio_head = tpa_field('bio_heading', $fid, "Hi, I'm Janet.");
$bio_lead = tpa_field('bio_lead', $fid, "I'm in this for you.");
$bio_body = tpa_field('bio_body', $fid);
$bio_pull = tpa_field('bio_pull', $fid);
$bio_cta_t = tpa_field('bio_cta_text', $fid, 'More About Me');
$bio_cta_u = tpa_field('bio_cta_url', $fid, '/about');
$bio_img   = tpa_field('bio_image', $fid);
$bio_img_url = $bio_img ? (is_array($bio_img) ? $bio_img['url'] : $bio_img) : $child_img . 'front-headshot.jpg';
?>

<!-- ============ HERO ============ -->
<section class="hero" id="main">
  <picture>
    <source media="(max-width: 768px)" srcset="<?php echo esc_url($child_img . 'front-hero-mobile-wm.webp'); ?>" type="image/webp">
    <source media="(min-width: 769px)" srcset="<?php echo esc_url($child_img . 'front-hero-landscape-wm.webp'); ?>" type="image/webp">
    <img class="hero-img" src="<?php echo esc_url($child_img . 'front-hero-wm.jpg'); ?>" width="1200" height="881"
         fetchpriority="high" loading="eager" decoding="async"
         alt="Waterfall cascading through an autumn forest near Asheville, North Carolina">
  </picture>
  <div class="hero-inner">
    <div class="hero-card">
      <h1><?php echo esc_html($h1_1); ?><br><?php echo esc_html($h1_2); ?></h1>
      <?php if ($kicker): ?><div class="hero-kicker"><?php echo esc_html($kicker); ?></div><?php endif; ?>
      <?php if ($tagline): ?><p class="hero-tagline"><?php echo wp_kses_post($tagline); ?></p><?php endif; ?>
      <a class="btn btn-primary btn-hero" href="<?php echo esc_url($hcta_u); ?>"><?php echo esc_html($hcta_t); ?></a>
    </div>
  </div>
</section>

<!-- ============ VIGNETTES ============ -->
<?php
$vignettes = tpa_field('vignettes', $fid);
$vig_layouts = [
    0 => ['class' => 'vig-hiding',   'img' => 'front-vig-hiding-wm', 'alt' => 'A small bird half hidden among tangled branches at dawn', 'side' => 'left'],
    1 => ['class' => 'vig-fog vig-text-only', 'img' => 'front-vig-fog-wm', 'alt' => '', 'side' => 'fog'],
    2 => ['class' => 'vig-storm',    'img' => 'front-vig-storm-wm', 'alt' => 'A swift pressed against a windowpane, unable to fly through', 'side' => 'right'],
    3 => ['class' => 'vig-distress vig-text-only', 'img' => '', 'alt' => '', 'side' => 'distress'],
];
if ($vignettes):
  foreach ($vignettes as $i => $v):
    $L = $vig_layouts[$i] ?? $vig_layouts[0];
    $heading = $v['heading'] ?? '';
    $body    = $v['body'] ?? '';
    $refrain = $v['refrain'] ?? '';
?>
<section class="vignette <?php echo esc_attr($L['class']); ?>">
  <?php if ($L['side'] === 'fog'): ?>
    <?php tpa_picture($L['img'] . '.jpg', '', ['class'=>'fog-bg','width'=>'1100','height'=>'743','loading'=>'lazy','decoding'=>'async']); ?>
  <?php endif; ?>
  <div class="container">
    <?php if ($L['side'] === 'left'): ?>
      <div class="vig-fig"><?php tpa_picture($L['img'] . '.jpg', $L['alt'], ['width'=>'800','height'=>'587','loading'=>'lazy','decoding'=>'async']); ?></div>
    <?php endif; ?>
    <div class="vig-copy">
      <h2><?php echo esc_html($heading); ?></h2>
      <div class="twig" aria-hidden="true"></div>
      <?php echo wp_kses_post($body); ?>
      <?php if ($refrain): ?><div class="refrain"><?php echo esc_html($refrain); ?></div><?php endif; ?>
    </div>
    <?php if ($L['side'] === 'right'): ?>
      <div class="vig-fig"><?php tpa_picture($L['img'] . '.jpg', $L['alt'], ['width'=>'800','height'=>'583','loading'=>'lazy','decoding'=>'async']); ?></div>
    <?php endif; ?>
  </div>
</section>
<?php endforeach; endif; ?>

<!-- ============ BRIDGE ============ -->
<section class="bridge">
  <svg class="bridge-wave" viewBox="0 0 1440 64" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0 38C240 8 480 0 720 14s480 42 720 24" fill="none" stroke="#A68B5B" stroke-width="2" opacity=".85" vector-effect="non-scaling-stroke"/>
  </svg>
  <div class="bridge-fig">
    <?php tpa_picture('front-bridge-wm.jpg', 'A chaffinch in open flight against soft green forest light', ['width'=>'900','height'=>'735','loading'=>'lazy','decoding'=>'async']); ?>
  </div>
  <div class="bridge-inner">
    <h2><?php echo esc_html($br_head); ?></h2>
    <div class="twig" aria-hidden="true"></div>
    <?php echo wp_kses_post($br_body); ?>
  </div>
</section>

<!-- ============ TEXT BAND ============ -->
<section class="text-band">
  <svg class="band-wave" viewBox="0 0 1440 64" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0 38C240 8 480 0 720 14s480 42 720 24" fill="none" stroke="#A68B5B" stroke-width="2" opacity=".85" vector-effect="non-scaling-stroke"/>
  </svg>
  <div class="container">
    <div class="twig" aria-hidden="true"></div>
    <?php if ($band_text): ?><p><?php echo esc_html($band_text); ?></p><?php endif; ?>
    <a class="btn" href="sms:<?php echo esc_attr($phone_sms); ?>"><?php echo esc_html($band_btn); ?></a>
    <div class="twig" aria-hidden="true"></div>
  </div>
</section>

<!-- ============ BIO ============ -->
<section class="bio">
  <div class="container">
    <div class="bio-copy">
      <h2><?php echo esc_html($bio_head); ?></h2>
      <div class="twig" aria-hidden="true"></div>
      <?php if ($bio_lead): ?><p class="bio-lead"><?php echo esc_html($bio_lead); ?></p><?php endif; ?>
      <?php echo wp_kses_post($bio_body); ?>
      <?php if ($bio_pull): ?><div class="bio-pull"><?php echo wp_kses_post($bio_pull); ?></div><?php endif; ?>
      <div class="bio-cta"><a class="btn btn-outline" href="<?php echo esc_url($bio_cta_u); ?>"><?php echo esc_html($bio_cta_t); ?></a></div>
    </div>
    <figure class="bio-fig reveal">
      <?php tpa_janetcanfield_photo($bio_img_url, 'Janet Canfield smiling warmly', ['width'=>'760','height'=>'879','loading'=>'lazy','decoding'=>'async']); ?>
    </figure>
  </div>
</section>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
