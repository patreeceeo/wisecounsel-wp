<?php
/**
 * Wise Counsel — Final CTA ("Still in the Fog? Still in the Storm?").
 * Brightened Blue Ridge bg, cream copy, SMS/email contacts, WPForms card.
 * Content from front-page ACF fields; form + contacts from options.
 */
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$front     = get_option('page_on_front');

$headline  = tpa_field('final_cta_headline', $front, 'Still in the Fog? Still in the Storm?');
$body      = tpa_field('final_cta_body', $front);
$form_kick = tpa_field('final_cta_form_kicker', $front, 'Free 10-Minute Consultation');
$form_ttl  = tpa_field('final_cta_form_title', $front, 'Reach Out Today');
$form_note = tpa_field('final_cta_form_note', $front, 'I respond to all inquiries within 48 hours.');

$form_shortcode = tpa_field('form_wpforms_shortcode', get_the_ID()) ?: tpa_field('form_wpforms_shortcode', 'option');
$phone     = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_sms = preg_replace('/[^0-9]/', '', $phone);
$email     = tpa_field('site_identity_email', 'option', 'janet.e.canfield@gmail.com');
?>
<section class="final-cta" id="contact">
  <?php tpa_picture('front-cta-wm.jpg', 'Blue Ridge Mountains under breaking storm clouds', ['class'=>'final-cta-bg','width'=>'1200','height'=>'872','loading'=>'lazy','decoding'=>'async']); ?>
  <div class="container">
    <div class="cta-copy">
      <?php if ($headline): ?><h2><?php echo wp_kses($headline, ['br' => []]); ?></h2><?php endif; ?>
      <?php echo wp_kses_post($body); ?>
      <div class="cta-contacts">
        <?php if ($phone): ?>
        <a class="cta-contact" href="sms:<?php echo esc_attr($phone_sms); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>
          Text: <?php echo esc_html($phone); ?>
        </a>
        <?php endif; ?>
        <?php if ($email): ?>
        <a class="cta-contact" href="mailto:<?php echo esc_attr($email); ?>">
          <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
          <?php echo esc_html($email); ?>
        </a>
        <?php endif; ?>
      </div>
    </div>
    <div class="form-card">
      <?php if ($form_kick): ?><div class="form-kicker"><?php echo esc_html($form_kick); ?></div><?php endif; ?>
      <?php if ($form_ttl): ?><h3><?php echo esc_html($form_ttl); ?></h3><?php endif; ?>
      <?php
      if ($form_shortcode) {
          echo do_shortcode($form_shortcode);
      } else {
          // 4-field fallback (matches mockup)
          ?>
          <form action="#" method="post">
            <div class="form-row"><label for="f-name">Name</label><input id="f-name" type="text" name="name" required></div>
            <div class="form-row"><label for="f-email">Email</label><input id="f-email" type="email" name="email" required></div>
            <div class="form-row"><label for="f-phone">Phone</label><input id="f-phone" type="tel" name="phone"></div>
            <div class="form-row"><label for="f-msg">What brings you here?</label><textarea id="f-msg" name="message"></textarea></div>
            <button class="btn btn-primary" type="submit">Request a Consultation</button>
          </form>
          <?php
      }
      ?>
      <?php if ($form_note): ?><p class="form-note"><?php echo esc_html($form_note); ?></p><?php endif; ?>
    </div>
  </div>
</section>
