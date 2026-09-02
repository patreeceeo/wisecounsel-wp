<?php
/**
 * Template Name: Contact Page
 *
 * Two variants based on whether the practice has an in-person office:
 *   In-person:   Map embed + contact info + contact form
 *   Online-only: Decorative image + contact info + contact form
 */
get_header();

$page_id        = get_the_ID();
$hero_img       = tpa_get_child_image_url( 'contact-hero' );
$has_hero       = ! empty( $hero_img );

$phone          = tpa_field( 'site_identity_phone', 'option' );
$email          = tpa_field( 'site_identity_email', 'option' );
$address        = tpa_field( 'site_identity_address', 'option' );
$phone_clean    = preg_replace( '/[^0-9]/', '', $phone );
$form_shortcode = tpa_field( 'form_wpforms_shortcode', 'option' );

// Map embed URL (set via ACF on this page)
$map_embed_url  = tpa_field( 'contact_map_embed_url', $page_id );
$has_map        = ! empty( $map_embed_url );

// Decorative image for online-only practices
$contact_img    = tpa_get_child_image_url( 'contact-side' );
?>

<main class="inner-page contact-page">
    <section class="inner-page-hero <?php echo $has_hero ? 'inner-page-hero--image' : 'inner-page-hero--solid'; ?>">
        <?php if ( $has_hero ) : ?>
            <div class="inner-page-hero-bg" data-parallax data-parallax-speed="0.1"
                 style="background-image:url('<?php echo esc_url( $hero_img ); ?>');"></div>
            <div class="inner-page-hero-overlay"></div>
        <?php endif; ?>
        <div class="container">
            <h1 class="inner-page-title" data-anim><?php the_title(); ?></h1>
        </div>
    </section>

    <?php if ( get_the_content() ) : ?>
        <section class="inner-page-content section">
            <div class="container">
                <div class="inner-page-body" data-anim>
                    <?php the_content(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="contact-main section">
        <div class="container">
            <div class="contact-grid">
                <div class="contact-info-side" data-anim data-direction="left">
                    <div class="contact-details">
                        <h2>Get in Touch</h2>
                        <?php if ( $phone ) : ?>
                            <p class="contact-phone">
                                <a href="tel:<?php echo esc_attr( $phone_clean ); ?>"><?php echo esc_html( $phone ); ?></a>
                            </p>
                        <?php endif; ?>
                        <?php if ( $email ) : ?>
                            <p class="contact-email">
                                <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                            </p>
                        <?php endif; ?>
                        <?php if ( $address ) : ?>
                            <p class="contact-address"><?php echo nl2br( esc_html( $address ) ); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if ( $has_map ) : ?>
                        <div class="contact-map">
                            <iframe src="<?php echo esc_url( $map_embed_url ); ?>"
                                    width="100%" height="300" style="border:0;"
                                    allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    <?php elseif ( $contact_img ) : ?>
                        <div class="contact-side-image">
                            <img src="<?php echo esc_url( $contact_img ); ?>"
                                 alt="Contact" loading="lazy">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="contact-form-side" data-anim data-direction="right" data-delay="200">
                    <?php if ( $form_shortcode ) : ?>
                        <?php echo do_shortcode( $form_shortcode ); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
