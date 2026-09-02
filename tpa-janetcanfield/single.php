<?php
/**
 * Wise Counsel — Single blog post.
 */
get_header();
$blog_url = get_permalink(get_option('page_for_posts'));
?>
<main id="main">
  <?php if (have_posts()): while (have_posts()): the_post();
    $words = str_word_count(wp_strip_all_tags(get_the_content()));
    $mins  = max(1, round($words / 220));
  ?>
  <article class="single-post">
    <a class="post-back" href="<?php echo esc_url($blog_url); ?>">&larr; Back to the blog</a>
    <div class="post-meta"><?php echo esc_html(get_the_date()); ?> &middot; <?php echo esc_html($mins); ?> min read</div>
    <h1><?php the_title(); ?></h1>
    <div class="post-body">
      <?php the_content(); ?>
    </div>
  </article>
  <?php endwhile; endif; ?>

  <?php get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
