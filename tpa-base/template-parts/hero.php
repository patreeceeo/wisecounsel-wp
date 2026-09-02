<?php
/**
 * Template part: Hero section.
 *
 * Variants:
 *   image-bg     — Full-width background image with overlay + centered text
 *   solid-color  — Solid background color (--secondary or --primary), text only
 *   split-layout — Two-column: text left, image right
 *   video        — Autoplay muted video background with overlay + centered text
 *
 * Content from ACF fields on the front page.
 * Hero padding: 60-70px per TPA Design Reference (NOT 100vh).
 */

$section  = tpa_current_section();
$variant  = $section['variant'] ?? 'image-bg';
$page_id  = get_option( 'page_on_front' );

$headline1 = tpa_field( 'hero_headline_1', $page_id );
$headline2 = tpa_field( 'hero_headline_2', $page_id );
$subtitle  = tpa_field( 'hero_subtitle', $page_id );
$location  = tpa_field( 'hero_location', $page_id );
$cta_text  = tpa_field( 'hero_cta_text', $page_id, 'Get Started' );
$cta_url   = tpa_field( 'hero_cta_url', $page_id, '#contact' );

$hero_img  = tpa_get_child_image_url( 'front-hero' );
?>

<section class="hero hero--<?php echo esc_attr( $variant ); ?>">

    <?php if ( $variant === 'image-bg' ) : ?>
        <div class="hero-bg" data-parallax data-parallax-speed="0.15"
             style="background-image:url('<?php echo esc_url( $hero_img ); ?>');"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content container">
            <?php if ( $headline1 ) : ?>
                <div class="hero-rule" data-anim></div>
                <h1 class="hero-title">
                    <span class="hero-line1" data-anim><?php echo esc_html( $headline1 ); ?></span>
                    <?php if ( $headline2 ) : ?>
                        <span class="hero-line2" data-anim data-delay="150"><?php echo esc_html( $headline2 ); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>
            <?php if ( $subtitle ) : ?>
                <p class="hero-sub" data-anim data-delay="300"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $location ) : ?>
                <p class="hero-location" data-anim data-delay="400"><?php echo esc_html( $location ); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" class="btn hero-cta" data-anim data-delay="500">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        </div>

    <?php elseif ( $variant === 'solid-color' ) : ?>
        <div class="hero-content container">
            <?php if ( $headline1 ) : ?>
                <div class="hero-rule" data-anim></div>
                <h1 class="hero-title">
                    <span class="hero-line1" data-anim><?php echo esc_html( $headline1 ); ?></span>
                    <?php if ( $headline2 ) : ?>
                        <span class="hero-line2" data-anim data-delay="150"><?php echo esc_html( $headline2 ); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>
            <?php if ( $subtitle ) : ?>
                <p class="hero-sub" data-anim data-delay="300"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <?php if ( $location ) : ?>
                <p class="hero-location" data-anim data-delay="400"><?php echo esc_html( $location ); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" class="btn hero-cta" data-anim data-delay="500">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        </div>

    <?php elseif ( $variant === 'split-layout' ) : ?>
        <div class="hero-split container">
            <div class="hero-split-text" data-anim data-direction="left">
                <?php if ( $headline1 ) : ?>
                    <h1 class="hero-title">
                        <span class="hero-line1"><?php echo esc_html( $headline1 ); ?></span>
                        <?php if ( $headline2 ) : ?>
                            <span class="hero-line2"><?php echo esc_html( $headline2 ); ?></span>
                        <?php endif; ?>
                    </h1>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="hero-sub"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                <?php if ( $location ) : ?>
                    <p class="hero-location"><?php echo esc_html( $location ); ?></p>
                <?php endif; ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="btn hero-cta">
                    <?php echo esc_html( $cta_text ); ?>
                </a>
            </div>
            <div class="hero-split-image" data-anim data-direction="right">
                <?php if ( $hero_img ) : ?>
                    <img src="<?php echo esc_url( $hero_img ); ?>"
                         alt="<?php echo esc_attr( $headline1 ); ?>" loading="eager">
                <?php endif; ?>
            </div>
        </div>

    <?php elseif ( $variant === 'video' ) : ?>
        <?php
        $poster = tpa_get_child_image_url( 'front-hero-poster' );
        $child_uri = get_stylesheet_directory_uri() . '/assets/images/';
        ?>
        <div class="hero-video-wrap">
            <video class="hero-video" autoplay muted loop playsinline
                   <?php if ( $poster ) : ?>poster="<?php echo esc_url( $poster ); ?>"<?php endif; ?>>
                <source src="<?php echo esc_url( $child_uri . 'front-hero-video.mp4' ); ?>" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content container">
            <?php if ( $headline1 ) : ?>
                <h1 class="hero-title" data-anim>
                    <span class="hero-line1"><?php echo esc_html( $headline1 ); ?></span>
                    <?php if ( $headline2 ) : ?>
                        <span class="hero-line2"><?php echo esc_html( $headline2 ); ?></span>
                    <?php endif; ?>
                </h1>
            <?php endif; ?>
            <?php if ( $subtitle ) : ?>
                <p class="hero-sub" data-anim data-delay="200"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <a href="<?php echo esc_url( $cta_url ); ?>" class="btn hero-cta" data-anim data-delay="400">
                <?php echo esc_html( $cta_text ); ?>
            </a>
        </div>
    <?php endif; ?>

</section>
