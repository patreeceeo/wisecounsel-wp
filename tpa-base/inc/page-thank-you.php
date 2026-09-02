<?php
/**
 * Template Name: Thank You Page
 *
 * Post-LP-form destination. Uses contact hero image.
 * Auto-detects image filename and adapts to any TPA child theme.
 * No final-cta — this IS the destination.
 *
 * The heading + message render from the page's post_content, so the client
 * can edit the thank-you copy in the WordPress editor (Pages → Thank You).
 * Nothing here is hardcoded prose.
 */
get_header();

$child_dir = get_stylesheet_directory();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';

// Auto-detect contact hero image — try common TPA naming patterns
$hero_candidates = [
    'contact-hero-wm.jpg',
    'contact-hero-wm.webp',
    'contact-hero.jpg',
    'contact-hero.webp',
    'front-hero-landscape-wm.jpg',
    'front-hero-wm.jpg',
];
$hero_jpg  = '';
$hero_webp = '';
foreach ($hero_candidates as $f) {
    $ext = pathinfo($f, PATHINFO_EXTENSION);
    if (!$hero_jpg && $ext === 'jpg' && file_exists($child_dir . '/assets/images/' . $f)) {
        $hero_jpg = $f;
    }
    if (!$hero_webp && $ext === 'webp' && file_exists($child_dir . '/assets/images/' . $f)) {
        $hero_webp = $f;
    }
    if ($hero_jpg && $hero_webp) break;
}
// Try webp-of-jpg fallback
if ($hero_jpg && !$hero_webp) {
    $webp_of_jpg = str_replace('.jpg', '.webp', $hero_jpg);
    if (file_exists($child_dir . '/assets/images/' . $webp_of_jpg)) {
        $hero_webp = $webp_of_jpg;
    }
}
$has_hero = !empty($hero_jpg);
?>

<?php if ($has_hero): ?>
<section class="inner-hero ty-hero">
  <div class="inner-hero-img">
    <picture>
      <?php if ($hero_webp): ?>
      <source srcset="<?php echo esc_url($child_img . $hero_webp); ?>" type="image/webp">
      <?php endif; ?>
      <img src="<?php echo esc_url($child_img . $hero_jpg); ?>"
           alt=""
           loading="eager"
           decoding="async"
           width="1400" height="600">
    </picture>
  </div>
  <div class="container">
    <div class="inner-hero-content">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>
<?php else: ?>
<section class="inner-hero ty-hero ty-hero--plain">
  <div class="container">
    <div class="inner-hero-content">
      <h1><?php the_title(); ?></h1>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="ty-section">
  <div class="container">
    <div class="ty-card">
      <div class="ty-icon" aria-hidden="true">
        <svg viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="28" cy="28" r="27" stroke="currentColor" stroke-width="1.5" opacity=".25"/>
          <path d="M17 28.5l7.5 7.5 14.5-15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <?php
      // Editable in the WordPress editor (Pages → Thank You) — heading + message
      // live in post_content, not hardcoded here.
      $ty_content = get_post_field('post_content', get_the_ID());
      remove_filter('the_content', 'wpautop');
      echo apply_filters('the_content', $ty_content);
      add_filter('the_content', 'wpautop');
      ?>
      <a href="<?php echo esc_url(home_url('/')); ?>" class="ty-home-link">
        &larr; Return to Home
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>

<style>
/* ── THANK YOU PAGE ── */
.ty-hero .inner-hero-img { position: absolute; inset: 0; }
.ty-hero .inner-hero-img picture,
.ty-hero .inner-hero-img img { width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; }
.ty-hero--plain { background: var(--primary, var(--primary-color, #4a6b7a)); }

.ty-section {
  min-height: 480px;
  display: flex;
  align-items: center;
  padding: 80px 0;
  background: var(--white, var(--cream, #F8F5F0));
}
.ty-card {
  max-width: 560px;
  margin: 0 auto;
  text-align: center;
  padding: 64px 48px;
  background: var(--bg, var(--background, #f0ece4));
  border-radius: 16px;
}
.ty-icon {
  width: 56px;
  height: 56px;
  color: var(--accent, var(--secondary, #6F8A63));
  margin: 0 auto 28px;
  display: flex;
  align-items: center;
  justify-content: center;
}
.ty-icon svg { width: 100%; height: 100%; }
.ty-card h2 {
  font-family: var(--font-heading, var(--font-h, 'Georgia', serif));
  font-size: clamp(1.8rem, 3vw, 2.4rem);
  color: var(--text, #2a2a2a);
  margin-bottom: 20px;
  line-height: 1.2;
}
.ty-card p {
  font-family: var(--font-body, var(--font-b, 'sans-serif'));
  font-size: 1.05rem;
  color: var(--text, #2a2a2a);
  opacity: .78;
  line-height: 1.75;
  margin-bottom: 8px;
}
.ty-home-link {
  display: inline-block;
  margin-top: 32px;
  font-family: var(--font-body, var(--font-b, var(--font-nav, 'sans-serif')));
  font-size: 0.9rem;
  font-weight: 600;
  letter-spacing: .06em;
  text-transform: uppercase;
  color: var(--primary, #4a6b7a);
  text-decoration: none;
  border-bottom: 1px solid currentColor;
  padding-bottom: 2px;
  transition: opacity .2s;
}
.ty-home-link:hover { opacity: .65; }

@media (max-width: 600px) {
  .ty-card { padding: 48px 28px; }
  .ty-section { min-height: 400px; padding: 60px 0; }
}
</style>
