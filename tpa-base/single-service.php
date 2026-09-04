<?php
/**
 * Single service/specialty page template.
 *
 * Consistent design across all Services and Specialties pages:
 * shorter hero with background image, title, subtitle,
 * then content body (similar to story section but plainer),
 * then a CTA at the bottom.
 */
get_header();

$subtitle  = tpa_field( 'service_subtitle' );
$hero_img  = '';

// Try to find a hero image for this specific service
if ( has_post_thumbnail() ) {
    $hero_img = get_the_post_thumbnail_url( get_the_ID(), 'hero-bg' );
}
$has_hero = ! empty( $hero_img );
?>

<main class="inner-page service-page">
    <section class="inner-page-hero <?php echo $has_hero ? 'inner-page-hero--image' : 'inner-page-hero--solid'; ?>">
        <?php if ( $has_hero ) : ?>
            <div class="inner-page-hero-bg" data-parallax data-parallax-speed="0.1"
                 style="background-image:url('<?php echo esc_url( $hero_img ); ?>');"></div>
            <div class="inner-page-hero-overlay"></div>
        <?php endif; ?>
        <div class="container">
            <h1 class="inner-page-title" data-anim><?php the_title(); ?></h1>
            <?php if ( $subtitle ) : ?>
                <p class="inner-page-subtitle" data-anim data-delay="150"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="inner-page-content section">
        <div class="container">
            <div class="inner-page-body" data-anim>
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <?php
    // CTA at bottom of every service page
    set_query_var( 'tpa_section', [ 'variant' => 'centered' ] );
    get_template_part( 'template-parts/final-cta' );
    ?>
</main>

<?php get_footer(); ?>
