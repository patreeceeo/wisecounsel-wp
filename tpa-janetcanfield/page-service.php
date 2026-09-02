<?php
/**
 * Template Name: Service Page
 * Service / specialty inner page. Hero by slug, editable post_content body.
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$slug      = get_post_field('post_name', get_the_ID());

// Hero image: featured image (via page-overrides) beats ACF hero_image beats slug map.
$hero_map = [
    'individual-therapy' => 'individual-therapy-hero-wm.jpg',
    'lgbtqia-therapy'    => 'lgbtqia-therapy-hero-wm.jpg',
    'relationships'      => 'relationships-hero-wm.jpg',
    'career-counseling'  => 'career-counseling-hero-wm.jpg',
];
$hero_file = isset($hero_map[$slug]) ? $hero_map[$slug] : $slug . '-hero-wm.jpg';
$hero_url  = $child_img . $hero_file;
?>
<main id="main">
  <section class="inner-hero inner-page-hero">
    <?php tpa_janetcanfield_hero_picture($hero_file); ?>
    <div class="inner-hero-content">
      <span class="inner-hero-twig" aria-hidden="true"></span>
      <h1 class="inner-page-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <section class="inner-content service-content">
    <div class="container">
      <div class="service-body">
        <?php
        echo tpa_linkify(tpa_janetcanfield_render_body(get_the_ID()));
        ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
