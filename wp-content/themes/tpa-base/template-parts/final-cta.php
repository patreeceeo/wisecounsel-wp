<?php
/**
 * Template part: Final CTA section with contact form.
 *
 * TPA Design Reference: "EVERY homepage must include a contact form."
 * Phone + email MUST be displayed prominently alongside the form.
 * Form max width ~500-550px. Keep compact.
 *
 * Variants:
 *   two-column — Text/contact info left, form right (most common)
 *   centered   — Centered heading, contact row, then centered form
 *   form-only  — Just the heading + form, no body text or side content
 *
 * WPForms embed via ACF field 'form_wpforms_shortcode' on options page.
 */

$section        = tpa_current_section();
$variant        = $section['variant'] ?? 'two-column';
$page_id        = get_option( 'page_on_front' );

$headline       = tpa_field( 'final_cta_headline', $page_id );
$body           = tpa_field( 'final_cta_body', $page_id );
$form_shortcode = tpa_field( 'form_wpforms_shortcode', 'option' );
$phone          = tpa_field( 'site_identity_phone', 'option' );
$email          = tpa_field( 'site_identity_email', 'option' );
$phone_clean    = preg_replace( '/[^0-9]/', '', $phone );
?>

<section class="final-cta final-cta--<?php echo esc_attr( $variant ); ?>" id="contact">
    <?php if ( $variant !== 'form-only' ) : ?>
        <div class="final-cta-bg" data-parallax data-parallax-speed="0.1"
             id="finalCtaBg"></div>
        <div class="final-cta-overlay"></div>
    <?php endif; ?>

    <div class="final-cta-inner container"<?php echo tpa_anim_attr(); ?>>

        <?php if ( $variant === 'two-column' ) : ?>
            <div class="final-cta-grid">
                <div class="final-cta-text">
                    <?php if ( $headline ) : ?><h2><?php echo esc_html( $headline ); ?></h2><?php endif; ?>
                    <?php if ( $body ) : ?><div class="final-cta-body"><?php echo wp_kses_post( $body ); ?></div><?php endif; ?>
                    <?php if ( $phone ) : ?>
                        <p class="final-cta-phone">
                            <a href="tel:<?php echo esc_attr( $phone_clean ); ?>"><?php echo esc_html( $phone ); ?></a>
                        </p>
                    <?php endif; ?>
                    <?php if ( $email ) : ?>
                        <p class="final-cta-email">
                            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                        </p>
                    <?php endif; ?>
                </div>
                <div class="final-cta-form">
                    <?php if ( $form_shortcode ) : echo do_shortcode( $form_shortcode ); endif; ?>
                </div>
            </div>

        <?php elseif ( $variant === 'centered' ) : ?>
            <?php if ( $headline ) : ?><h2 class="text-center"><?php echo esc_html( $headline ); ?></h2><?php endif; ?>
            <?php if ( $body ) : ?><p class="text-center final-cta-body"><?php echo wp_kses_post( $body ); ?></p><?php endif; ?>
            <div class="final-cta-contact-row">
                <?php if ( $phone ) : ?>
                    <a href="tel:<?php echo esc_attr( $phone_clean ); ?>" class="final-cta-contact-link"><?php echo esc_html( $phone ); ?></a>
                <?php endif; ?>
                <?php if ( $email ) : ?>
                    <a href="mailto:<?php echo esc_attr( $email ); ?>" class="final-cta-contact-link"><?php echo esc_html( $email ); ?></a>
                <?php endif; ?>
            </div>
            <div class="final-cta-form final-cta-form--centered">
                <?php if ( $form_shortcode ) : echo do_shortcode( $form_shortcode ); endif; ?>
            </div>

        <?php elseif ( $variant === 'form-only' ) : ?>
            <div class="final-cta-form final-cta-form--centered">
                <?php if ( $headline ) : ?><h2 class="text-center"><?php echo esc_html( $headline ); ?></h2><?php endif; ?>
                <?php if ( $form_shortcode ) : echo do_shortcode( $form_shortcode ); endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
