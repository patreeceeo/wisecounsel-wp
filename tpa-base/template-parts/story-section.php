<?php
/**
 * Template part: Story section (pain/vignette/body content).
 *
 * This is the most flexible section — the emotional core of the homepage.
 * TPA Design Reference: generous vertical spacing, max ~550px text columns,
 * subtle decorative elements for rhythm between blocks.
 *
 * Variants:
 *   text-panels   — Simple text blocks with headings, body text (most common)
 *   icon-blocks   — Numbered blocks with icon/number + text side-by-side
 *   image-panels  — Alternating image + text, left/right per panel (even/odd)
 *   vignettes     — Narrative client stories with separators and pullquotes
 *   quote-panels  — Text blocks with prominent blockquote callouts
 *
 * Content from ACF repeater field 'story_panels' on the front page.
 */

$section = tpa_current_section();
$variant = $section['variant'] ?? 'text-panels';
$page_id = get_option( 'page_on_front' );
$panels  = tpa_field( 'story_panels', $page_id, [] );

if ( empty( $panels ) || ! is_array( $panels ) ) {
    return;
}
?>

<section class="story-section story-section--<?php echo esc_attr( $variant ); ?>">
    <div class="container">

        <?php foreach ( $panels as $i => $panel ) :
            $headline = $panel['headline'] ?? '';
            $body     = $panel['body_text'] ?? '';
            $quote    = $panel['quote'] ?? '';
            $img_name = $panel['image_name'] ?? '';
            $delay    = $i * 150;
            $num      = str_pad( $i + 1, 2, '0', STR_PAD_LEFT );
            $child_img_uri = get_stylesheet_directory_uri() . '/assets/images/';
        ?>

            <?php if ( $variant === 'text-panels' ) : ?>
                <div class="story-panel" data-anim data-delay="<?php echo $delay; ?>">
                    <?php if ( $headline ) : ?>
                        <h3 class="story-panel-heading"><?php echo esc_html( $headline ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $body ) : ?>
                        <div class="story-panel-body"><?php echo wp_kses_post( $body ); ?></div>
                    <?php endif; ?>
                </div>

            <?php elseif ( $variant === 'icon-blocks' ) : ?>
                <div class="story-block" data-anim data-delay="<?php echo $delay; ?>">
                    <div class="story-block-icon">
                        <span class="story-block-number"><?php echo esc_html( $num ); ?></span>
                    </div>
                    <div class="story-block-content">
                        <?php if ( $headline ) : ?>
                            <h3><?php echo esc_html( $headline ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $body ) : ?>
                            <div><?php echo wp_kses_post( $body ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( $variant === 'image-panels' ) : ?>
                <div class="story-image-panel <?php echo ( $i % 2 === 0 ) ? 'story-image-panel--left' : 'story-image-panel--right'; ?>"
                     data-anim data-direction="<?php echo ( $i % 2 === 0 ) ? 'left' : 'right'; ?>" data-delay="<?php echo $delay; ?>">
                    <?php if ( $img_name ) : ?>
                        <div class="story-image-panel-img">
                            <img src="<?php echo esc_url( $child_img_uri . $img_name ); ?>"
                                 alt="<?php echo esc_attr( $headline ); ?>" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="story-image-panel-text">
                        <?php if ( $headline ) : ?>
                            <h3><?php echo esc_html( $headline ); ?></h3>
                        <?php endif; ?>
                        <?php if ( $body ) : ?>
                            <div><?php echo wp_kses_post( $body ); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

            <?php elseif ( $variant === 'vignettes' ) : ?>
                <div class="story-vignette" data-anim data-delay="<?php echo $delay; ?>">
                    <?php if ( $headline ) : ?>
                        <h3 class="story-vignette-title"><?php echo esc_html( $headline ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $body ) : ?>
                        <div class="story-vignette-body"><?php echo wp_kses_post( $body ); ?></div>
                    <?php endif; ?>
                    <?php if ( $quote ) : ?>
                        <blockquote class="story-vignette-pull"><?php echo esc_html( $quote ); ?></blockquote>
                    <?php endif; ?>
                    <?php if ( $i < count( $panels ) - 1 ) : ?>
                        <div class="story-vignette-sep"></div>
                    <?php endif; ?>
                </div>

            <?php elseif ( $variant === 'quote-panels' ) : ?>
                <div class="story-quote-panel" data-anim data-delay="<?php echo $delay; ?>">
                    <?php if ( $headline ) : ?>
                        <h3><?php echo esc_html( $headline ); ?></h3>
                    <?php endif; ?>
                    <?php if ( $body ) : ?>
                        <div class="story-quote-panel-body"><?php echo wp_kses_post( $body ); ?></div>
                    <?php endif; ?>
                    <?php if ( $quote ) : ?>
                        <blockquote class="story-quote-panel-quote"><?php echo esc_html( $quote ); ?></blockquote>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>

    </div>
</section>
