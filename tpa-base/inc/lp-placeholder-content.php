<?php
/**
 * Landing Page Placeholder Content
 *
 * Sets generic, therapy-relevant placeholder content on a landing page.
 * Run via WP-CLI: wp eval-file lp-placeholder-content.php <page_id>
 *
 * @package TPA
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── Validate page ID ──
if ( empty( $args[0] ) ) {
    WP_CLI::error( 'Usage: wp eval-file lp-placeholder-content.php <page_id>' );
}

$page_id = (int) $args[0];
$page    = get_post( $page_id );

if ( ! $page || 'page' !== $page->post_type ) {
    WP_CLI::error( "Page ID {$page_id} does not exist or is not a page." );
}

WP_CLI::log( "Setting landing page placeholder content on page {$page_id} ({$page->post_title})..." );

// ── Simple text fields (update_post_meta) ──
$simple_fields = [

    // Header / SEO
    'lp_phone_override'      => '',
    'lp_seo_title'           => 'Find Relief – Start Therapy That Actually Works',
    'lp_seo_description'     => 'You deserve to feel like yourself again. Schedule a free consultation and take the first step toward lasting change.',

    // Hero
    'lp_hero_headline'       => 'You Deserve to Feel Like Yourself Again',
    'lp_hero_kicker'         => '', // optional tagline — leave blank; the template hides it when empty. Fill per-LP only when the client wants a hero tagline.
    'lp_hero_subheadline'    => 'Schedule your free 15-minute consultation and take the first step toward the life you want.',
    'lp_hero_primary_cta_text' => 'See How It Works',
    'lp_hero_primary_cta_url'  => '#process',
    'lp_hero_secondary_cta_text' => 'Call Now – Free Consult',
    'lp_hero_headshot'       => 'placeholder-headshot.jpg',

    // Pain
    'lp_pain_headline'       => 'If This Sounds Familiar, You\'re Not Alone',
    'lp_pain_image'          => 'placeholder-pain.jpg',

    // CTA Band
    'lp_cta_headline'        => 'You Don\'t Have to<br>Figure This Out Alone',
    'lp_cta_body'            => 'A single conversation can be the turning point. Let\'s find out if we\'re a good fit – no pressure, no obligation.',
    'lp_cta_button_text'     => 'Get Started Today',
    'lp_cta_button_url'      => '#form',

    // Authority
    'lp_authority_headline'  => 'A Therapist Who Gets It',
    'lp_authority_image'     => 'placeholder-authority.jpg',

    // Process
    'lp_process_eyebrow'     => 'What working together looks like',
    'lp_process_headline'    => 'Getting Started Is Simple',

    // Trust
    'lp_trust_headline'      => 'How I Practice',

    // Testimonials
    'lp_testimonials_headline' => 'What Clients Are Saying',

    // FAQ
    'lp_faq_eyebrow'         => 'Honest answers',
    'lp_faq_headline'        => 'Questions You Might Be Asking',
    'lp_faq_cta_text'        => 'Book a Free Consultation',

    // CTA Band 2
    'lp_cta2_eyebrow'        => 'Ready to Begin?',
    'lp_cta2_headline'       => 'Your First Session Is<br>Completely Free',
    'lp_cta2_button_text'    => 'Book Your FREE Session',
    'lp_cta2_button_url'     => '#form',

    // Form
    'lp_form_headline'       => 'Take the First Step Today',
    'lp_form_card_title'     => 'Request Your Free Consultation',
    'lp_form_subheadline'    => '<p>Fill out the form and we\'ll get back to you within 24 hours to schedule your free consultation.</p>',
];

foreach ( $simple_fields as $key => $value ) {
    update_post_meta( $page_id, $key, $value );
}
WP_CLI::log( '  ✓ Simple text fields set (' . count( $simple_fields ) . ' fields)' );

// ── WYSIWYG fields (update_post_meta, contain HTML) ──
$pain_body = '<p>You\'ve been carrying this for a while now – the worry that won\'t quiet down, the heaviness that follows you through the day, the feeling that something is off but you can\'t quite name it.</p>

<p>Maybe you\'ve tried pushing through. Telling yourself it\'ll pass. But it hasn\'t.</p>

<p>You might notice it in the way you snap at the people you love, or in the projects you keep putting off, or in the Sunday-night dread that starts earlier every week.</p>

<p>You\'re not broken. You\'re not weak. You\'re human – and you\'re dealing with more than anyone should handle alone.</p>

<p>The good news? It doesn\'t have to stay this way.</p>';

$authority_body = '<p>I\'ve spent years helping people just like you move from feeling stuck to feeling steady again.</p>

<p>My approach is warm, direct, and grounded in what the research says actually works. No jargon. No cookie-cutter advice. Just real, personalized support that meets you where you are.</p>

<p>I specialize in helping adults navigate anxiety, depression, life transitions, and relationship challenges – and I do it in a way that feels safe, collaborative, and (believe it or not) sometimes even enjoyable.</p>

<p>If you\'re ready to stop surviving and start living, I\'d love to talk.</p>

<p><a href="#form" class="lp-btn lp-btn-popup">Book Your Free Consultation</a></p>';

update_post_meta( $page_id, 'lp_pain_body', $pain_body );
update_post_meta( $page_id, 'lp_authority_body', $authority_body );
WP_CLI::log( '  ✓ WYSIWYG fields set (pain_body, authority_body)' );

// ── Repeater fields (MUST use update_field) ──

// Nav Links
$nav_links = [
    [ 'label' => 'How It Works', 'anchor_id' => 'process' ],
    [ 'label' => 'Testimonials', 'anchor_id' => 'testimonials' ],
    [ 'label' => 'FAQ',          'anchor_id' => 'faq' ],
    [ 'label' => 'Contact',      'anchor_id' => 'form' ],
];
update_field( 'lp_nav_links', $nav_links, $page_id );
WP_CLI::log( '  ✓ Nav links set (' . count( $nav_links ) . ' items)' );

// Process Steps
$process_steps = [
    [
        'step_title'       => 'Reach Out',
        'step_description' => 'Fill out the form or give us a call. We\'ll respond within 24 hours to find a time that works for you.',
    ],
    [
        'step_title'       => 'Free Consultation',
        'step_description' => 'We\'ll spend 15 minutes getting to know each other – no pressure, no obligation. Just a conversation about what you need.',
    ],
    [
        'step_title'       => 'Start Feeling Better',
        'step_description' => 'Together, we\'ll build a plan that fits your life. Most clients start noticing a shift within the first few sessions.',
    ],
];
update_field( 'lp_process_steps', $process_steps, $page_id );
WP_CLI::log( '  ✓ Process steps set (' . count( $process_steps ) . ' steps)' );

// Testimonials
$testimonials = [
    [
        'quote'       => 'I was skeptical about therapy, but from the very first session I felt heard. For the first time in years, I actually look forward to the week ahead.',
        'attribution' => '– Former Client',
    ],
    [
        'quote'       => 'I didn\'t realize how much I was holding in until I had a safe place to let it out. This has been life-changing.',
        'attribution' => '– Former Client',
    ],
    [
        'quote'       => 'I finally feel like myself again. The tools I\'ve learned here have made a real difference – not just for me, but for my whole family.',
        'attribution' => '– Former Client',
    ],
];
update_field( 'lp_testimonials', $testimonials, $page_id );
WP_CLI::log( '  ✓ Testimonials set (' . count( $testimonials ) . ' items)' );

// FAQs
$faqs = [
    [
        'question' => 'What happens in the free consultation?',
        'answer'   => '<p>We\'ll spend about 15 minutes talking about what\'s going on and what you\'re looking for. It\'s a chance for us to see if we\'re a good fit – no pressure, no commitment.</p>',
    ],
    [
        'question' => 'How long does therapy take?',
        'answer'   => '<p>Every person is different. Some clients find relief in just a few sessions, while others benefit from longer-term work.</p><p>We\'ll talk about your goals upfront and check in regularly so you always know where you stand.</p>',
    ],
    [
        'question' => 'Do you accept insurance?',
        'answer'   => '<p>We are an out-of-network provider. We provide superbills that you can submit to your insurance company for potential reimbursement.</p><p>We also accept HSA and FSA cards. All costs are explained before you begin – no surprises.</p>',
    ],
    [
        'question' => 'Is therapy really confidential?',
        'answer'   => '<p>Absolutely. Everything you share is protected by law and by our professional ethics. We follow strict HIPAA guidelines to keep your information safe.</p>',
    ],
    [
        'question' => 'What if I\'ve never been to therapy before?',
        'answer'   => '<p>That\'s completely okay – many of our clients are first-timers. There\'s no right or wrong way to do therapy.</p><p>We\'ll walk you through everything and go at a pace that feels comfortable for you.</p>',
    ],
];
update_field( 'lp_faqs', $faqs, $page_id );
WP_CLI::log( '  ✓ FAQs set (' . count( $faqs ) . ' items)' );

// ── Done ──
WP_CLI::success( "Landing page placeholder content set on page {$page_id} ({$page->post_title})." );
WP_CLI::log( '' );
WP_CLI::log( 'Fields set:' );
WP_CLI::log( '  • SEO title & description' );
WP_CLI::log( '  • Hero (headline, kicker, subheadline, CTAs, headshot)' );
WP_CLI::log( '  • Pain section (headline, body, image)' );
WP_CLI::log( '  • CTA band (headline, body, button)' );
WP_CLI::log( '  • Authority section (headline, body with inline CTA, image)' );
WP_CLI::log( '  • 3 process steps' );
WP_CLI::log( '  • 3 testimonials' );
WP_CLI::log( '  • 5 FAQs' );
WP_CLI::log( '  • CTA band 2 (eyebrow, headline, button)' );
WP_CLI::log( '  • Form section (headline, subheadline)' );
WP_CLI::log( '  • 4 nav links (How It Works, Testimonials, FAQ, Contact)' );
WP_CLI::log( '' );
WP_CLI::log( 'Images expected in child theme assets/images/:' );
WP_CLI::log( '  • placeholder-headshot.jpg' );
WP_CLI::log( '  • placeholder-pain.jpg' );
WP_CLI::log( '  • placeholder-authority.jpg' );
WP_CLI::log( '' );
WP_CLI::log( 'Note: form_shortcode is NOT set — it pulls from the site\'s TPA Settings options page.' );
