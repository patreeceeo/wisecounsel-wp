<?php
/**
 * TPA Base — ACF field definitions for Landing Page template.
 *
 * All field groups target page_template == page-landing.php.
 * Field names use the lp_ prefix.
 * Field groups are ordered by page position via menu_order.
 */

// ════════════════════════════════════════════════
// GROUP 1: Header & SEO (menu_order 0)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_header_seo',
    'menu_order' => 0,
    'title'      => 'Landing Page: Header & SEO',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_nav_links',
            'label'        => 'Navigation Links',
            'name'         => 'lp_nav_links',
            'type'         => 'repeater',
            'button_label' => 'Add Nav Link',
            'layout'       => 'table',
            'sub_fields'   => [
                [
                    'key'         => 'field_lp_nav_links_label',
                    'label'       => 'Link Label',
                    'name'        => 'label',
                    'type'        => 'text',
                    'placeholder' => 'How It Works',
                ],
                [
                    'key'          => 'field_lp_nav_links_anchor_id',
                    'label'        => 'Anchor ID',
                    'name'         => 'anchor_id',
                    'type'         => 'text',
                    'placeholder'  => 'process',
                    'instructions' => 'Section ID without the # — e.g., process, faq, form',
                ],
            ],
        ],
        [
            'key'          => 'field_lp_phone_override',
            'label'        => 'Phone Override',
            'name'         => 'lp_phone_override',
            'type'         => 'text',
            'instructions' => 'Leave blank to use the site-wide phone number from TPA Settings.',
        ],
        [
            'key'          => 'field_lp_seo_title',
            'label'        => 'SEO Title',
            'name'         => 'lp_seo_title',
            'type'         => 'text',
            'instructions' => 'Custom page title. Leave blank to use the WordPress page title.',
        ],
        [
            'key'          => 'field_lp_seo_description',
            'label'        => 'Meta Description',
            'name'         => 'lp_seo_description',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Custom meta description for search engines.',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 2: Hero (menu_order 1)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_hero',
    'menu_order' => 1,
    'title'      => 'Landing Page: Hero',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_hero_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_hero_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Leave blank to hide.',
            'placeholder'  => 'EMDR Therapy · La Crescenta, CA & Online',
        ],
        [
            'key'          => 'field_lp_hero_headline',
            'label'        => 'Headline (H1)',
            'name'         => 'lp_hero_headline',
            'type'         => 'text',
            'instructions' => 'Main attention-grabbing headline.',
        ],
        [
            'key'          => 'field_lp_hero_kicker',
            'label'        => 'Kicker Line',
            'name'         => 'lp_hero_kicker',
            'type'         => 'text',
            'instructions' => 'Secondary hook line displayed in italics below the headline.',
        ],
        [
            'key'          => 'field_lp_hero_subheadline',
            'label'        => 'Subheadline',
            'name'         => 'lp_hero_subheadline',
            'type'         => 'text',
            'instructions' => 'Supporting line below the kicker — typically includes location and service.',
        ],
        [
            'key'          => 'field_lp_hero_primary_cta_text',
            'label'        => 'Primary CTA Text',
            'name'         => 'lp_hero_primary_cta_text',
            'type'         => 'text',
            'placeholder'  => 'Book Your 15-min Consultation →',
            'instructions' => 'Button text. Leave blank to hide the button.',
        ],
        [
            'key'           => 'field_lp_hero_primary_cta_url',
            'label'         => 'Primary CTA URL',
            'name'          => 'lp_hero_primary_cta_url',
            'type'          => 'text',
            'default_value' => '#process',
        ],
        [
            'key'          => 'field_lp_hero_secondary_cta_text',
            'label'        => 'Secondary CTA Text',
            'name'         => 'lp_hero_secondary_cta_text',
            'type'         => 'text',
            'placeholder'  => 'OR CALL DIRECT',
            'instructions' => 'Label above the phone number. Leave blank to hide the phone link.',
        ],
        [
            'key'          => 'field_lp_hero_headshot',
            'label'        => 'Headshot Filename',
            'name'         => 'lp_hero_headshot',
            'type'         => 'text',
            'instructions' => 'Filename in child theme assets/images/ folder (e.g., lp-headshot.jpg). Displayed as circular crop. Leave blank for no headshot in the hero.',
            'placeholder'  => 'lp-headshot.jpg',
        ],
        [
            'key'          => 'field_lp_hero_credit_name',
            'label'        => 'Photo Credit Name',
            'name'         => 'lp_hero_credit_name',
            'type'         => 'text',
            'instructions' => 'Name shown below the headshot. Leave blank to hide.',
            'placeholder'  => 'Jane Doe, LMHC',
        ],
        [
            'key'          => 'field_lp_hero_credit_tagline',
            'label'        => 'Credit Tagline',
            'name'         => 'lp_hero_credit_tagline',
            'type'         => 'text',
            'instructions' => 'Optional short italic tagline below the credit name (e.g. a motto). Leave blank to hide.',
            'placeholder'  => 'Iron Sharpens Iron',
        ],
        [
            'key'          => 'field_lp_show_bilateral',
            'label'        => 'Show Bilateral EMDR Animation',
            'name'         => 'lp_show_bilateral',
            'type'         => 'true_false',
            'instructions' => 'Shows a small "Bilateral · Reprocessing" eye-movement animation under the hero copy. Enable for EMDR-focused landing pages.',
            'ui'           => 1,
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 3: Pain Section (menu_order 2)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_pain',
    'menu_order' => 2,
    'title'      => 'Landing Page: Pain Section',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_problem_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_problem_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Leave blank to hide.',
        ],
        [
            'key'   => 'field_lp_pain_headline',
            'label' => 'Headline',
            'name'  => 'lp_pain_headline',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_lp_pain_body',
            'label'        => 'Body Copy',
            'name'         => 'lp_pain_body',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'basic',
            'media_upload' => 0,
        ],
        [
            'key'          => 'field_lp_problem_symptoms',
            'label'        => 'Symptoms List',
            'name'         => 'lp_problem_symptoms',
            'type'         => 'textarea',
            'rows'         => 5,
            'instructions' => 'One symptom per line — rendered as a bulleted "If any of this sounds familiar" list. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_problem_close',
            'label'        => 'Closing Statement',
            'name'         => 'lp_problem_close',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'basic',
            'media_upload' => 0,
            'instructions' => 'Short reassurance line under the symptoms list. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_problem_floater_quote',
            'label'        => 'Image Floater Quote',
            'name'         => 'lp_problem_floater_quote',
            'type'         => 'text',
            'instructions' => 'Short quote overlaid on the section image. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_pain_image',
            'label'        => 'Image Filename (1)',
            'name'         => 'lp_pain_image',
            'type'         => 'text',
            'instructions' => 'Filename in child theme assets/images/',
            'placeholder'  => 'lp-pain.jpg',
        ],
        [
            'key'          => 'field_lp_pain_image_2',
            'label'        => 'Image Filename (2, optional)',
            'name'         => 'lp_pain_image_2',
            'type'         => 'text',
            'instructions' => 'Optional second image stacked below the first to balance tall body copy.',
        ],
        [
            'key'          => 'field_lp_pain_image_3',
            'label'        => 'Image Filename (3, optional)',
            'name'         => 'lp_pain_image_3',
            'type'         => 'text',
            'instructions' => 'Optional third image.',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 4: CTA Band (menu_order 3)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_cta_band',
    'menu_order' => 3,
    'title'      => 'Landing Page: CTA Band',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'   => 'field_lp_cta_headline',
            'label' => 'Headline',
            'name'  => 'lp_cta_headline',
            'type'  => 'text',
        ],
        [
            'key'  => 'field_lp_cta_body',
            'label' => 'Body Text',
            'name'  => 'lp_cta_body',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
        [
            'key'         => 'field_lp_cta_button_text',
            'label'       => 'Button Text',
            'name'        => 'lp_cta_button_text',
            'type'        => 'text',
            'placeholder' => 'Get Started Today',
        ],
        [
            'key'           => 'field_lp_cta_button_url',
            'label'         => 'Button URL',
            'name'          => 'lp_cta_button_url',
            'type'          => 'text',
            'default_value' => '#form',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 5: Authority Section (menu_order 4)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_authority',
    'menu_order' => 4,
    'title'      => 'Landing Page: Authority Section',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_solution_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_solution_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Leave blank to hide.',
        ],
        [
            'key'   => 'field_lp_authority_headline',
            'label' => 'Headline',
            'name'  => 'lp_authority_headline',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_lp_authority_body',
            'label'        => 'Body Copy',
            'name'         => 'lp_authority_body',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'full',
            'media_upload' => 0,
            'instructions' => 'Supports bullet lists — use the list button in the editor for checkmark-styled items.',
        ],
        [
            'key'          => 'field_lp_solution_analogy',
            'label'        => 'Pull-Quote / Analogy',
            'name'         => 'lp_solution_analogy',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Short highlighted callout line under the body copy. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_solution_benefits_intro',
            'label'        => 'Benefits List Intro',
            'name'         => 'lp_solution_benefits_intro',
            'type'         => 'text',
            'instructions' => 'Line introducing the benefits list below (e.g. "Many clients notice changes like these:"). Leave blank to hide.',
        ],
        [
            'key'         => 'field_lp_authority_image',
            'label'       => 'Image Filename',
            'name'        => 'lp_authority_image',
            'type'        => 'text',
            'placeholder' => 'lp-authority.jpg',
        ],
        [
            'key'          => 'field_lp_solution_float_label',
            'label'        => 'Image Floater Label',
            'name'         => 'lp_solution_float_label',
            'type'         => 'text',
            'instructions' => 'Small label above the floater quote on the section image. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_solution_float_quote',
            'label'        => 'Image Floater Quote',
            'name'         => 'lp_solution_float_quote',
            'type'         => 'text',
            'instructions' => 'Short quote overlaid on the section image. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_solution_cta_text',
            'label'        => 'CTA Button Text',
            'name'         => 'lp_solution_cta_text',
            'type'         => 'text',
            'instructions' => 'Button below the benefits list. Leave blank to hide.',
        ],
        [
            'key'           => 'field_lp_solution_cta_url',
            'label'         => 'CTA Button URL',
            'name'          => 'lp_solution_cta_url',
            'type'          => 'text',
            'default_value' => '#form',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 6: Process Section (menu_order 5)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_process',
    'menu_order' => 5,
    'title'      => 'Landing Page: Process Steps',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_process_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_process_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Leave blank to hide.',
            'placeholder'  => 'What working together looks like',
        ],
        [
            'key'          => 'field_lp_process_headline',
            'label'        => 'Section Headline',
            'name'         => 'lp_process_headline',
            'type'         => 'text',
            'instructions' => 'Leave blank to hide.',
            'placeholder'  => 'How Our Work Unfolds',
        ],
        [
            'key'          => 'field_lp_process_intro',
            'label'        => 'Intro Line',
            'name'         => 'lp_process_intro',
            'type'         => 'text',
            'instructions' => 'Short line under the headline, above the steps. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_process_steps',
            'label'        => 'Steps',
            'name'         => 'lp_process_steps',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Step',
            'max'          => 4,
            'sub_fields'   => [
                [
                    'key'   => 'field_lp_process_step_title',
                    'label' => 'Step Title',
                    'name'  => 'step_title',
                    'type'  => 'text',
                ],
                [
                    'key'  => 'field_lp_process_step_description',
                    'label' => 'Step Description',
                    'name'  => 'step_description',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
            ],
        ],
        [
            'key'          => 'field_lp_process_cta_text',
            'label'        => 'CTA Button Text',
            'name'         => 'lp_process_cta_text',
            'type'         => 'text',
            'instructions' => 'Button below the steps. Leave blank to hide.',
        ],
        [
            'key'           => 'field_lp_process_cta_url',
            'label'         => 'CTA Button URL',
            'name'          => 'lp_process_cta_url',
            'type'          => 'text',
            'default_value' => '#form',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 6b: Trust / Why Trust Me (menu_order 6)
// Sits between Process (5) and Testimonials (7).
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_trust',
    'menu_order' => 6,
    'title'      => 'Landing Page: Trust / Why Trust Me',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'           => 'field_lp_trust_headline',
            'label'         => 'Section Headline',
            'name'          => 'lp_trust_headline',
            'type'          => 'text',
            'placeholder'   => 'Why Trust Me as Your Partner in Healing',
        ],
        [
            'key'          => 'field_lp_trust_items',
            'label'        => 'Trust Items',
            'name'         => 'lp_trust_items',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Item',
            'sub_fields'   => [
                [
                    'key'   => 'field_lp_trust_item_title',
                    'label' => 'Title',
                    'name'  => 'title',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_lp_trust_item_description',
                    'label' => 'Description',
                    'name'  => 'description',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
            ],
        ],
        [
            'key'          => 'field_lp_about_eyebrow',
            'label'        => 'Bio Eyebrow Text',
            'name'         => 'lp_about_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the bio headshot/headline. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_about_headline',
            'label'        => 'Bio Headline',
            'name'         => 'lp_about_headline',
            'type'         => 'text',
            'instructions' => 'Headline in the bio column (right side). Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_about_bio',
            'label'        => 'Bio Copy',
            'name'         => 'lp_about_bio',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'basic',
            'media_upload' => 0,
        ],
        [
            'key'          => 'field_lp_about_signature',
            'label'        => 'Signature Line',
            'name'         => 'lp_about_signature',
            'type'         => 'text',
            'placeholder'  => '– Jane Doe, LMFT',
        ],
        [
            'key'          => 'field_lp_about_credentials',
            'label'        => 'Credentials List',
            'name'         => 'lp_about_credentials',
            'type'         => 'textarea',
            'rows'         => 5,
            'instructions' => 'One credential per line. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_trust_image',
            'label'        => 'Image Filename (optional)',
            'name'         => 'lp_trust_image',
            'type'         => 'text',
            'instructions' => 'Filename in child theme assets/images/. Displays to the right of the items; leave blank for items-only.',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 7: Testimonials (menu_order 7)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_testimonials',
    'menu_order' => 7,
    'title'      => 'Landing Page: Testimonials',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_testimonials_headline',
            'label'        => 'Section Headline',
            'name'         => 'lp_testimonials_headline',
            'type'         => 'text',
            'instructions' => 'Leave blank to hide.',
            'placeholder'  => 'What Clients Are Saying',
        ],
        [
            'key'          => 'field_lp_testimonials_intro',
            'label'        => 'Intro Line',
            'name'         => 'lp_testimonials_intro',
            'type'         => 'text',
            'instructions' => 'Short line under the headline. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_testimonials',
            'label'        => 'Testimonials',
            'name'         => 'lp_testimonials',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Testimonial',
            'sub_fields'   => [
                [
                    'key'  => 'field_lp_testimonials_quote',
                    'label' => 'Quote',
                    'name'  => 'quote',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'          => 'field_lp_testimonials_attribution',
                    'label'        => 'Attribution',
                    'name'         => 'attribution',
                    'type'         => 'text',
                    'instructions' => 'e.g., \'Former Client\' or initials. Leave blank if anonymous.',
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 8: FAQ (menu_order 8)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_faq',
    'menu_order' => 8,
    'title'      => 'Landing Page: FAQ',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_faq_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_faq_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Leave blank to hide.',
            'placeholder'  => 'Honest answers',
        ],
        [
            'key'          => 'field_lp_faq_headline',
            'label'        => 'Section Headline',
            'name'         => 'lp_faq_headline',
            'type'         => 'text',
            'instructions' => 'Leave blank to hide.',
            'placeholder'  => 'Things people ask before they call.',
        ],
        [
            'key'          => 'field_lp_faq_intro',
            'label'        => 'Intro Line',
            'name'         => 'lp_faq_intro',
            'type'         => 'text',
            'instructions' => 'Short line under the headline, above the questions. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_faqs',
            'label'        => 'FAQ Items',
            'name'         => 'lp_faqs',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Question',
            'sub_fields'   => [
                [
                    'key'   => 'field_lp_faqs_question',
                    'label' => 'Question',
                    'name'  => 'question',
                    'type'  => 'text',
                ],
                [
                    'key'          => 'field_lp_faqs_answer',
                    'label'        => 'Answer',
                    'name'         => 'answer',
                    'type'         => 'wysiwyg',
                    'tabs'         => 'all',
                    'toolbar'      => 'basic',
                    'media_upload' => 0,
                ],
            ],
        ],
        [
            'key'          => 'field_lp_faq_cta_text',
            'label'        => 'CTA Button Text',
            'name'         => 'lp_faq_cta_text',
            'type'         => 'text',
            'instructions' => 'Button below the FAQ headline. Leave blank to hide.',
            'placeholder'  => 'Book a Free Consultation',
        ],
        [
            'key'          => 'field_lp_faq_cta_url',
            'label'        => 'CTA Button URL',
            'name'         => 'lp_faq_cta_url',
            'type'         => 'text',
            'instructions' => 'Leave blank to link to the form (#form).',
            'placeholder'  => '#form',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 9: CTA Band 2 (menu_order 9)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_cta2',
    'menu_order' => 9,
    'title'      => 'Landing Page: CTA Band 2',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_cta2_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_cta2_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small text above the headline (e.g. "Limited Availability This Month")',
        ],
        [
            'key'          => 'field_lp_cta2_headline',
            'label'        => 'Headline',
            'name'         => 'lp_cta2_headline',
            'type'         => 'text',
            'instructions' => 'Main headline. HTML allowed for line breaks.',
        ],
        [
            'key'          => 'field_lp_whatnext_lead',
            'label'        => 'Lead Paragraph',
            'name'         => 'lp_whatnext_lead',
            'type'         => 'textarea',
            'rows'         => 3,
            'instructions' => 'Plain-text paragraph under the headline, above the numbered steps. No HTML — rendered as plain text.',
        ],
        [
            'key'         => 'field_lp_cta2_button_text',
            'label'       => 'Button Text',
            'name'        => 'lp_cta2_button_text',
            'type'        => 'text',
            'placeholder' => 'Book Your FREE Session',
        ],
        [
            'key'           => 'field_lp_cta2_button_url',
            'label'         => 'Button URL',
            'name'          => 'lp_cta2_button_url',
            'type'          => 'text',
            'default_value' => '#form',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 10: Form Section (menu_order 10)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'        => 'group_lp_form',
    'menu_order' => 10,
    'title'      => 'Landing Page: Form Section',
    'location'   => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-landing.php' ] ] ],
    'position'   => 'normal',
    'fields'     => [
        [
            'key'          => 'field_lp_form_eyebrow',
            'label'        => 'Eyebrow Text',
            'name'         => 'lp_form_eyebrow',
            'type'         => 'text',
            'instructions' => 'Small label above the headline. Defaults to "Don\'t wait" if left blank.',
        ],
        [
            'key'          => 'field_lp_form_headline',
            'label'        => 'Headline',
            'name'         => 'lp_form_headline',
            'type'         => 'text',
            'instructions' => 'Leave blank to hide.',
            'placeholder'  => 'Take the First Step Today',
        ],
        [
            'key'   => 'field_lp_form_subheadline',
            'label' => 'Subheadline',
            'name'  => 'lp_form_subheadline',
            'type'  => 'text',
        ],
        [
            'key'          => 'field_lp_form_detail',
            'label'        => 'Additional Detail',
            'name'         => 'lp_form_detail',
            'type'         => 'wysiwyg',
            'tabs'         => 'all',
            'toolbar'      => 'basic',
            'media_upload' => 0,
            'instructions' => 'Optional extra block under the subheadline. Leave blank to hide.',
        ],
        [
            'key'          => 'field_lp_form_card_title',
            'label'        => 'Form Card Title',
            'name'         => 'lp_form_card_title',
            'type'         => 'text',
            'instructions' => 'Heading inside the form card. Leave blank to hide.',
            'placeholder'  => 'Request Your Free Consultation',
        ],
        [
            'key'          => 'field_lp_form_shortcode',
            'label'        => 'Form Shortcode Override',
            'name'         => 'lp_form_shortcode',
            'type'         => 'text',
            'instructions' => 'WPForms shortcode. Leave blank to use the site-wide form from TPA Settings.',
            'placeholder'  => '[wpforms id="123"]',
        ],
    ],
] );

// ════════════════════════════════════════════════
// Repeaters rendered by page-landing.php but historically omitted from the
// groups above. Without registration, get_field() returns the raw row-count
// string instead of expanding the rows, so the content renders empty — the
// recurring "left content is missing" bug (hero meta bullets, solution
// benefits, and the "What Happens Next?" steps). Sub-field NAMES match both the
// template's array access and the stored postmeta keys so existing data resolves.
// ════════════════════════════════════════════════
acf_add_local_field( [
    'key'          => 'field_lp_hero_meta_items',
    'parent'       => 'group_lp_hero',
    'label'        => 'Hero Meta Items',
    'name'         => 'lp_hero_meta_items',
    'type'         => 'repeater',
    'layout'       => 'table',
    'button_label' => 'Add Item',
    'sub_fields'   => [
        [ 'key' => 'field_lp_hero_meta_text', 'label' => 'Text', 'name' => 'meta_text', 'type' => 'text' ],
    ],
] );

acf_add_local_field( [
    'key'          => 'field_lp_solution_benefits',
    'parent'       => 'group_lp_authority',
    'label'        => 'Benefits',
    'name'         => 'lp_solution_benefits',
    'type'         => 'repeater',
    'layout'       => 'block',
    'button_label' => 'Add Benefit',
    'sub_fields'   => [
        [ 'key' => 'field_lp_solution_benefit_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text' ],
        [ 'key' => 'field_lp_solution_benefit_body',  'label' => 'Body',  'name' => 'body',  'type' => 'textarea' ],
    ],
] );

acf_add_local_field( [
    'key'          => 'field_lp_whatnext_steps',
    'parent'       => 'group_lp_cta2',
    'label'        => 'What Happens Next Steps',
    'name'         => 'lp_whatnext_steps',
    'type'         => 'repeater',
    'layout'       => 'block',
    'button_label' => 'Add Step',
    'sub_fields'   => [
        [ 'key' => 'field_lp_whatnext_step_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
        [ 'key' => 'field_lp_whatnext_step_body',  'label' => 'Body',  'name' => 'body',  'type' => 'textarea' ],
    ],
] );
