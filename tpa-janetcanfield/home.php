<?php
/**
 * Wise Counsel — Blog index.
 */
get_header();
$blog_id = get_option('page_for_posts');
$title   = $blog_id ? get_the_title($blog_id) : 'Blog';
?>
<main id="main">
  <section class="blog-hero">
    <div class="container">
      <h1><?php echo esc_html($title); ?></h1>
      <p class="blog-lede">Notes on healing, hope, and finding your way through.</p>
    </div>
  </section>

  <div class="blog-list">
    <?php if (have_posts()): while (have_posts()): the_post(); ?>
      <article class="blog-card">
        <div class="blog-card__date"><?php echo esc_html(get_the_date()); ?></div>
        <h2 class="blog-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <div class="blog-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 34)); ?></div>
        <a class="blog-more" href="<?php the_permalink(); ?>">Continue reading &rarr;</a>
      </article>
    <?php endwhile; ?>
      <div class="blog-pagination"><?php echo paginate_links(['type' => 'list']); ?></div>
    <?php else: ?>
      <p>No posts yet &ndash; check back soon.</p>
    <?php endif; ?>
  </div>

  <?php get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
