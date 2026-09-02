<?php
/**
 * Template Name: About Page
 *
 * About page with bio section and optional team bios for group practices.
 * Hero image (shorter than homepage), title, narrative content,
 * therapist bio section, optional team member bios.
 */
get_header();

$page_id  = get_the_ID();
$hero_img = tpa_get_child_image_url( 'about-hero' );
$has_hero = ! empty( $hero_img );

// Bio fields (reuse homepage bio fields or page-specific ones)
$bio_heading     = tpa_field( 'about_bio_heading', $page_id );
$bio_body        = tpa_field( 'about_bio_body', $page_id );
$bio_credentials = tpa_field( 'about_bio_credentials', $page_id );
$bio_quote       = tpa_field( 'about_bio_quote', $page_id );
$headshot        = tpa_get_child_image_url( 'front-bio-headshot' );

// Team bios (for group practices)
$team_members    = tpa_field( 'about_team_members', $page_id, [] );
$team_heading    = tpa_field( 'about_team_heading', $page_id, 'Meet the Team' );
?>

<main class="inner-page about-page">
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

    <?php if ( $bio_heading || $bio_body ) : ?>
        <section class="about-bio section">
            <div class="container">
                <div class="about-bio-grid">
                    <?php if ( $headshot ) : ?>
                        <div class="about-bio-photo" data-anim data-direction="left">
                            <img src="<?php echo esc_url( $headshot ); ?>"
                                 alt="<?php echo esc_attr( $bio_heading ); ?>" loading="lazy">
                        </div>
                    <?php endif; ?>
                    <div class="about-bio-text" data-anim data-direction="right" data-delay="200">
                        <?php if ( $bio_heading ) : ?><h2><?php echo esc_html( $bio_heading ); ?></h2><?php endif; ?>
                        <?php if ( $bio_credentials ) : ?>
                            <p class="bio-credentials"><?php echo esc_html( $bio_credentials ); ?></p>
                        <?php endif; ?>
                        <?php if ( $bio_body ) : ?>
                            <div class="bio-body"><?php echo wp_kses_post( $bio_body ); ?></div>
                        <?php endif; ?>
                        <?php if ( $bio_quote ) : ?>
                            <blockquote class="bio-quote"><?php echo esc_html( $bio_quote ); ?></blockquote>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php if ( ! empty( $team_members ) && is_array( $team_members ) ) : ?>
        <section class="about-team section">
            <div class="container">
                <h2 class="about-team-heading" data-anim><?php echo esc_html( $team_heading ); ?></h2>
                <div class="about-team-grid">
                    <?php foreach ( $team_members as $i => $member ) :
                        $name        = $member['name'] ?? '';
                        $title       = $member['title'] ?? '';
                        $member_bio  = $member['bio'] ?? '';
                        $photo_name  = $member['photo_filename'] ?? '';
                        $child_img   = get_stylesheet_directory_uri() . '/assets/images/';
                    ?>
                        <div class="team-member" data-anim data-delay="<?php echo $i * 150; ?>">
                            <?php if ( $photo_name ) : ?>
                                <div class="team-member-photo">
                                    <img src="<?php echo esc_url( $child_img . $photo_name ); ?>"
                                         alt="<?php echo esc_attr( $name ); ?>" loading="lazy">
                                </div>
                            <?php endif; ?>
                            <div class="team-member-info">
                                <?php if ( $name ) : ?><h3><?php echo esc_html( $name ); ?></h3><?php endif; ?>
                                <?php if ( $title ) : ?><p class="team-member-title"><?php echo esc_html( $title ); ?></p><?php endif; ?>
                                <?php if ( $member_bio ) : ?><div class="team-member-bio"><?php echo wp_kses_post( $member_bio ); ?></div><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php
    set_query_var( 'tpa_section', [ 'variant' => 'form-only' ] );
    get_template_part( 'template-parts/final-cta' );
    ?>
</main>

<?php get_footer(); ?>
