<?php
/**
 * Template part: Therapist bio section.
 *
 * TPA Design Reference: "Where human warmth must be highest."
 * Headshot generously sized. Background should shift to differentiate.
 * Text should feel personal and intimate, not dense. 60-70px padding.
 *
 * Variants:
 *   photo-left   — Two-column grid: photo left, text right
 *   photo-right  — Two-column grid: text left, photo right
 *   banner-top   — Full-width headshot banner, text below
 *
 * Content from ACF fields on front page.
 */

$section     = tpa_current_section();
$variant     = $section['variant'] ?? 'photo-left';
$page_id     = get_option( 'page_on_front' );

$heading     = tpa_field( 'bio_heading', $page_id );
$body        = tpa_field( 'bio_body', $page_id );
$credentials = tpa_field( 'bio_credentials', $page_id );
$quote       = tpa_field( 'bio_quote', $page_id );
$cta_text    = tpa_field( 'bio_cta_text', $page_id, 'Learn More About Me' );
$cta_url     = tpa_field( 'bio_cta_url', $page_id, '/about' );

$headshot    = tpa_get_child_image_url( 'front-bio-headshot' );
if ( ! $headshot ) {
    // Fallback: try without the prefix pattern
    $child_uri = get_stylesheet_directory_uri() . '/assets/images/';
    $child_dir = get_stylesheet_directory() . '/assets/images/';
    if ( file_exists( $child_dir . 'front-bio-headshot.jpg' ) ) {
        $headshot = $child_uri . 'front-bio-headshot.jpg';
    }
}
?>

<section class="bio bio--<?php echo esc_attr( $variant ); ?>">
    <div class="container">

        <?php if ( $variant === 'banner-top' ) : ?>
            <div class="bio-banner" data-anim>
                <?php if ( $headshot ) : ?>
                    <img src="<?php echo esc_url( $headshot ); ?>"
                         alt="<?php echo esc_attr( $heading ); ?>" loading="lazy">
                <?php endif; ?>
            </div>
            <div class="bio-text" data-anim data-delay="200">
                <?php if ( $heading ) : ?><h2><?php echo esc_html( $heading ); ?></h2><?php endif; ?>
                <?php if ( $credentials ) : ?><p class="bio-credentials"><?php echo esc_html( $credentials ); ?></p><?php endif; ?>
                <?php if ( $body ) : ?><div class="bio-body"><?php echo wp_kses_post( $body ); ?></div><?php endif; ?>
                <?php if ( $quote ) : ?><blockquote class="bio-quote"><?php echo esc_html( $quote ); ?></blockquote><?php endif; ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="btn bio-btn"><?php echo esc_html( $cta_text ); ?></a>
            </div>

        <?php else : ?>
            <?php
            // photo-left: photo first in DOM, photo-right: text first in DOM
            $photo_dir = ( $variant === 'photo-left' ) ? 'left' : 'right';
            $text_dir  = ( $variant === 'photo-left' ) ? 'right' : 'left';
            ?>
            <div class="bio-grid bio-grid--<?php echo esc_attr( $variant ); ?>">
                <div class="bio-photo" data-anim data-direction="<?php echo esc_attr( $photo_dir ); ?>">
                    <?php if ( $headshot ) : ?>
                        <img src="<?php echo esc_url( $headshot ); ?>"
                             alt="<?php echo esc_attr( $heading ); ?>" loading="lazy">
                    <?php endif; ?>
                </div>
                <div class="bio-text" data-anim data-direction="<?php echo esc_attr( $text_dir ); ?>" data-delay="200">
                    <?php if ( $heading ) : ?><h2><?php echo esc_html( $heading ); ?></h2><?php endif; ?>
                    <?php if ( $credentials ) : ?><p class="bio-credentials"><?php echo esc_html( $credentials ); ?></p><?php endif; ?>
                    <?php if ( $body ) : ?><div class="bio-body"><?php echo wp_kses_post( $body ); ?></div><?php endif; ?>
                    <?php if ( $quote ) : ?><blockquote class="bio-quote"><?php echo esc_html( $quote ); ?></blockquote><?php endif; ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="btn bio-btn"><?php echo esc_html( $cta_text ); ?></a>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>
