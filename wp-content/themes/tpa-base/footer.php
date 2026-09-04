<?php
/**
 * TPA Base — Footer template.
 * Intentionally minimal per TPA Design Reference:
 * Practice name, PT badge, social icons, legal links, copyright.
 * Phone + email appear here ONLY if not already in the final CTA section.
 * NO nav links. NO form. NO CTA buttons. NO multi-column layouts.
 */

$practice_name = tpa_field( 'site_identity_practice_name', 'option', get_bloginfo( 'name' ) );
$phone         = tpa_field( 'site_identity_phone', 'option' );
$email         = tpa_field( 'site_identity_email', 'option' );
$pt_url        = tpa_field( 'social_psychology_today', 'option' );
$facebook      = tpa_field( 'social_facebook', 'option' );
$instagram     = tpa_field( 'social_instagram', 'option' );
$linkedin      = tpa_field( 'social_linkedin', 'option' );
$phone_clean   = preg_replace( '/[^0-9]/', '', $phone );
$year          = date( 'Y' );
?>

<footer class="site-footer">
    <div class="footer-inner container">
        <div class="footer-row">
            <span class="footer-practice-name"><?php echo esc_html( $practice_name ); ?></span>

            <div class="footer-social">
                <?php if ( $pt_url ) : ?>
                    <a href="<?php echo esc_url( $pt_url ); ?>" target="_blank" rel="noopener" aria-label="Psychology Today" class="footer-social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M5.8 3C4.26 3 3 4.26 3 5.8v12.4C3 19.74 4.26 21 5.8 21h12.4c1.54 0 2.8-1.26 2.8-2.8V5.8C21 4.26 19.74 3 18.2 3H5.8zm3.42 3.6h4.94c1.56 0 2.72 1.02 2.72 2.52 0 1.52-1.16 2.54-2.72 2.54h-2.2v5.74H9.22V6.6zm2.74 1.76v1.56h1.98c.62 0 1.02-.32 1.02-.78s-.4-.78-1.02-.78h-1.98z"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $facebook ) : ?>
                    <a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener" aria-label="Facebook" class="footer-social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $instagram ) : ?>
                    <a href="<?php echo esc_url( $instagram ); ?>" target="_blank" rel="noopener" aria-label="Instagram" class="footer-social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                <?php endif; ?>
                <?php if ( $linkedin ) : ?>
                    <a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener" aria-label="LinkedIn" class="footer-social-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="footer-row footer-legal-row">
            <?php if ( $phone || $email ) : ?>
                <div class="footer-contact">
                    <?php if ( $phone ) : ?>
                        <a href="tel:<?php echo esc_attr( $phone_clean ); ?>"><?php echo esc_html( $phone ); ?></a>
                    <?php endif; ?>
                    <?php if ( $phone && $email ) : ?><span class="footer-sep">|</span><?php endif; ?>
                    <?php if ( $email ) : ?>
                        <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="footer-legal">
                <a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">Privacy Policy</a>
                <span class="footer-sep">|</span>
                <a href="<?php echo esc_url( home_url( '/terms-and-conditions' ) ); ?>">Terms &amp; Conditions</a>
            </div>

            <div class="footer-copyright">
                &copy; <?php echo esc_html( $year . ' ' . $practice_name ); ?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
