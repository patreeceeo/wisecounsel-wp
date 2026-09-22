<?php
/**
 * Title: Bio card (headshot + text)
 * Slug: tpa-janetcanfield/bio-card
 * Categories: wise-counsel
 * Keywords: bio, about, headshot, card, janet, therapist
 * Description: Wide card with a portrait photo on the left and a name plus short bio on the right. Stacks on phones. Styles live in assets/css/bio-card.css.
 * Viewport Width: 960
 *
 * Auto-registered by WordPress from the theme's patterns/ folder.
 * Inserted copies are independent — edit each one freely. To swap the photo,
 * select the image and use Replace; a portrait (taller than wide) crops best.
 * Keep the "ln-bio-card*" classes under Block → Advanced → Additional CSS class.
 */
$tpa_bio_img = get_theme_file_uri( 'assets/images/front-headshot.jpg' );
?>
<!-- wp:group {"className":"ln-bio-card","layout":{"type":"default"}} -->
<div class="wp-block-group ln-bio-card"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"ln-bio-card-photo"} -->
<figure class="wp-block-image size-full ln-bio-card-photo"><img src="<?php echo esc_url( $tpa_bio_img ); ?>" alt="Janet Canfield"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"ln-bio-card-body","layout":{"type":"default"}} -->
<div class="wp-block-group ln-bio-card-body"><!-- wp:paragraph {"className":"ln-bio-card-name"} -->
<p class="ln-bio-card-name">Janet Canfield, MA</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>I've always been interested in people – what shapes them, what moves them, what gets in the way.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Replace this with a second short paragraph for this page.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
