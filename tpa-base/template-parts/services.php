<?php
/**
 * Template part: Services listing section.
 *
 * TPA Design Reference: "THIS IS THE SINGLE WORST SECTION IN EVERY MOCKUP."
 * A plain grid of rectangular image cards is NOT acceptable.
 * Every services section must use a genuinely creative layout.
 *
 * Variants:
 *   text-rows      — Simple text rows with service name + arrow link
 *   numbered-rows  — Numbered items (01, 02, ...) with description
 *   cards          — Text-only cards (no images) with title + description
 *   image-cards    — Cards with featured images + text overlay/content
 *   accordion      — Expandable <details> elements with title + description
 *
 * Content from the 'service' custom post type.
 */

$section = tpa_current_section();
$variant = $section['variant'] ?? 'cards';
$page_id = get_option( 'page_on_front' );

$services_heading = tpa_field( 'services_heading', $page_id, 'What I Offer' );

$services = get_posts( [
    'post_type'      => 'service',
    'posts_per_page' => -1,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );

if ( empty( $services ) ) {
    return;
}
?>

<section class="services services--<?php echo esc_attr( $variant ); ?>">
    <div class="container">
        <?php if ( $services_heading ) : ?>
            <h2 class="services-heading" data-anim><?php echo esc_html( $services_heading ); ?></h2>
        <?php endif; ?>

        <div class="services-list">
            <?php foreach ( $services as $i => $svc ) :
                $title     = $svc->post_title;
                $excerpt   = $svc->post_excerpt ?: wp_trim_words( $svc->post_content, 25 );
                $link      = get_permalink( $svc );
                $link_text = tpa_field( 'service_link_text', $svc->ID, 'Learn More' );
                $delay     = $i * 100;
                $num       = str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
            ?>

                <?php if ( $variant === 'text-rows' ) : ?>
                    <div class="svc-row" data-anim data-delay="<?php echo $delay; ?>">
                        <span class="svc-name"><?php echo esc_html( $title ); ?></span>
                        <a href="<?php echo esc_url( $link ); ?>" class="svc-link"><?php echo esc_html( $link_text ); ?> &rarr;</a>
                    </div>

                <?php elseif ( $variant === 'numbered-rows' ) : ?>
                    <div class="svc-numbered" data-anim data-delay="<?php echo $delay; ?>">
                        <span class="svc-num"><?php echo esc_html( $num ); ?></span>
                        <div class="svc-numbered-content">
                            <h3 class="svc-name"><?php echo esc_html( $title ); ?></h3>
                            <p class="svc-desc"><?php echo esc_html( $excerpt ); ?></p>
                        </div>
                        <a href="<?php echo esc_url( $link ); ?>" class="svc-link"><?php echo esc_html( $link_text ); ?> &rarr;</a>
                    </div>

                <?php elseif ( $variant === 'cards' ) : ?>
                    <div class="svc-card" data-anim data-direction="scale" data-delay="<?php echo $delay; ?>">
                        <h3 class="svc-card-title"><?php echo esc_html( $title ); ?></h3>
                        <p class="svc-card-desc"><?php echo esc_html( $excerpt ); ?></p>
                        <a href="<?php echo esc_url( $link ); ?>" class="svc-card-link"><?php echo esc_html( $link_text ); ?> &rarr;</a>
                    </div>

                <?php elseif ( $variant === 'image-cards' ) : ?>
                    <div class="svc-image-card" data-anim data-direction="scale" data-delay="<?php echo $delay; ?>">
                        <?php if ( has_post_thumbnail( $svc->ID ) ) : ?>
                            <div class="svc-image-card-img">
                                <?php echo get_the_post_thumbnail( $svc->ID, 'service-card' ); ?>
                            </div>
                        <?php endif; ?>
                        <div class="svc-image-card-content">
                            <h3><?php echo esc_html( $title ); ?></h3>
                            <p><?php echo esc_html( $excerpt ); ?></p>
                            <a href="<?php echo esc_url( $link ); ?>" class="svc-card-link"><?php echo esc_html( $link_text ); ?> &rarr;</a>
                        </div>
                    </div>

                <?php elseif ( $variant === 'accordion' ) : ?>
                    <details class="svc-accordion" data-anim data-delay="<?php echo $delay; ?>">
                        <summary class="svc-accordion-title">
                            <span class="svc-num"><?php echo esc_html( $num ); ?></span>
                            <?php echo esc_html( $title ); ?>
                        </summary>
                        <div class="svc-accordion-body">
                            <p><?php echo esc_html( $excerpt ); ?></p>
                            <a href="<?php echo esc_url( $link ); ?>" class="btn svc-accordion-btn"><?php echo esc_html( $link_text ); ?></a>
                        </div>
                    </details>
                <?php endif; ?>

            <?php endforeach; ?>
        </div>
    </div>
</section>
