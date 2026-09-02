<?php
/**
 * Template hierarchy fallback. WP requires every theme (including parent-only
 * themes) to ship index.php; without it, Appearance → Themes flags the theme
 * as broken and shows "The active theme is broken. Reverting to the default
 * theme." even when children are working fine.
 *
 * Routing today: front-page.php (home), page-*.php + page.php (inner pages),
 * single-*.php + single.php (posts). Nothing on a TPA site should actually
 * route here — but if it ever does (e.g. archive with no archive.php), render
 * a sensible body.
 */
get_header(); ?>

<main class="inner-page">
    <section class="inner-page-content section">
        <div class="container">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <article class="inner-page-body">
                        <h1><?php the_title(); ?></h1>
                        <?php the_content(); ?>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p><?php esc_html_e( 'Nothing found.', 'tpa-base' ); ?></p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
