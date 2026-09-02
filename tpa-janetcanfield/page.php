<?php
/**
 * Wise Counsel — Generic inner page (Privacy, Terms, Thank You, misc).
 * Hero image auto-detected by slug; body from post_content; final-cta.
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$child_dir = get_stylesheet_directory() . '/assets/images/';
$slug      = get_post_field('post_name', get_the_ID());

// Auto-detect hero: {slug}-hero-wm.jpg, else contact hero as a warm default.
$hero_file = file_exists($child_dir . $slug . '-hero-wm.jpg') ? $slug . '-hero-wm.jpg'
           : (file_exists($child_dir . 'contact-hero-wm.jpg') ? 'contact-hero-wm.jpg' : 'front-hero-wm.jpg');
$hero_url  = $child_img . $hero_file;
$no_cta    = in_array($slug, ['thank-you'], true);
?>
<main id="main">
  <section class="inner-hero inner-page-hero">
    <?php tpa_janetcanfield_hero_picture($hero_file); ?>
    <div class="inner-hero-content">
      <span class="inner-hero-twig" aria-hidden="true"></span>
      <h1 class="inner-page-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <section class="inner-content">
    <div class="container">
      <div class="service-body">
        <?php
        echo tpa_linkify(tpa_janetcanfield_render_body(get_the_ID()));
        ?>
      </div>
    </div>
  </section>

  <?php if (!$no_cta) get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
