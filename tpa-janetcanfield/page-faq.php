<?php
/**
 * Template Name: FAQ Page
 * "Field Notes" — pinned index cards grouped by category (handwritten labels).
 * Data from ACF repeater `faq_groups` (category + items).
 */
get_header();
$child_img = get_stylesheet_directory_uri() . '/assets/images/';
$groups = tpa_field('faq_groups', get_the_ID());
?>
<main id="main">
  <section class="inner-hero inner-page-hero">
    <?php tpa_janetcanfield_hero_picture('faq-hero-wm.jpg'); ?>
    <div class="inner-hero-content">
      <span class="inner-hero-twig" aria-hidden="true"></span>
      <h1 class="inner-page-title"><?php the_title(); ?></h1>
    </div>
  </section>

  <section class="inner-content">
    <div class="container">
      <?php
      $raw = get_post_field('post_content', get_the_ID());
      if (trim(wp_strip_all_tags($raw))) {
          echo '<div class="service-body" style="margin-bottom:30px">';
          echo tpa_janetcanfield_render_body(get_the_ID());
          echo '</div>';
      }
      ?>
      <div class="faq-notes-wrap">
        <?php if ($groups): foreach ($groups as $g):
            $cat   = trim($g['category'] ?? '');
            $items = $g['items'] ?? [];
            $is_fun = ($cat && stripos($cat, 'lighter') !== false);
            if (!$items) continue;
        ?>
          <?php if ($cat): ?><div class="faq-note-cat"><?php echo esc_html($cat); ?></div><?php endif; ?>
          <div class="faq-notes">
            <?php foreach ($items as $it):
                $q = $it['question'] ?? '';
                $a = $it['answer'] ?? '';
                if (!$q) continue;
            ?>
            <div class="faq-note<?php echo $is_fun ? ' fun' : ''; ?>">
              <h3><?php echo esc_html($q); ?></h3>
              <?php echo tpa_linkify(wp_kses_post($a)); ?>
            </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; endif; ?>
      </div>
    </div>
  </section>

  <?php get_template_part('template-parts/final-cta'); ?>
</main>
<?php get_footer(); ?>
