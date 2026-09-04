<?php
/**
 * Template Name: Landing Page (Nest)
 *
 * Bespoke brand-adapted landing page for Wise Counsel — built in the main
 * site's visual language (warm walnut/gold/sage, owl brand, twig + wave
 * motifs, dark-sage cards, refrain chips) applied to the standard LP funnel
 * structure. Reads the standard lp_* ACF fields (same contract as the parent
 * page-landing.php). Self-contained: own <head>, inline CSS/JS, no site nav.
 */
$page_id     = get_the_ID();
$child_img   = get_stylesheet_directory_uri() . '/assets/images/';
$phone       = tpa_field('site_identity_phone', 'option', '(828) 222-0809');
$phone_clean = preg_replace('/[^0-9]/', '', $phone);
$email       = tpa_field('site_identity_email', 'option', 'janet.e.canfield@gmail.com');

$seo_title   = tpa_field('lp_seo_title', $page_id, get_the_title());
$seo_desc    = tpa_field('lp_seo_description', $page_id);
$nav_links   = tpa_field('lp_nav_links', $page_id, []);

$hero_eyebrow= tpa_field('lp_hero_eyebrow', $page_id);
$hero_h1     = tpa_field('lp_hero_headline', $page_id);
$hero_sub    = tpa_field('lp_hero_subheadline', $page_id);
$hero_cta    = tpa_field('lp_hero_primary_cta_text', $page_id, 'Learn How It Works');
$hero_cta_u  = tpa_field('lp_hero_primary_cta_url', $page_id, '#process');
$hero_cta2   = tpa_field('lp_hero_secondary_cta_text', $page_id);
$hero_shot   = tpa_field('lp_hero_headshot', $page_id, 'front-headshot.jpg');
$hero_meta   = tpa_field('lp_hero_meta_items', $page_id, []);

$pain_h      = tpa_field('lp_pain_headline', $page_id);
$pain_body   = tpa_field('lp_pain_body', $page_id);
$symptoms    = tpa_field('lp_problem_symptoms', $page_id);
$pain_close  = tpa_field('lp_problem_close', $page_id);
$pain_img    = tpa_field('lp_pain_image', $page_id, 'lgbtqia-therapy-body1-wm.jpg');

$mid_h       = tpa_field('lp_cta_headline', $page_id);
$mid_btn     = tpa_field('lp_cta_button_text', $page_id, 'Call or Text Today');
// Janet prefers text, so the band CTA falls back to sms: like every other CTA.
$mid_btn_url = tpa_field('lp_cta_button_url', $page_id, 'sms:' . $phone_clean);

$sol_h       = tpa_field('lp_authority_headline', $page_id);
$sol_body    = tpa_field('lp_authority_body', $page_id);
$ben_intro   = tpa_field('lp_solution_analogy', $page_id) ?: tpa_field('lp_solution_benefits_intro', $page_id);
$benefits    = tpa_field('lp_solution_benefits', $page_id, []);
$sol_img     = tpa_field('lp_authority_image', $page_id, 'lgbtqia-therapy-body2-wm.jpg');

$proc_h      = tpa_field('lp_process_headline', $page_id);
$proc_steps  = tpa_field('lp_process_steps', $page_id, []);

$trust_h     = tpa_field('lp_trust_headline', $page_id);
$trust_items = tpa_field('lp_trust_items', $page_id, []);
$about_bio   = tpa_field('lp_about_bio', $page_id);

$faq_h       = tpa_field('lp_faq_headline', $page_id, 'Frequently Asked Questions');
$faqs        = tpa_field('lp_faqs', $page_id, []);

$next_h      = tpa_field('lp_cta2_headline', $page_id);
$next_lead   = tpa_field('lp_whatnext_lead', $page_id);
$next_steps  = tpa_field('lp_whatnext_steps', $page_id, []);

$form_h      = tpa_field('lp_form_headline', $page_id, 'Reach Out for Your Free Consultation');
$form_sub    = tpa_field('lp_form_subheadline', $page_id);
$form_card   = tpa_field('lp_form_card_title', $page_id, 'Request Your Free Consultation');
$form_sc     = tpa_field('lp_form_shortcode', $page_id) ?: tpa_field('form_wpforms_shortcode', 'option');

