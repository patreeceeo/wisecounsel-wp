<?php
/**
 * Wise Counsel — Footer.
 * Full owl lockup (cream) + legal links + copyright. No PT badge, no social.
 */
$child_img   = get_stylesheet_directory_uri() . '/assets/images/';
$practice    = tpa_field('site_identity_practice_name', 'option', 'Wise Counsel');
$phone       = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_clean = preg_replace('/[^0-9]/', '', $phone);
$credentials = tpa_field('site_identity_license_disclosure', 'option');
$locations   = tpa_field('footer_locations', 'option');
$year        = date('Y');
$privacy     = get_permalink(get_page_by_path('privacy-policy'));
$terms       = get_permalink(get_page_by_path('terms-and-conditions'));
?>
<footer class="footer">
  <div class="footer-inner">
    <?php tpa_picture('logo-full-ink.png', $practice . ' – help for birds of all feathers', ['class'=>'footer-lockup','width'=>'420','height'=>'397','loading'=>'lazy','decoding'=>'async']); ?>
    <div class="footer-contact">
      <a class="footer-phone" href="sms:<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($phone); ?></a>
      <div class="footer-addresses" id="locations" style="scroll-margin-top:90px">
        <?php foreach (($locations ?: []) as $loc):
            $street = trim($loc['street'] ?? '');
            $city   = trim($loc['city'] ?? '');
            if (!$street && !$city) continue; ?>
          <p class="footer-address"><?php
            if ($street) echo '<span>' . esc_html($street) . '</span>';
            if ($city)   echo '<span>' . esc_html($city) . '</span>';
          ?></p>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="footer-fine">
      <div class="footer-links">
        <?php if ($privacy): ?><a href="<?php echo esc_url($privacy); ?>">Privacy Policy</a><?php endif; ?>
        <?php if ($terms): ?><a href="<?php echo esc_url($terms); ?>">Terms &amp; Conditions</a><?php endif; ?>
      </div>
      <?php if ($credentials): ?><div class="footer-credentials"><?php echo esc_html($credentials); ?></div><?php endif; ?>
      <div class="footer-copy">&copy; <?php echo esc_html($year); ?> <?php echo esc_html($practice); ?></div>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
