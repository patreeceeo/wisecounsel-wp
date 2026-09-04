<?php
/**
 * Blog listing template (WordPress uses home.php for the posts page).
 * Basic blog archive — used by ~1 in 20 clients.
 * Clean, minimal design that matches the site aesthetic.
 */
get_header();
?>

<main class="inner-page blog-page">
    <section class="inner-page-hero inner-page-hero--solid">
        <div class="container">
            <h1 class="inner-page-title" data-anim>Blog</h1>
        </div>
    </section>

    <section class="blog-listing section">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <div class="blog-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <article class="blog-card" data-anim>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php the_permalink(); ?>" class="blog-card-image">
                                    <?php the_post_thumbnail( 'service-card' ); ?>
                                </a>
                            <?php endif; ?>
                            <div class="blog-card-content">
                                <time class="blog-card-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                                <h2 class="blog-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="blog-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 25 ); ?></p>
                                <a href="<?php the_permalink(); ?>" class="blog-card-link">Read More &rarr;</a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <nav class="blog-pagination">
                    <?php
                    the_posts_pagination( [
                        'mid_size'  => 1,
                        'prev_text' => '&larr; Previous',
                        'next_text' => 'Next &rarr;',
                    ] );
                    ?>
                </nav>
            <?php else : ?>
                <p class="blog-empty">No posts yet. Check back soon.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
