<?php
/**
 * Template Name: Contact Page
 * Featured intro card + contact item cards + form. NO final-cta (this page IS
 * the CTA). Client prefers TEXT.
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';

$phone     = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_sms = preg_replace('/[^0-9]/', '', $phone);
$email     = tpa_field('site_identity_email', 'option', 'janet.e.canfield@gmail.com');
$address   = tpa_field('site_identity_address', 'option', '1796 Hendersonville Road, Asheville, NC 28803');
// Two-line address: street on line 1, city/state/zip on line 2 (split at first comma)
$addr_parts = explode(',', $address, 2);
$addr_line1 = trim($addr_parts[0]);
$addr_line2 = isset($addr_parts[1]) ? trim($addr_parts[1]) : '';

$form_shortcode = tpa_field('form_wpforms_shortcode', get_the_ID()) ?: tpa_field('form_wpforms_shortcode', 'option');
$intro     = get_post_field('post_content', get_the_ID());
$info_head = tpa_field('contact_info_heading', get_the_ID(), 'Help is Just a Text Away');
$info_body = tpa_field('contact_info_body', get_the_ID());
$form_head = tpa_field('contact_form_heading', get_the_ID(), 'Send a Message');
?>
<main id="main">
  <section class="inner-hero inner-page-hero">
    <?php tpa_janetcanfield_hero_picture('contact-hero-wm.jpg'); ?>
    <div class="inner-hero-content">
      <span class="inner-hero-twig" aria-hidden="true"></span>
      <h1 class="inner-page-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <section class="inner-content">
    <div class="container">
      <?php if (trim(wp_strip_all_tags($intro))): ?>
        <div class="contact-intro-card">
          <span class="twig" aria-hidden="true"></span>
          <?php echo tpa_janetcanfield_render_body(get_the_ID()); ?>
        </div>
      <?php endif; ?>

      <div class="contact-grid">
        <div class="contact-info">
          <?php if ($info_head): ?><h2><?php echo esc_html($info_head); ?></h2><?php endif; ?>
          <?php echo wp_kses_post($info_body); ?>

          <div class="contact-cards">
            <?php if ($phone): ?>
            <div class="contact-card">
              <span class="contact-card-ic"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg></span>
              <div class="contact-card-body">
                <span class="contact-card-label">Text Me</span>
                <div class="contact-card-val"><a href="sms:<?php echo esc_attr($phone_sms); ?>"><?php echo esc_html($phone); ?></a></div>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($email): ?>
            <div class="contact-card">
              <span class="contact-card-ic"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></span>
              <div class="contact-card-body">
                <span class="contact-card-label">Email</span>
                <div class="contact-card-val"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></div>
              </div>
            </div>
            <?php endif; ?>

            <?php if ($addr_line1): ?>
            <div class="contact-card">
              <span class="contact-card-ic"><svg viewBox="0 0 24 24"><path d="M21 10c0 6-9 12-9 12s-9-6-9-12a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/></svg></span>
              <div class="contact-card-body">
                <span class="contact-card-label">Office</span>
                <div class="contact-card-val"><span><?php echo esc_html($addr_line1); ?></span><?php if ($addr_line2): ?><span><?php echo esc_html($addr_line2); ?></span><?php endif; ?></div>
              </div>
            </div>
            <?php endif; ?>
          </div>

          <p class="contact-coverage">
            <span>In-Person Counseling in <em>Asheville and Hendersonville</em></span>
            <span>Online Throughout North Carolina</span>
          </p>
        </div>

        <div class="contact-form-col">
          <?php if ($form_head): ?><h3><?php echo esc_html($form_head); ?></h3><?php endif; ?>
          <?php
          if ($form_shortcode) {
              echo do_shortcode($form_shortcode);
          } else { ?>
            <form action="#" method="post">
              <div class="form-row"><label for="c-name">Name</label><input id="c-name" type="text" name="name" required></div>
              <div class="form-row"><label for="c-email">Email</label><input id="c-email" type="email" name="email" required></div>
              <div class="form-row"><label for="c-phone">Phone</label><input id="c-phone" type="tel" name="phone"></div>
              <div class="form-row"><label for="c-msg">What brings you here?</label><textarea id="c-msg" name="message"></textarea></div>
              <button class="btn btn-primary" type="submit">Send</button>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </section>
</main>
<?php get_footer(); ?>
