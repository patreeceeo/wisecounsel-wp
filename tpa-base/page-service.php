<?php
/**
 * Template Name: Service Page
 *
 * Universal inner-page template for service/specialty pages.
 * Services are regular Pages — no CPT. Child themes can override this file
 * by creating their own page-service.php.
 */
get_header();

$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$slug      = get_post_field('post_name', get_the_ID());

$hero_thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
$hero_acf   = function_exists('get_field') ? get_field('hero_image') : '';
if ($hero_thumb) {
    // Featured Image = client self-serve override, beats ACF field and slug file.
    $hero_url = $hero_thumb;
    $has_hero = true;
} elseif (is_string($hero_acf) && $hero_acf !== '') {
    $hero_url = $hero_acf;
    $has_hero = true;
} else {
    $hero_path = get_stylesheet_directory() . '/assets/images/' . $slug . '-hero-wm.jpg';
    $has_hero  = file_exists($hero_path);
    $hero_url  = $has_hero ? $child_img . $slug . '-hero-wm.jpg' : '';
}

$subtitle = function_exists('get_field') ? get_field('service_subtitle') : '';
?>

<?php if ($has_hero): ?>
<section class="inner-hero inner-hero--image">
  <div class="inner-hero-bg" style="background-image:url('<?php echo esc_url($hero_url); ?>');"></div>
  <div class="inner-hero-overlay"></div>
  <div class="inner-hero-content fade-in">
    <h1><?php the_title(); ?></h1>
    <?php if ($subtitle): ?><p class="subtitle"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
  </div>
</section>
<?php else: ?>
<section class="inner-hero inner-hero-plain">
  <div class="inner-hero-content fade-in">
    <h1><?php the_title(); ?></h1>
    <?php if ($subtitle): ?><p class="subtitle"><?php echo esc_html($subtitle); ?></p><?php endif; ?>
  </div>
</section>
<?php endif; ?>

<main class="container">
  <div class="inner-content fade-in">
    <?php
    // wpautop MUST stay enabled here. It converts blank-line-separated text
    // into <p> tags at render time. When a team member edits this page in the
    // WordPress editor and saves, the editor strips the machine-populated <p>
    // tags and stores paragraphs as blank-line text — relying on wpautop to
    // re-wrap them. Disabling wpautop made saved edits collapse into one clump.
    // wpautop leaves existing <p> alone and does NOT wrap block-level elements
    // (the svc-img-section divs), so it's safe for populated and edited content.
    $raw = get_post_field('post_content', get_the_ID());
    $replaced = str_replace('{{IMG_BASE}}', esc_url($child_img), $raw);
    echo apply_filters('the_content', $replaced);
    ?>
  </div>
</main>

<?php get_template_part('template-parts/final-cta'); ?>

<?php get_footer(); ?>