// Fonts: self-hosted variable woff2 (see header.php for the why). Falls back to
// Google Fonts only if the files are missing from assets/fonts/.
$fonts_dir  = get_stylesheet_directory() . '/assets/fonts';
$fonts_uri  = get_stylesheet_directory_uri() . '/assets/fonts';
$self_fonts = file_exists($fonts_dir . '/figtree-wght-normal.woff2');
$font_faces = [
    ['Figtree',  'normal', 'figtree-wght-normal',  true],
    ['Alegreya', 'normal', 'alegreya-wght-normal', true],
    ['Alegreya', 'italic', 'alegreya-wght-italic', false],
    ['Figtree',  'italic', 'figtree-wght-italic',  false],
];
$fonts_url = 'https://fonts.googleapis.com/css2?family=Alegreya:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600&family=Figtree:wght@400;500;600&display=swap';
$twig = 'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 110 12%22 fill=%22none%22 stroke=%22%23A68B5B%22 stroke-width=%221.4%22 stroke-linecap=%22round%22%3E%3Cpath d=%22M1 8c34-2 66-3 108-5M36 7l11-5M72 5l-9-5%22/%3E%3C/svg%3E';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, follow">
  <title><?php echo esc_html($seo_title); ?></title>
  <?php if ($seo_desc): ?><meta name="description" content="<?php echo esc_attr($seo_desc); ?>"><?php endif; ?>
  <link rel="icon" type="image/png" sizes="64x64" href="<?php echo esc_url($child_img . 'favicon-64.png'); ?>">
  <link rel="apple-touch-icon" href="<?php echo esc_url($child_img . 'favicon-180.png'); ?>">
  <?php if ($self_fonts):
      $latin = 'U+0000-00FF,U+0131,U+0152-0153,U+02BB-02BC,U+02C6,U+02DA,U+02DC,'
             . 'U+0304,U+0308,U+0329,U+2000-206F,U+20AC,U+2122,U+2191,U+2193,'
             . 'U+2212,U+2215,U+FEFF,U+FFFD';
      foreach ($font_faces as [$fam, $style, $file, $preload]):
          if (!$preload) continue; ?>
  <link rel="preload" as="font" type="font/woff2" crossorigin
        href="<?php echo esc_url($fonts_uri . '/' . $file . '.woff2'); ?>">
  <?php endforeach; ?>
  <style id="tpa-fonts" data-no-optimize="1"><?php
      foreach ($font_faces as [$fam, $style, $file, $preload]) {
          echo "@font-face{font-family:'{$fam}';font-style:{$style};"
             . "font-weight:400 700;font-display:swap;"
             . "src:url('" . esc_url($fonts_uri . '/' . $file . '.woff2') . "') format('woff2');"
             . "unicode-range:{$latin}}";
      }
  ?></style>
  <?php else: ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="<?php echo esc_url($fonts_url); ?>" rel="stylesheet">
  <?php endif; ?>
  <?php wp_head(); ?>
  <style>
  :root{
    --primary:#8B6F47;--primary-dark:#6E5636;--secondary:#A68B5B;--accent:#6B8B7A;--accent-dark:#54705F;
    --bg:#FAF8F5;--bg-tan:#F3EDE3;--text:#2D2A26;--text-soft:#5C554B;--cream:#FDFCFA;
    --gold:#EAD9BC;--walnut:#5C4A31;--dark-sage:#35443C;--dark-sage2:#2C3833;
    --font-head:'Alegreya',serif;--font-body:'Figtree',sans-serif;--radius-btn:12px 12px 12px 3px;
  }
  *{margin:0;padding:0;box-sizing:border-box}
  html{scroll-behavior:smooth}
  body.landing-nest{font-family:var(--font-body);font-size:17px;line-height:1.7;color:var(--text);background:var(--bg);-webkit-font-smoothing:antialiased;overflow-x:clip}
  .ln h1,.ln h2,.ln h3,.ln h4{font-family:var(--font-head);line-height:1.15;color:var(--text);text-wrap:pretty}
  .ln p{text-wrap:pretty}
  .ln img{max-width:100%}
  .ln-wrap{max-width:1120px;margin:0 auto;padding:0 26px}
  .skip-link{position:absolute;left:-9999px}.skip-link:focus{left:8px;top:8px;z-index:999;background:var(--text);color:#fff;padding:10px 16px;border-radius:0 0 8px 0}
  .twig{width:100px;height:12px;background:url("<?php echo $twig; ?>") no-repeat center/contain}
  /* buttons */
  .ln .btn{display:inline-flex;align-items:center;gap:9px;text-decoration:none;font-weight:600;font-size:1rem;padding:15px 30px;border-radius:var(--radius-btn);transition:background .22s,box-shadow .22s,color .22s;cursor:pointer;border:none;font-family:var(--font-body)}
  .ln .btn-primary{background:var(--primary);color:#FDFCF8;box-shadow:0 6px 22px -8px rgba(45,42,38,.5)}
  .ln .btn-primary:hover{background:var(--primary-dark);box-shadow:0 8px 28px -8px rgba(45,42,38,.6)}
  .ln .btn-ghost{background:transparent;color:#FDFCF8;border:1.6px solid rgba(253,252,248,.6)}
  .ln .btn-ghost:hover{background:rgba(253,252,248,.14)}
  .ln .btn-gold{background:var(--gold);color:#2D2A26}
  .ln .btn-gold:hover{background:#DFC9A0}
  /* nav */
  .ln-nav{position:sticky;top:0;z-index:100;background:rgba(250,248,245,.97);border-bottom:1px solid rgba(139,111,71,.14);transition:background .35s,box-shadow .3s}
  .ln-nav.scrolled{background:rgba(44,56,51,.97);box-shadow:0 10px 28px -18px rgba(20,16,12,.55)}
  .ln-nav-inner{max-width:1200px;margin:0 auto;padding:0 26px;height:70px;display:flex;align-items:center;gap:18px}
  .ln-brand{display:flex;align-items:center;gap:11px;text-decoration:none;flex:0 1 auto;min-width:0}
  /* Marks are inside <picture>; keep the <img> as the flex item. */
  .ln-brand picture{display:contents}
  .ln-brand img{height:46px;width:auto}
  .ln-brand .mark-cream{display:none}
  .ln-nav.scrolled .ln-brand .mark-ink{display:none}
  .ln-nav.scrolled .ln-brand .mark-cream{display:block}
  .ln-brand .bn{font-family:var(--font-head);font-weight:700;font-size:1.4rem;color:var(--text);line-height:1;white-space:nowrap}
  .ln-brand .bn span{color:#2D2A26}
  .ln-nav.scrolled .ln-brand .bn{color:#F5F1E8}.ln-nav.scrolled .ln-brand .bn span{color:var(--gold)}
  .ln-anchors{display:flex;gap:6px;list-style:none;margin:0 auto}
  .ln-anchors a{text-decoration:none;color:var(--text);font-size:.9rem;font-weight:500;padding:8px 11px;border-radius:8px;transition:color .2s,background .2s;white-space:nowrap}
  .ln-anchors a:hover{color:#2D2A26;background:rgba(45,42,38,.08)}
  .ln-nav.scrolled .ln-anchors a{color:#EAE3D5}.ln-nav.scrolled .ln-anchors a:hover{color:var(--gold);background:rgba(234,217,188,.1)}
  .ln-nav-cta{display:inline-flex;align-items:center;gap:7px;flex:none;text-decoration:none;font-weight:600;font-size:.9rem;padding:10px 18px;border-radius:var(--radius-btn);background:var(--accent-dark);color:#fff;white-space:nowrap;transition:background .2s}
  .ln-nav-cta:hover{background:#455C4E}
  .ln-nav.scrolled .ln-nav-cta{background:var(--gold);color:#2D2A26}.ln-nav.scrolled .ln-nav-cta:hover{background:#DFC9A0}
  .ln-nav-cta svg{width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.8}
  .ln-burger{display:none;background:none;border:none;cursor:pointer;padding:10px;margin-left:auto}
  .ln-burger span{display:block;width:24px;height:2px;background:var(--text);margin:5px 0;transition:.3s}
  .ln-nav.scrolled .ln-burger span{background:#F5F1E8}
  /* hero */
  .ln-hero{position:relative;overflow:hidden;background:var(--dark-sage2)}
  .ln-hero-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 42%;opacity:.32}
  .ln-hero::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(44,56,51,.6),rgba(44,56,51,.86))}
  .ln-hero-inner{position:relative;z-index:2;max-width:800px;margin:0 auto;padding:72px 26px 82px}
  .ln-hero-eyebrow{display:inline-block;background:var(--walnut);color:var(--gold);font-family:var(--font-head);font-style:italic;font-weight:600;font-size:1.05rem;padding:8px 20px;border-radius:3px;margin-bottom:18px}
  .ln-hero h1{color:#FDFCF8;font-size:clamp(2.1rem,4vw,3.1rem);font-weight:700;margin-bottom:16px;text-shadow:0 2px 22px rgba(20,16,12,.4)}
  .ln-hero-sub{color:rgba(253,252,248,.9);font-size:1.12rem;max-width:44ch;margin-bottom:24px}
  .ln-hero-ctas{display:flex;flex-wrap:wrap;gap:14px;margin-bottom:22px}
  .ln-hero-meta{display:flex;flex-wrap:wrap;gap:8px 20px;list-style:none}
  .ln-hero-meta li{color:var(--gold);font-size:.9rem;font-weight:500;display:flex;align-items:center;gap:7px}
  .ln-hero-meta li::before{content:"";width:6px;height:6px;border-radius:50%;background:var(--gold)}
  .ln-hero-figure{justify-self:center;position:relative}
  .ln-hero-figure img{width:300px;height:300px;object-fit:cover;object-position:center 20%;border-radius:50%;border:4px solid var(--gold);box-shadow:0 30px 60px -26px rgba(0,0,0,.6)}
  /* wave divider */
  .ln-wave{display:block;width:100%;height:22px}
  /* trust badges */
  .ln-badges{background:var(--gold);padding:16px 0}
  .ln-badges-inner{max-width:1080px;margin:0 auto;padding:0 26px;display:flex;flex-wrap:wrap;justify-content:center;gap:14px 34px}
  .ln-badge{display:flex;align-items:center;gap:9px;font-weight:600;font-size:.92rem;color:#3A2E1C}
  .ln-badge svg{width:20px;height:20px;stroke:var(--walnut);fill:none;stroke-width:1.8}
  /* section base */
  .ln-sec{padding:80px 0}
  .ln-kicker{display:flex;align-items:center;gap:10px;font-size:.82rem;font-weight:600;letter-spacing:.16em;text-transform:uppercase;color:var(--accent-dark);margin-bottom:10px}
  .ln-kicker::after{content:"";height:1px;width:44px;background:var(--accent);opacity:.6}
  .ln-sec h2{font-size:clamp(1.9rem,3.3vw,2.6rem);margin-bottom:14px;color:var(--text)}
  /* problem */
  .ln-problem{background:var(--bg)}
  .ln-problem-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:52px;align-items:center}
  .ln-problem-fig{position:relative;overflow:hidden;border-radius:18px;clip-path:polygon(40px 0,100% 0,calc(100% - 40px) 100%,0 100%);min-height:400px}
  .ln-problem-fig img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
  .ln-problem p{color:var(--text-soft);margin-bottom:12px;max-width:54ch}
  .ln-symptoms{list-style:none;margin:20px 0}
  .ln-symptoms li{position:relative;padding:9px 0 9px 30px;color:var(--text);font-family:var(--font-head);font-size:1.12rem}
  .ln-symptoms li::before{content:"";position:absolute;left:0;top:15px;width:13px;height:13px;border-radius:50%;background:var(--gold);border:2px solid var(--secondary)}
  .ln-refrain{display:inline-block;margin-top:8px;background:var(--walnut);color:var(--gold);font-family:var(--font-head);font-style:italic;font-weight:600;font-size:1.25rem;padding:13px 30px;border-radius:3px;box-shadow:0 14px 30px -16px rgba(92,74,49,.55)}
  /* mid band */
  .ln-band{position:relative;background:linear-gradient(115deg,#41594A,#547260 46%,#6B8B7A);padding:52px 0;text-align:center;border-top:2px solid rgba(166,139,91,.7);border-bottom:2px solid rgba(166,139,91,.7)}
  .ln-band h2{color:#F5EDDD;font-size:clamp(1.6rem,2.8vw,2.15rem);margin-bottom:20px;font-style:italic}
  .ln-band .btn{background:#FDFCF8;color:#3F5A4B}.ln-band .btn:hover{background:#EAF0EB}
  /* solution */
  .ln-solution{background:var(--bg-tan)}
  .ln-solution-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:52px;align-items:center}
  .ln-solution-fig{position:relative;overflow:hidden;border-radius:18px;clip-path:polygon(0 0,calc(100% - 40px) 0,100% 100%,40px 100%);min-height:420px;box-shadow:0 24px 48px -26px rgba(45,42,38,.4)}
  .ln-solution-fig img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover}
  .ln-solution p{color:var(--text-soft);margin-bottom:12px}
  .ln-ben-intro{font-family:var(--font-head);font-style:italic;font-size:1.2rem;color:var(--primary-dark);margin:16px 0}
  .ln-benefits{list-style:none;margin-top:16px}
  .ln-benefits li{position:relative;padding:8px 0 8px 32px;color:var(--text);margin-bottom:2px}
  .ln-benefits li::before{content:"";position:absolute;left:0;top:12px;width:16px;height:10px;border-left:2.4px solid var(--accent-dark);border-bottom:2.4px solid var(--accent-dark);transform:rotate(-45deg)}
  /* process */
  .ln-process{background:var(--dark-sage);text-align:center}
  .ln-process h2{color:#F5F1E8}
  .ln-process .ln-kicker{color:var(--gold);justify-content:center}.ln-process .ln-kicker::after{background:var(--gold)}
  .ln-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:40px}
  .ln-step{background:rgba(253,252,248,.05);border:1px solid rgba(234,217,188,.18);border-radius:16px;padding:34px 26px;text-align:center;
    animation:phaseGlow 10.5s ease-in-out infinite}
  .ln-step:nth-child(2){animation-delay:3.5s}
  .ln-step:nth-child(3){animation-delay:7s}
  @keyframes phaseGlow{
    0%,72%,100%{border-color:rgba(234,217,188,.18);box-shadow:0 0 0 0 rgba(234,217,188,0)}
    36%{border-color:rgba(234,217,188,.62);box-shadow:0 0 0 1px rgba(234,217,188,.4),0 0 30px -4px rgba(234,217,188,.42)}
  }
  @media (prefers-reduced-motion:reduce){.ln-step{animation:none}}
  .ln-step-num{display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:50%;background:var(--gold);color:var(--walnut);font-family:var(--font-head);font-weight:700;font-size:1.5rem;margin-bottom:16px}
  .ln-step h3{color:#F5F1E8;font-size:1.35rem;margin-bottom:10px}
  .ln-step p{color:rgba(245,241,232,.82);font-size:.98rem}
  .ln-step .ln-step-tag{display:block;margin-top:12px;color:var(--gold);font-family:var(--font-head);font-style:italic;font-size:1.02rem}
  /* trust */
  .ln-trust{background:var(--bg)}
  .ln-trust-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:26px;margin-top:34px}
  .ln-pillar{background:var(--cream);border:1px solid rgba(139,111,71,.14);border-radius:16px;padding:30px 28px;box-shadow:0 18px 40px -28px rgba(45,42,38,.3)}
  .ln-pillar h3{font-size:1.28rem;color:var(--primary-dark);margin-bottom:10px}
  .ln-pillar p{color:var(--text-soft);font-size:.98rem}
  .ln-pillar .twig{margin-bottom:14px}
  /* quick-bio card: wide, short rectangle — headshot left, copy right */
  .ln-bio-card{display:grid;grid-template-columns:250px 1fr;background:var(--cream);border:1px solid rgba(139,111,71,.16);
    border-radius:16px 16px 16px 6px;overflow:hidden;box-shadow:0 22px 48px -26px rgba(45,42,38,.42);
    max-width:880px;margin:36px auto 0;text-align:left}
  .ln-bio-card-photo{position:relative;min-height:100%}
  .ln-bio-card-photo img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 16%;display:block}
  .ln-bio-card-body{padding:30px 34px;display:flex;flex-direction:column;justify-content:center}
  .ln-bio-card-name{display:block;font-family:var(--head);font-weight:700;color:var(--primary-dark);font-size:1.32rem;margin-bottom:10px}
  .ln-bio-card-body p{color:var(--text-soft);font-size:1rem;line-height:1.65;margin-bottom:10px}
  .ln-bio-card-body p:last-child{margin-bottom:0}
  .ln-bio-card-body strong{color:var(--primary-dark)}
  @media (max-width:680px){
    .ln-bio-card{grid-template-columns:1fr}
    /* 260px cropped Janet at the chin — the frame is 760x879, so at the card's
       ~336px width it needs ~389px to show uncropped. 350px clears her chin and
       collar with only a slight trim. */
    .ln-bio-card-photo{min-height:350px}
  }
  /* faq */
  .ln-faq{background:var(--bg-tan)}
  .ln-faq-list{max-width:820px;margin:30px auto 0}
  .ln-faq-item{position:relative;border-bottom:1px solid rgba(139,111,71,.2)}
  .ln-faq-item::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--gold);transform:scaleY(0);transform-origin:top;transition:transform .4s cubic-bezier(.25,1,.5,1)}
  .ln-faq-item.open{background:linear-gradient(90deg,rgba(234,217,188,.16),transparent 70%)}
  .ln-faq-item.open::before{transform:scaleY(1)}
  .ln-faq-q{width:100%;text-align:left;background:none;border:none;cursor:pointer;display:flex;align-items:flex-start;justify-content:space-between;gap:20px;padding:24px 18px;font-family:var(--font-head);font-weight:600;font-size:1.24rem;color:var(--text);transition:color .25s}
  .ln-faq-item.open .ln-faq-q{color:var(--primary-dark)}
  .ln-faq-ic{flex:none;width:15px;height:15px;position:relative;margin-top:8px;transition:transform .4s cubic-bezier(.25,1,.5,1)}
  .ln-faq-ic::after{content:"";position:absolute;top:1px;left:3px;width:9px;height:9px;border-right:2px solid var(--accent-dark);border-bottom:2px solid var(--accent-dark);transform:rotate(45deg)}
  .ln-faq-item.open .ln-faq-ic{transform:rotate(180deg)}.ln-faq-item.open .ln-faq-ic::after{border-color:var(--secondary)}
  .ln-faq-a{display:grid;grid-template-rows:0fr;transition:grid-template-rows .4s cubic-bezier(.25,1,.5,1)}
  .ln-faq-item.open .ln-faq-a{grid-template-rows:1fr}
  .ln-faq-a-in{overflow:hidden}
  .ln-faq-a-in p{color:var(--text-soft);font-size:1.05rem;line-height:1.8;padding:0 44px 24px 18px}
  /* next */
  .ln-next{background:var(--bg);text-align:center}
  .ln-next-lead{max-width:640px;margin:0 auto 8px;color:var(--text-soft)}
  .ln-next-lead p{margin-bottom:10px}
  .ln-next-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;max-width:960px;margin:36px auto 0;text-align:left}
  .ln-next-step{background:var(--cream);border:1px solid rgba(139,111,71,.14);border-radius:14px;padding:26px 24px;position:relative}
  .ln-next-num{display:inline-flex;align-items:center;justify-content:center;width:40px;height:40px;border-radius:50%;background:var(--accent-dark);color:#fff;font-family:var(--font-head);font-weight:700;margin-bottom:12px}
  .ln-next-step h3{font-size:1.12rem;color:var(--primary-dark);margin-bottom:8px}
  .ln-next-step p{color:var(--text-soft);font-size:.96rem}
  /* form */
  .ln-form{background:var(--dark-sage2);padding:80px 0}
  .ln-form-grid{max-width:1020px;margin:0 auto;padding:0 26px;display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center}
  .ln-form-copy h2{color:#FDFCF8;font-size:clamp(1.8rem,3vw,2.4rem);margin-bottom:14px}
  .ln-form-copy p{color:rgba(253,252,248,.86);margin-bottom:18px}
  .ln-form-contact{display:flex;flex-direction:column;gap:10px;margin-top:18px}
  .ln-form-contact a{color:var(--gold);text-decoration:none;font-weight:600;display:inline-flex;align-items:center;gap:10px}
  .ln-form-contact a small{display:block;color:rgba(253,252,248,.6);font-weight:500}
  .ln-form-contact svg{width:19px;height:19px;stroke:var(--gold);fill:none;stroke-width:1.8;flex:none}
  .ln-form-card{background:var(--cream);border-radius:20px;padding:32px 30px;box-shadow:0 34px 70px -26px rgba(0,0,0,.6)}
  .ln-form-card h3{font-size:1.3rem;color:var(--primary-dark);margin-bottom:18px}
  .ln-form-secure{display:flex;align-items:center;justify-content:center;gap:9px;margin-top:14px;font-size:.86rem;color:var(--text-soft);text-align:center}
  .ln-form-secure svg{width:18px;height:18px;stroke:var(--accent-dark);fill:none;stroke-width:1.8;flex:none}
  /* WPForms overrides — match mockup form-card */
  .ln-form-card .wpforms-container-full{margin:0!important}
  .ln-form-card .wpforms-form .wpforms-field{padding:0 0 15px!important}
  .ln-form-card .wpforms-form .wpforms-field-label{font-family:var(--font-body)!important;font-size:.86rem!important;font-weight:600!important;color:var(--text-soft)!important;margin:0 0 6px!important}
  .ln-form-card .wpforms-form input[type=text],.ln-form-card .wpforms-form input[type=email],.ln-form-card .wpforms-form input[type=tel],.ln-form-card .wpforms-form textarea,.ln-form-card .wpforms-form input.wpforms-field-large{width:100%!important;max-width:100%!important;padding:12px 14px!important;font-family:var(--font-body)!important;font-size:.97rem!important;color:var(--text)!important;background:var(--bg)!important;border:1px solid rgba(139,111,71,.28)!important;border-radius:10px!important;box-shadow:none!important}
  .ln-form-card .wpforms-form textarea{min-height:104px!important;resize:vertical!important}
  .ln-form-card .wpforms-form input:focus,.ln-form-card .wpforms-form textarea:focus{border-color:var(--accent)!important;box-shadow:0 0 0 3px rgba(107,139,122,.18)!important;outline:none!important}
  .ln-form-card .wpforms-form .wpforms-submit{display:block!important;width:100%!important;background:var(--primary)!important;color:#FDFCF8!important;font-family:var(--font-body)!important;font-weight:600!important;font-size:1rem!important;padding:15px 30px!important;border:none!important;border-radius:var(--radius-btn)!important;box-shadow:0 6px 22px -8px rgba(45,42,38,.5)!important;cursor:pointer!important;text-transform:none!important}
  .ln-form-card .wpforms-form .wpforms-submit:hover{background:var(--primary-dark)!important}
  .ln-form-card .wpforms-required-label{color:var(--secondary)!important}
  /* integrated get-started: prominent phone + centered form */
  .ln-getstarted{max-width:600px;margin:clamp(30px,4vw,42px) auto 0;text-align:center}
  .ln-phone-big{display:inline-flex;flex-direction:column;align-items:center;gap:4px;text-decoration:none;
    background:linear-gradient(158deg,#3A4B42,#2C3833 70%,#242E29);color:#fff;
    padding:22px 44px;border-radius:20px 20px 20px 6px;max-width:100%;
    box-shadow:0 22px 48px -20px rgba(0,0,0,.55);transition:transform .2s,box-shadow .25s;position:relative;overflow:hidden;margin-bottom:clamp(30px,4vw,42px)}
  .ln-phone-big::before{content:"";position:absolute;inset:0;background:radial-gradient(70% 120% at 84% 6%,rgba(234,217,188,.16),transparent 60%);pointer-events:none}
  .ln-phone-big:hover{transform:translateY(-2px);box-shadow:0 28px 56px -20px rgba(0,0,0,.62)}
  .ln-phone-big svg{width:26px;height:26px;stroke:var(--gold);fill:none;stroke-width:1.8;position:relative}
  .ln-phone-big-label{font-size:.76rem;letter-spacing:.13em;text-transform:uppercase;color:var(--gold);font-weight:600;position:relative}
  .ln-phone-big-num{font-family:var(--head);font-weight:700;font-size:clamp(2rem,5vw,2.9rem);color:#FDFCF8;line-height:1.05;letter-spacing:.01em;position:relative}
  .ln-getstarted .ln-form-card{text-align:left;max-width:560px;margin:0 auto}
  .ln-getstarted .ln-form-card h3{text-align:center}
  /* footer */
  .ln-footer{background:#F3EDE3;padding:40px 0 26px;text-align:center}
  .ln-footer-fees{max-width:1080px;margin:0 auto 16px;padding:0 24px;color:#5C554B;font-size:.8rem;line-height:1.6}
  .ln-footer img{width:170px;height:auto;margin-bottom:14px}
  .ln-footer-contact{margin:0 auto 16px;display:flex;flex-direction:column;align-items:center;gap:14px}
  .ln-footer-phone{color:#2D2A26;text-decoration:none;font-weight:700;font-size:1.05rem;letter-spacing:.01em;transition:color .2s}
  .ln-footer-phone:hover{color:var(--primary-dark)}
  .ln-footer-addresses{display:flex;flex-direction:column;align-items:center;gap:8px}
  .ln-footer-address{display:flex;flex-direction:column;gap:2px;margin:0;color:#5C554B;font-size:.9rem;line-height:1.45;text-align:center}
  .ln-footer-legal{display:flex;justify-content:center;gap:20px;flex-wrap:wrap;margin-bottom:12px}
  .ln-footer-legal a{color:#5C554B;text-decoration:none;font-size:.86rem}
  .ln-footer-legal a:hover{color:#2D2A26}
  .ln-footer-copy{color:#5C554B;font-size:.8rem}
  /* reveal */
  .ln-rev{opacity:0;transform:translateY(26px);transition:opacity .8s cubic-bezier(.19,1,.22,1),transform .8s cubic-bezier(.19,1,.22,1)}
  .ln-rev.in{opacity:1;transform:none}
  @media (prefers-reduced-motion:reduce){.ln-rev{opacity:1;transform:none;transition:none}}
  /* responsive */
  @media (max-width:960px){
    .ln-hero-inner{grid-template-columns:1fr;gap:32px;text-align:center}
    .ln-hero-eyebrow{margin-left:auto;margin-right:auto}
    .ln-hero-sub{margin-left:auto;margin-right:auto}
    .ln-hero-ctas,.ln-hero-meta{justify-content:center}
    .ln-hero-figure{order:-1}
    .ln-problem-grid,.ln-solution-grid,.ln-form-grid{grid-template-columns:1fr;gap:32px}
    .ln-problem-fig,.ln-solution-fig{order:-1;min-height:300px;clip-path:none}
    .ln-steps,.ln-trust-grid,.ln-next-steps{grid-template-columns:1fr}
  }
  @media (max-width:1024px){
    .ln-anchors{display:none}
    .ln-burger{display:block;margin-left:auto}
    /* Text Me moves out of the bar and into the drawer as its closing CTA. */
    .ln-nav-cta{display:none}
    .ln-mobile{position:fixed;inset:70px 0 auto 0;background:linear-gradient(180deg,#FAF8F5 0%,#F3EDE3 100%);border-bottom:1px solid rgba(139,111,71,.14);padding:18px 26px 24px;display:none;flex-direction:column;gap:4px;z-index:99;box-shadow:0 18px 30px -20px rgba(0,0,0,.4)}
    .ln-mobile.open{display:flex}
    .ln-mobile a{text-decoration:none;color:var(--text);font-weight:600;font-size:1.14rem;padding:15px 6px;border-bottom:1px solid rgba(139,111,71,.14)}
    .ln-mobile-cta{
      display:flex!important;align-items:center;justify-content:center;gap:10px;
      margin-top:18px;padding:16px 22px!important;border-bottom:none!important;
      background:var(--accent-dark);color:#FDFCF8!important;
      font-weight:700;font-size:1.04rem!important;border-radius:var(--radius-btn);
      box-shadow:0 10px 26px -12px rgba(45,42,38,.5);
    }
    .ln-mobile-cta:hover,.ln-mobile-cta:focus-visible{background:#3F5A4B}
    .ln-mobile-cta svg{width:19px;height:19px;flex:none;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
  }
  @media (min-width:1025px){.ln-mobile-cta{display:none!important}}
  @media (min-width:1025px){.ln-mobile{display:none}}
  @media (max-width:560px){
    .ln-sec{padding:56px 0}
    .ln-hero-inner{padding:48px 26px 60px}
    .ln-hero-figure img{width:220px;height:220px}
    .ln-nav-cta span.lbl{display:none}
  }
  @media (hover:none) and (pointer:coarse){
    .ln-anchors a,.ln-nav-cta,.ln .btn,.ln-footer-legal a{font-size:14px!important;min-height:44px}
    .ln-form-card .wpforms-form .wpforms-field-label{font-size:14px!important}
    .ln-form-card .wpforms-submit{min-height:44px!important}
    /* 14px floor for the LP's remaining fine print (kicker label, form
       reassurance, fee disclosure) — all sat at 12.2-13.8px. */
    .ln-phone-big-label,.ln-form-secure,.ln-footer-fees{font-size:14px!important}
    /* 44px tap targets for the footer phone and the skip link. The skip link
       only got its padding on :focus, so it measured 117x29 unfocused. */
    .ln-footer-phone{min-height:44px;display:inline-flex;align-items:center;justify-content:center}
    .skip-link{padding:12px 20px}
  }
  </style>
</head>
<body <?php body_class('landing-nest'); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main">Skip to content</a>

<nav class="ln-nav" aria-label="Landing navigation">
  <div class="ln-nav-inner">
    <a class="ln-brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php tpa_picture('logo-mark-ink.png', '', ['class'=>'mark-ink','width'=>'143','height'=>'160','fetchpriority'=>'high','decoding'=>'async']); ?>
      <?php tpa_picture('logo-mark-cream.png', '', ['class'=>'mark-cream','width'=>'143','height'=>'160','decoding'=>'async']); ?>
      <span class="bn">wise <span>counsel</span></span>
    </a>
    <?php if ($nav_links): ?>
    <ul class="ln-anchors">
      <?php foreach ($nav_links as $l): ?>
      <li><a href="#<?php echo esc_attr($l['anchor_id'] ?? ''); ?>"><?php echo esc_html($l['label'] ?? ''); ?></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <a class="ln-nav-cta" href="sms:<?php echo esc_attr($phone_clean); ?>">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>
      <span class="lbl">Text Me</span>
    </a>
    <button class="ln-burger" id="lnBurger" aria-label="Open menu" aria-expanded="false"><span></span><span></span><span></span></button>
  </div>
  <?php // Always rendered: the burger shows at <=1024px regardless of nav_links,
        // and the drawer carries the Text Me CTA that leaves the bar on mobile. ?>
  <div class="ln-mobile" id="lnMobile">
    <?php foreach (($nav_links ?: []) as $l): ?>
    <a href="#<?php echo esc_attr($l['anchor_id'] ?? ''); ?>"><?php echo esc_html($l['label'] ?? ''); ?></a>
    <?php endforeach; ?>
    <a class="ln-mobile-cta" href="sms:<?php echo esc_attr($phone_clean); ?>">
      <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>
      <span>Text <?php echo esc_html($phone); ?></span>
    </a>
  </div>
</nav>

<main id="main" class="ln">

<!-- HERO -->
<header class="ln-hero">
  <?php // LCP element. Was a bare <img> pulling the 309KB JPG on mobile while the
        // homepage <picture> pulled a 127KB WebP — same photo, 2.4x the bytes on
        // the critical path. Mirrors front-page.php now. ?>
  <?php // LP-only hero variants. This renders at opacity .32 under a
        // rgba(44,56,51,.6->.86) gradient, so it takes far harder compression than
        // the homepage copy of the same photo: 127KB -> 54KB mobile, 317KB -> 134KB
        // desktop, with no visible difference through the overlay. ?>
  <picture>
    <source media="(max-width: 768px)" srcset="<?php echo esc_url($child_img . 'lp-hero-mobile-wm.webp'); ?>" type="image/webp">
    <source media="(min-width: 769px)" srcset="<?php echo esc_url($child_img . 'lp-hero-landscape-wm.webp'); ?>" type="image/webp">
    <img class="ln-hero-bg" src="<?php echo esc_url($child_img . 'front-hero-wm.jpg'); ?>" width="1200" height="881" alt="" fetchpriority="high" loading="eager" decoding="async">
  </picture>
  <div class="ln-hero-inner">
    <div class="ln-hero-copy">
      <?php if ($hero_eyebrow): ?><span class="ln-hero-eyebrow"><?php echo esc_html($hero_eyebrow); ?></span><?php endif; ?>
      <h1><?php echo wp_kses($hero_h1, ['br'=>[]]); ?></h1>
      <?php if ($hero_sub): ?><p class="ln-hero-sub"><?php echo wp_kses($hero_sub, ['br'=>[]]); ?></p><?php endif; ?>
      <div class="ln-hero-ctas">
        <?php if ($hero_cta2): ?><a class="btn btn-gold" href="sms:<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($hero_cta2); ?></a><?php endif; ?>
        <a class="btn btn-ghost" href="<?php echo esc_url($hero_cta_u); ?>"><?php echo esc_html($hero_cta); ?></a>
      </div>
      <?php if ($hero_meta): ?>
      <ul class="ln-hero-meta">
        <?php foreach ($hero_meta as $m): ?><li><?php echo esc_html($m['meta_text'] ?? ''); ?></li><?php endforeach; ?>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</header>

<!-- TRUST BADGES -->
<div class="ln-badges">
  <div class="ln-badges-inner">
    <span class="ln-badge"><svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>100% Confidential</span>
    <span class="ln-badge"><svg viewBox="0 0 24 24"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>Free Consultation</span>
    <span class="ln-badge"><svg viewBox="0 0 24 24"><path d="M12 2 4 6v6c0 5 3.5 8 8 10 4.5-2 8-5 8-10V6Z"/><path d="m9 12 2 2 4-4"/></svg>HIPAA-Compliant</span>
    <span class="ln-badge"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg>Faith-Fluent &amp; Affirming</span>
  </div>
</div>

<!-- PROBLEM -->
<section class="ln-sec ln-problem" id="problem">
  <div class="ln-wrap">
    <div class="ln-problem-grid ln-rev">
      <div class="ln-problem-copy">
        <?php if ($pain_h): ?><h2><?php echo esc_html($pain_h); ?></h2><?php endif; ?>
        <div class="twig" aria-hidden="true" style="margin-bottom:18px"></div>
        <?php echo wp_kses_post($pain_body); ?>
        <?php if ($symptoms):
          $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $symptoms))); ?>
        <ul class="ln-symptoms">
          <?php foreach ($lines as $s): ?><li><?php echo esc_html($s); ?></li><?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <?php if ($pain_close): ?><div class="ln-pain-close"><?php echo wp_kses_post(wpautop($pain_close)); ?></div><?php endif; ?>
      </div>
      <div class="ln-problem-fig">
        <?php tpa_picture($pain_img, '', ['width'=>'760','height'=>'575','loading'=>'lazy','decoding'=>'async']); ?>
      </div>
    </div>
  </div>
</section>

<!-- MID CTA BAND -->
<?php if ($mid_h): ?>
<section class="ln-band">
  <div class="ln-wrap ln-rev">
    <h2><?php echo esc_html($mid_h); ?></h2>
    <?php // The band's button was styled (.ln-band .btn) and its ACF text/URL
          // populated, but the markup was never emitted — so the label had been
          // pasted onto the end of the headline instead. ?>
    <?php if ($mid_btn && $mid_btn_url): ?>
      <a class="btn" href="<?php echo esc_url($mid_btn_url); ?>"><?php echo esc_html($mid_btn); ?></a>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<!-- SOLUTION -->
<section class="ln-sec ln-solution" id="solution">
  <div class="ln-wrap">
    <div class="ln-solution-grid ln-rev">
      <div class="ln-solution-fig">
        <?php tpa_picture($sol_img, '', ['width'=>'760','height'=>'558','loading'=>'lazy','decoding'=>'async']); ?>
      </div>
      <div class="ln-solution-copy">
        <?php if ($sol_h): ?><h2><?php echo esc_html($sol_h); ?></h2><?php endif; ?>
        <div class="twig" aria-hidden="true" style="margin-bottom:18px"></div>
        <?php echo wp_kses_post($sol_body); ?>
        <?php if ($ben_intro): ?><p class="ln-ben-intro"><?php echo esc_html($ben_intro); ?></p><?php endif; ?>
        <?php if ($benefits): ?>
        <ul class="ln-benefits">
          <?php foreach ($benefits as $b):
            $lbl = $b['label'] ?? ''; $bd = $b['body'] ?? '';
            $txt = ($lbl && $bd) ? $lbl . ' &#8211; ' . $bd : ($lbl ?: $bd); ?>
          <li><?php echo wp_kses($txt, ['strong'=>[],'em'=>[]]); ?></li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<?php if ($proc_steps): ?>
<section class="ln-sec ln-process" id="process">
  <div class="ln-wrap">
    <div class="ln-rev">
      <div class="ln-kicker">How It Works</div>
      <?php if ($proc_h): ?><h2><?php echo esc_html($proc_h); ?></h2><?php endif; ?>
    </div>
    <div class="ln-steps ln-rev">
      <?php foreach ($proc_steps as $i => $s):
        $st = $s['step_title'] ?? ''; $sd = $s['step_description'] ?? '';
        // split any appended tagline (bold second para) from the description
      ?>
      <div class="ln-step">
        <span class="ln-step-num"><?php echo (int)$i + 1; ?></span>
        <h3><?php echo esc_html($st); ?></h3>
        <p><?php echo wp_kses($sd, ['strong'=>['class'=>[]],'em'=>[],'br'=>[]]); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- TRUST -->
<?php if ($trust_items): ?>
<section class="ln-sec ln-trust" id="about">
  <div class="ln-wrap">
    <div class="ln-rev" style="text-align:center">
      <?php if ($trust_h): ?><h2><?php echo esc_html($trust_h); ?></h2><?php endif; ?>
    </div>
    <?php if ($about_bio): ?>
    <div class="ln-bio-card ln-rev">
      <div class="ln-bio-card-photo"><?php tpa_picture($hero_shot, 'Janet Canfield', ['width'=>'300','height'=>'336','loading'=>'lazy','decoding'=>'async']); ?></div>
      <div class="ln-bio-card-body">
        <span class="ln-bio-card-name">Janet Canfield, MA</span>
        <?php echo wp_kses_post($about_bio); ?>
      </div>
    </div>
    <?php endif; ?>
    <div class="ln-trust-grid ln-rev">
      <?php foreach ($trust_items as $t): ?>
      <div class="ln-pillar">
        <div class="twig" aria-hidden="true"></div>
        <h3><?php echo esc_html($t['title'] ?? ''); ?></h3>
        <p><?php echo esc_html($t['description'] ?? ''); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- FAQ -->
<?php if ($faqs): ?>
<section class="ln-sec ln-faq" id="faq">
  <div class="ln-wrap">
    <div class="ln-rev" style="text-align:center">
      <div class="ln-kicker" style="justify-content:center">Questions</div>
      <h2><?php echo esc_html($faq_h); ?></h2>
    </div>
    <div class="ln-faq-list ln-rev">
      <?php foreach ($faqs as $f):
        $q = $f['question'] ?? ''; $a = $f['answer'] ?? '';
        if (!$q) continue; ?>
      <div class="ln-faq-item">
        <button class="ln-faq-q" type="button" aria-expanded="false"><span><?php echo esc_html($q); ?></span><span class="ln-faq-ic" aria-hidden="true"></span></button>
        <div class="ln-faq-a"><div class="ln-faq-a-in"><?php echo wp_kses_post(wpautop($a)); ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- WHAT'S NEXT -->
<?php if ($next_h || $next_steps): ?>
<section class="ln-sec ln-next" id="next">
  <div class="ln-wrap ln-rev">
    <div class="ln-kicker" style="justify-content:center">Getting Started</div>
    <?php if ($next_h): ?><h2><?php echo esc_html($next_h); ?></h2><?php endif; ?>
    <?php if ($next_lead): ?><div class="ln-next-lead"><?php echo wp_kses_post($next_lead); ?></div><?php endif; ?>
    <?php if ($next_steps): ?>
    <div class="ln-next-steps">
      <?php foreach ($next_steps as $i => $s): ?>
      <div class="ln-next-step">
        <span class="ln-next-num"><?php echo (int)$i + 1; ?></span>
        <h3><?php echo esc_html($s['title'] ?? ''); ?></h3>
        <p><?php echo wp_kses($s['body'] ?? '', ['strong'=>[],'em'=>[],'br'=>[]]); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- integrated phone + form, centered below the steps -->
    <div class="ln-getstarted" id="form">
      <a class="ln-phone-big" href="sms:<?php echo esc_attr($phone_clean); ?>">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 11.5a8.4 8.4 0 0 1-8.5 8.3 8.9 8.9 0 0 1-3.2-.6L3 21l1.9-5.4a8 8 0 0 1-1.4-4.6A8.4 8.4 0 0 1 12 2.8a8.4 8.4 0 0 1 9 8.7Z"/></svg>
        <span class="ln-phone-big-label">Call or Text Janet &mdash; Free 10-Minute Consultation</span>
        <span class="ln-phone-big-num"><?php echo esc_html($phone); ?></span>
      </a>
      <div class="ln-form-card">
        <h3><?php echo esc_html($form_card ?: 'Prefer to write? Send a message'); ?></h3>
        <?php if ($form_sc) echo do_shortcode($form_sc); ?>
        <p class="ln-form-secure"><svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg>Everything you share is confidential.</p>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

</main>

<footer class="ln-footer">
  <?php tpa_picture('logo-full-ink.png', 'Wise Counsel', ['width'=>'170','height'=>'160','loading'=>'lazy','decoding'=>'async']); ?>
  <div class="ln-footer-contact">
    <a class="ln-footer-phone" href="sms:<?php echo esc_attr($phone_clean); ?>"><?php echo esc_html($phone); ?></a>
    <div class="ln-footer-addresses">
      <p class="ln-footer-address"><span>1796 Hendersonville Road</span><span>Asheville, NC 28803</span></p>
    </div>
  </div>
  <p class="ln-footer-fees">Services are billed on a session-by-session basis. Superbills are available for insurance reimbursement, and I accept HSA/FSA. No hidden fees &ndash; all costs are explained before you begin.</p>
  <div class="ln-footer-legal">
    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
    <a href="<?php echo esc_url(home_url('/terms-and-conditions/')); ?>">Terms &amp; Conditions</a>
  </div>
  <div class="ln-footer-copy">&copy; <?php echo esc_html(date('Y')); ?> Wise Counsel</div>
</footer>

<script>
(function(){
  var nav=document.querySelector('.ln-nav');
  if(nav){window.addEventListener('scroll',function(){nav.classList.toggle('scrolled',window.scrollY>8);},{passive:true});}
  var burger=document.getElementById('lnBurger'),mob=document.getElementById('lnMobile');
  if(burger&&mob){burger.addEventListener('click',function(){var o=mob.classList.toggle('open');burger.setAttribute('aria-expanded',o?'true':'false');});
    mob.querySelectorAll('a').forEach(function(a){a.addEventListener('click',function(){mob.classList.remove('open');});});}
  document.querySelectorAll('.ln-faq-item').forEach(function(item){
    var b=item.querySelector('.ln-faq-q');if(!b)return;
    b.addEventListener('click',function(){
      var was=item.classList.contains('open');
      document.querySelectorAll('.ln-faq-item.open').forEach(function(o){o.classList.remove('open');var ob=o.querySelector('.ln-faq-q');if(ob)ob.setAttribute('aria-expanded','false');});
      if(!was){item.classList.add('open');b.setAttribute('aria-expanded','true');}
    });
  });
  var revs=document.querySelectorAll('.ln-rev');
  if('IntersectionObserver' in window){
    var io=new IntersectionObserver(function(es){es.forEach(function(e){if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target);}});},{threshold:.12});
    revs.forEach(function(el){io.observe(el);});
    setTimeout(function(){revs.forEach(function(el){el.classList.add('in');});},8000);
  }else{revs.forEach(function(el){el.classList.add('in');});}
  document.querySelectorAll('a[href^="#"]').forEach(function(l){l.addEventListener('click',function(e){var h=l.getAttribute('href');if(!h||h==='#')return;var t=document.querySelector(h);if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}});});
})();
</script>
<?php wp_footer(); ?>
</body>
</html>
