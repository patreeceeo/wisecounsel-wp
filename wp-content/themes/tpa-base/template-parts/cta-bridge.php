<?php
/**
 * Template part: CTA Bridge interstitial.
 *
 * TPA Design Reference: "When the copy shifts from describing pain
 * to offering hope, that's a natural place for a visual shift."
 * 50-60px padding. Full-width background image with overlay.
 *
 * Variants:
 *   centered          — Centered text over background image
 *   split-text-right  — Image fills left, text panel on right
 *   split-text-left   — Image fills right, text panel on left
 *
 * Content from ACF repeater 'cta_bridges' on front page.
 * Instance number determines which repeater row to use.
 */

$section  = tpa_current_section();
$variant  = $section['variant'] ?? 'centered';
$instance = $section['instance'] ?? 1;
$page_id  = get_option( 'page_on_front' );
$bridges  = tpa_field( 'cta_bridges', $page_id, [] );
$bridge   = is_array( $bridges ) ? ( $bridges[ $instance - 1 ] ?? [] ) : [];

if ( empty( $bridge ) ) {
    return;
}

$headline = $bridge['headline'] ?? '';
$body     = $bridge['body_text'] ?? '';
$btn_text = $bridge['button_text'] ?? 'Learn More';
$btn_url  = $bridge['button_url'] ?? '#contact';
$img_url  = tpa_get_child_image_url( 'front-cta' . $instance );
?>

<section class="cta-bridge cta-bridge--<?php echo esc_attr( $variant ); ?>">
    <div class="cta-bridge-bg" data-parallax data-parallax-speed="0.12"
         id="ctaBridge<?php echo esc_attr( $instance ); ?>Bg"
         <?php if ( $img_url ) : ?>style="background-image:url('<?php echo esc_url( $img_url ); ?>');"<?php endif; ?>></div>
    <div class="cta-bridge-overlay"></div>

    <div class="cta-bridge-content container" data-anim>
        <?php if ( $headline ) : ?>
            <h2 class="cta-bridge-heading"><?php echo esc_html( $headline ); ?></h2>
        <?php endif; ?>
        <?php if ( $body ) : ?>
            <p class="cta-bridge-body"><?php echo wp_kses_post( $body ); ?></p>
        <?php endif; ?>
        <a href="<?php echo esc_url( $btn_url ); ?>" class="btn cta-bridge-btn">
            <?php echo esc_html( $btn_text ); ?>
        </a>
    </div>
</section>
