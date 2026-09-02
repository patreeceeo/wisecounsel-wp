<?php
/**
 * Template part: Testimonials section (optional).
 * Only rendered if 'testimonials' appears in sections.json.
 * Content from ACF repeater 'testimonials' on front page.
 */

$page_id      = get_option( 'page_on_front' );
$testimonials = tpa_field( 'testimonials', $page_id, [] );

if ( empty( $testimonials ) || ! is_array( $testimonials ) ) {
    return;
}

$section = tpa_current_section();
$heading = $section['heading'] ?? 'What Clients Say';
?>

<section class="testimonials">
    <div class="container">
        <h2 class="testimonials-heading" data-anim><?php echo esc_html( $heading ); ?></h2>
        <div class="testimonials-list">
            <?php foreach ( $testimonials as $i => $t ) : ?>
                <blockquote class="testimonial" data-anim data-delay="<?php echo $i * 150; ?>">
                    <p class="testimonial-text"><?php echo esc_html( $t['quote'] ?? '' ); ?></p>
                    <?php if ( ! empty( $t['attribution'] ) ) : ?>
                        <cite class="testimonial-cite">&mdash; <?php echo esc_html( $t['attribution'] ); ?></cite>
                    <?php endif; ?>
                </blockquote>
            <?php endforeach; ?>
        </div>
    </div>
</section>
