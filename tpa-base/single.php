<?php
/**
 * Single blog post template.
 * Clean, readable layout focused on the content.
 */
get_header();
?>

<main class="inner-page single-post-page">
    <section class="inner-page-hero inner-page-hero--solid">
        <div class="container">
            <time class="single-post-date" datetime="<?php echo get_the_date( 'c' ); ?>">
                <?php echo get_the_date(); ?>
            </time>
            <h1 class="inner-page-title" data-anim><?php the_title(); ?></h1>
        </div>
    </section>

    <article class="single-post-content section">
        <div class="container">
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="single-post-featured" data-anim>
                    <?php the_post_thumbnail( 'hero-bg' ); ?>
                </div>
            <?php endif; ?>

            <div class="single-post-body" data-anim>
                <?php the_content(); ?>
            </div>

            <nav class="single-post-nav">
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                ?>
                <?php if ( $prev ) : ?>
                    <a href="<?php echo get_permalink( $prev ); ?>" class="single-post-nav-link single-post-nav-prev">
                        &larr; <?php echo esc_html( $prev->post_title ); ?>
                    </a>
                <?php endif; ?>
                <?php if ( $next ) : ?>
                    <a href="<?php echo get_permalink( $next ); ?>" class="single-post-nav-link single-post-nav-next">
                        <?php echo esc_html( $next->post_title ); ?> &rarr;
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </article>
</main>

<?php get_footer(); ?>
