<?php
/**
 * Default inner page template.
 * Used for FAQ, generic pages, and any page without a specific template.
 *
 * Inner page hero: shorter than homepage hero, with optional background image.
 * Title can display over the hero image or in a band directly below it.
 * Content follows homepage story section patterns but may be plainer.
 */
get_header();

$page_id    = get_the_ID();
// Featured Image is the client-facing override; slug-convention file is the default.
$hero_img   = get_the_post_thumbnail_url( $page_id, 'full' )
    ?: tpa_get_child_image_url( get_post_field( 'post_name', $page_id ) . '-hero' );
$has_hero   = ! empty( $hero_img );
?>

<main class="inner-page">
    <section class="inner-page-hero <?php echo $has_hero ? 'inner-page-hero--image' : 'inner-page-hero--solid'; ?>">
        <?php if ( $has_hero ) : ?>
            <div class="inner-page-hero-bg" data-parallax data-parallax-speed="0.1"
                 style="background-image:url('<?php echo esc_url( $hero_img ); ?>');"></div>
            <div class="inner-page-hero-overlay"></div>
        <?php endif; ?>
        <div class="container">
            <h1 class="inner-page-title"<?php echo tpa_anim_attr(); ?>><?php the_title(); ?></h1>
        </div>
    </section>

    <section class="inner-page-content section">
        <div class="container">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="inner-page-body"<?php echo tpa_anim_attr(); ?>>
                    <?php the_content(); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <?php
    // Final CTA at bottom of every inner page
    set_query_var( 'tpa_section', [ 'variant' => 'form-only' ] );
    get_template_part( 'template-parts/final-cta' );
    ?>
</main>

<?php get_footer(); ?>
