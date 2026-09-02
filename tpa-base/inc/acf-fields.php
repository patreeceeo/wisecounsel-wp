<?php
/**
 * TPA Base — ACF field group definitions.
 *
 * All field groups registered via PHP (no JSON import needed).
 * Field names must match exactly what template parts reference.
 */

// ── Options Page ──
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( [
        'page_title' => 'TPA Site Settings',
        'menu_title' => 'TPA Settings',
        'menu_slug'  => 'tpa-settings',
        'capability' => 'edit_posts',
        'redirect'   => false,
        'icon_url'   => 'dashicons-admin-home',
        'position'   => 2,
    ] );
}

// ════════════════════════════════════════════════
// GROUP 1: Site Identity (Options Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_site_identity',
    'menu_order' => 0,
    'title'    => 'TPA Site Identity',
    'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tpa-settings' ] ] ],
    'position' => 'normal',
    'fields'   => [
        [
            'key'          => 'field_site_identity_practice_name',
            'label'        => 'Practice Name',
            'name'         => 'site_identity_practice_name',
            'type'         => 'text',
            'instructions' => 'Full practice name as it should appear in the nav and footer.',
        ],
        [
            'key'          => 'field_site_identity_tagline',
            'label'        => 'Tagline',
            'name'         => 'site_identity_tagline',
            'type'         => 'text',
            'instructions' => 'Short tagline (used in meta description fallback).',
        ],
        [
            'key'          => 'field_site_identity_phone',
            'label'        => 'Phone Number',
            'name'         => 'site_identity_phone',
            'type'         => 'text',
            'instructions' => 'Formatted phone number, e.g., (555) 123-4567.',
        ],
        [
            'key'          => 'field_site_identity_email',
            'label'        => 'Email Address',
            'name'         => 'site_identity_email',
            'type'         => 'email',
            'instructions' => 'Primary contact email.',
        ],
        [
            'key'          => 'field_site_identity_address',
            'label'        => 'Office Address',
            'name'         => 'site_identity_address',
            'type'         => 'textarea',
            'rows'         => 3,
            'instructions' => 'Leave blank for online-only practices.',
        ],
        [
            'key'          => 'field_site_identity_license_disclosure',
            'label'        => 'License / Supervision Disclosure',
            'name'         => 'site_identity_license_disclosure',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Any required legal disclosure (e.g., "Under supervision of...").',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 2: Social Links (Options Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_social_links',
    'menu_order' => 1,
    'title'    => 'TPA Social Links',
    'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tpa-settings' ] ] ],
    'position' => 'normal',
    'fields'   => [
        [
            'key'   => 'field_social_psychology_today',
            'label' => 'Psychology Today Profile URL',
            'name'  => 'social_psychology_today',
            'type'  => 'url',
        ],
        [
            'key'   => 'field_social_facebook',
            'label' => 'Facebook URL',
            'name'  => 'social_facebook',
            'type'  => 'url',
        ],
        [
            'key'   => 'field_social_instagram',
            'label' => 'Instagram URL',
            'name'  => 'social_instagram',
            'type'  => 'url',
        ],
        [
            'key'   => 'field_social_linkedin',
            'label' => 'LinkedIn URL',
            'name'  => 'social_linkedin',
            'type'  => 'url',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 3: Form Settings (Options Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_form_settings',
    'menu_order' => 2,
    'title'    => 'TPA Form Settings',
    'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'tpa-settings' ] ] ],
    'position' => 'normal',
    'fields'   => [
        [
            'key'          => 'field_form_wpforms_shortcode',
            'label'        => 'Contact Form Shortcode',
            'name'         => 'form_wpforms_shortcode',
            'type'         => 'text',
            'instructions' => 'WPForms shortcode, e.g., [wpforms id="123"]',
            'placeholder'  => '[wpforms id="123"]',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 4: Homepage — Hero (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_hero',
    'menu_order' => 0,
    'title'    => 'TPA Homepage: Hero',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_hero_headline_1',
            'label'        => 'Hero Headline (Line 1)',
            'name'         => 'hero_headline_1',
            'type'         => 'text',
            'instructions' => 'Primary headline, first line.',
        ],
        [
            'key'          => 'field_hero_headline_2',
            'label'        => 'Hero Headline (Line 2)',
            'name'         => 'hero_headline_2',
            'type'         => 'text',
            'instructions' => 'Optional second line. Leave blank for single-line hero.',
        ],
        [
            'key'          => 'field_hero_subtitle',
            'label'        => 'Hero Subtitle',
            'name'         => 'hero_subtitle',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Short description below the headline.',
        ],
        [
            'key'          => 'field_hero_location',
            'label'        => 'Hero Location Text',
            'name'         => 'hero_location',
            'type'         => 'text',
            'instructions' => 'Optional location line (e.g., "Serving Sedona, AZ & Online").',
        ],
        [
            'key'           => 'field_hero_cta_text',
            'label'         => 'Hero CTA Button Text',
            'name'          => 'hero_cta_text',
            'type'          => 'text',
            'default_value' => 'Get Started',
        ],
        [
            'key'           => 'field_hero_cta_url',
            'label'         => 'Hero CTA Button URL',
            'name'          => 'hero_cta_url',
            'type'          => 'text',
            'default_value' => '#contact',
            'instructions'  => 'Link target. Use #contact for same-page scroll.',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 5: Homepage — Story Panels (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_story_panels',
    'menu_order' => 1,
    'title'    => 'TPA Homepage: Story Panels',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_story_panels',
            'label'        => 'Story Panels',
            'name'         => 'story_panels',
            'type'         => 'repeater',
            'instructions' => 'Pain points, vignettes, or body content panels.',
            'layout'       => 'block',
            'button_label' => 'Add Panel',
            'sub_fields'   => [
                [
                    'key'   => 'field_story_panel_headline',
                    'label' => 'Headline',
                    'name'  => 'headline',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_story_panel_body_text',
                    'label' => 'Body Text',
                    'name'  => 'body_text',
                    'type'  => 'wysiwyg',
                    'tabs'  => 'all',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ],
                [
                    'key'          => 'field_story_panel_quote',
                    'label'        => 'Pull Quote',
                    'name'         => 'quote',
                    'type'         => 'text',
                    'instructions' => 'Optional. Used by vignettes and quote-panels variants.',
                ],
                [
                    'key'          => 'field_story_panel_image_name',
                    'label'        => 'Image Filename',
                    'name'         => 'image_name',
                    'type'         => 'text',
                    'instructions' => 'Filename in child theme assets/images/ (for image-panels variant only).',
                    'placeholder'  => 'front-story-ocean-wm.jpg',
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 6: Homepage — CTA Bridges (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_cta_bridges',
    'menu_order' => 2,
    'title'    => 'TPA Homepage: CTA Bridges',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_cta_bridges',
            'label'        => 'CTA Bridge Sections',
            'name'         => 'cta_bridges',
            'type'         => 'repeater',
            'instructions' => 'Transitional CTA sections between major content blocks.',
            'layout'       => 'block',
            'button_label' => 'Add CTA Bridge',
            'sub_fields'   => [
                [
                    'key'   => 'field_cta_bridge_headline',
                    'label' => 'Headline',
                    'name'  => 'headline',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_cta_bridge_body_text',
                    'label' => 'Body Text',
                    'name'  => 'body_text',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'           => 'field_cta_bridge_button_text',
                    'label'         => 'Button Text',
                    'name'          => 'button_text',
                    'type'          => 'text',
                    'default_value' => 'Learn More',
                ],
                [
                    'key'           => 'field_cta_bridge_button_url',
                    'label'         => 'Button URL',
                    'name'          => 'button_url',
                    'type'          => 'text',
                    'default_value' => '#contact',
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 7: Homepage — Bio (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_bio',
    'menu_order' => 3,
    'title'    => 'TPA Homepage: Bio',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_bio_heading',
            'label'        => 'Bio Heading',
            'name'         => 'bio_heading',
            'type'         => 'text',
            'instructions' => 'e.g., "Hi, I\'m John" or "Meet Your Therapist"',
        ],
        [
            'key'     => 'field_bio_body',
            'label'   => 'Bio Body Text',
            'name'    => 'bio_body',
            'type'    => 'wysiwyg',
            'tabs'    => 'all',
            'toolbar' => 'full',
            'media_upload' => 0,
        ],
        [
            'key'          => 'field_bio_credentials',
            'label'        => 'Credentials',
            'name'         => 'bio_credentials',
            'type'         => 'text',
            'instructions' => 'e.g., "LPC, NCC, EMDR Certified"',
        ],
        [
            'key'          => 'field_bio_quote',
            'label'        => 'Pull Quote',
            'name'         => 'bio_quote',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'A highlighted quote or key message from the bio.',
        ],
        [
            'key'           => 'field_bio_cta_text',
            'label'         => 'Bio CTA Button Text',
            'name'          => 'bio_cta_text',
            'type'          => 'text',
            'default_value' => 'Learn More About Me',
        ],
        [
            'key'           => 'field_bio_cta_url',
            'label'         => 'Bio CTA Button URL',
            'name'          => 'bio_cta_url',
            'type'          => 'text',
            'default_value' => '/about',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 8: Homepage — Services Heading (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_services',
    'menu_order' => 4,
    'title'    => 'TPA Homepage: Services',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'           => 'field_services_heading',
            'label'         => 'Services Section Heading',
            'name'          => 'services_heading',
            'type'          => 'text',
            'default_value' => 'What I Offer',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 9: Homepage — Final CTA (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_final_cta',
    'menu_order' => 5,
    'title'    => 'TPA Homepage: Final CTA',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'   => 'field_final_cta_headline',
            'label' => 'Final CTA Headline',
            'name'  => 'final_cta_headline',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_final_cta_body',
            'label' => 'Final CTA Body Text',
            'name'  => 'final_cta_body',
            'type'  => 'textarea',
            'rows'  => 3,
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 10: Homepage — Testimonials (Front Page)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_testimonials',
    'menu_order' => 6,
    'title'    => 'TPA Homepage: Testimonials',
    'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_testimonials',
            'label'        => 'Testimonials',
            'name'         => 'testimonials',
            'type'         => 'repeater',
            'layout'       => 'block',
            'button_label' => 'Add Testimonial',
            'sub_fields'   => [
                [
                    'key'   => 'field_testimonial_quote',
                    'label' => 'Quote',
                    'name'  => 'quote',
                    'type'  => 'textarea',
                    'rows'  => 3,
                ],
                [
                    'key'          => 'field_testimonial_attribution',
                    'label'        => 'Attribution',
                    'name'         => 'attribution',
                    'type'         => 'text',
                    'instructions' => 'e.g., "Former Client" or initials. Leave blank if anonymous.',
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 11: Service Fields (Service CPT)
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_service_fields',
    'menu_order' => 0,
    'title'    => 'TPA Service Page',
    'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-service.php' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'          => 'field_service_subtitle',
            'label'        => 'Subtitle',
            'name'         => 'service_subtitle',
            'type'         => 'text',
            'instructions' => 'Optional subtitle shown on the individual service page.',
        ],
        [
            'key'           => 'field_service_link_text',
            'label'         => 'Link Text',
            'name'          => 'service_link_text',
            'type'          => 'text',
            'default_value' => 'Learn More',
            'instructions'  => 'CTA text used in the homepage services listing.',
        ],
        [
            'key'           => 'field_service_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a hero image. Recommended: 1400px wide, landscape.',
        ],
        // Body images are NOT ACF fields — they live inline in post_content
        // via the standard WP editor Media Library (flexible count, native
        // editing). Click an image in the editor to swap it via "Add Media".
    ],
] );

// ════════════════════════════════════════════════
// GROUP 12: About Page Fields
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_about_page',
    'menu_order' => 0,
    'title'    => 'TPA About Page',
    'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-about.php' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'           => 'field_about_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a hero image to replace the current one. Recommended: 1400px wide. Leave blank to use the default.',
        ],
        [
            'key'   => 'field_about_bio_heading',
            'label' => 'Bio Heading',
            'name'  => 'about_bio_heading',
            'type'  => 'text',
        ],
        [
            'key'     => 'field_about_bio_body',
            'label'   => 'Bio Body',
            'name'    => 'about_bio_body',
            'type'    => 'wysiwyg',
            'toolbar' => 'full',
            'media_upload' => 1,
        ],
        [
            'key'   => 'field_about_bio_credentials',
            'label' => 'Credentials',
            'name'  => 'about_bio_credentials',
            'type'  => 'text',
        ],
        [
            'key'   => 'field_about_bio_quote',
            'label' => 'Pull Quote',
            'name'  => 'about_bio_quote',
            'type'  => 'textarea',
            'rows'  => 2,
        ],
        [
            'key'           => 'field_about_team_heading',
            'label'         => 'Team Section Heading',
            'name'          => 'about_team_heading',
            'type'          => 'text',
            'default_value' => 'Meet the Team',
            'instructions'  => 'Only used for group practices.',
        ],
        [
            'key'          => 'field_about_team_members',
            'label'        => 'Team Members',
            'name'         => 'about_team_members',
            'type'         => 'repeater',
            'instructions' => 'For group practices only. Leave empty for solo practitioners.',
            'layout'       => 'block',
            'button_label' => 'Add Team Member',
            'sub_fields'   => [
                [
                    'key'   => 'field_team_member_name',
                    'label' => 'Name',
                    'name'  => 'name',
                    'type'  => 'text',
                ],
                [
                    'key'   => 'field_team_member_title',
                    'label' => 'Title / Credentials',
                    'name'  => 'title',
                    'type'  => 'text',
                ],
                [
                    'key'     => 'field_team_member_bio',
                    'label'   => 'Bio',
                    'name'    => 'bio',
                    'type'    => 'wysiwyg',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ],
                [
                    'key'          => 'field_team_member_photo',
                    'label'        => 'Photo Filename',
                    'name'         => 'photo_filename',
                    'type'         => 'text',
                    'instructions' => 'Filename in child theme assets/images/',
                    'placeholder'  => 'about-team-jane.jpg',
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 13: Contact Page Fields
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_contact_page',
    'menu_order' => 0,
    'title'    => 'TPA Contact Page',
    'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-contact.php' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'           => 'field_contact_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a hero image to replace the current one. Recommended: 1400px wide. Leave blank to use the default.',
        ],
        [
            'key'          => 'field_contact_location_label',
            'label'        => 'Location Label',
            'name'         => 'contact_location_label',
            'type'         => 'text',
            'instructions' => 'Shown next to the "Location" label on the Contact page.',
            'placeholder'  => 'Loganville, GA (Online)',
        ],
        [
            'key'          => 'field_contact_service_area',
            'label'        => 'Service Area Label',
            'name'         => 'contact_service_area',
            'type'         => 'text',
            'instructions' => 'Shown next to the "Virtual" label (e.g., "Available Throughout Georgia").',
            'placeholder'  => 'Available Throughout Georgia',
        ],
        [
            'key'          => 'field_contact_map_embed_url',
            'label'        => 'Google Maps Embed URL',
            'name'         => 'contact_map_embed_url',
            'type'         => 'url',
            'instructions' => 'Paste the Google Maps embed URL here. Leave blank for online-only practices (a decorative image will show instead).',
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 14: FAQ Page Fields
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_faq_page',
    'menu_order' => 0,
    'title'    => 'TPA FAQ Page',
    'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-faq.php' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'           => 'field_faq_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a hero image to replace the current one. Recommended: 1400px wide. Leave blank to use the default.',
        ],
        [
            'key'          => 'field_faq_intro',
            'label'        => 'FAQ Intro Text',
            'name'         => 'faq_intro',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Short paragraph shown above the FAQ list. Leave blank to hide.',
        ],
        [
            'key'          => 'field_faq_items',
            'label'        => 'FAQ Items',
            'name'         => 'faq_items',
            'type'         => 'repeater',
            'instructions' => 'Each row is one question + answer. Drag to reorder. Leave category blank for flat list.',
            'layout'       => 'block',
            'button_label' => 'Add Question',
            'sub_fields'   => [
                [
                    'key'          => 'field_faq_category',
                    'label'        => 'Category',
                    'name'         => 'category',
                    'type'         => 'text',
                    'instructions' => 'Optional. If set, questions group under category headings.',
                ],
                [
                    'key'   => 'field_faq_question',
                    'label' => 'Question',
                    'name'  => 'question',
                    'type'  => 'text',
                ],
                [
                    'key'     => 'field_faq_answer',
                    'label'   => 'Answer',
                    'name'    => 'answer',
                    'type'    => 'wysiwyg',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ],
            ],
        ],
    ],
] );

// ════════════════════════════════════════════════
// GROUP 15: Helpful Resources Page Fields
// ════════════════════════════════════════════════
acf_add_local_field_group( [
    'key'      => 'group_tpa_resources_page',
    'menu_order' => 0,
    'title'    => 'TPA Helpful Resources Page',
    'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'page-helpful-resources.php' ] ] ],
    'position' => 'acf_after_title',
    'fields'   => [
        [
            'key'           => 'field_resources_hero_image',
            'label'         => 'Hero Image',
            'name'          => 'hero_image',
            'type'          => 'image',
            'return_format' => 'url',
            'preview_size'  => 'medium',
            'instructions'  => 'Upload a hero image to replace the current one. Recommended: 1400px wide. Leave blank to use the default.',
        ],
        [
            'key'          => 'field_resources_intro_lead',
            'label'        => 'Intro Lead (short headline)',
            'name'         => 'resources_intro_lead',
            'type'         => 'text',
            'placeholder'  => 'Support beyond the therapy room.',
        ],
        [
            'key'          => 'field_resources_intro_body',
            'label'        => 'Intro Paragraph',
            'name'         => 'resources_intro_body',
            'type'         => 'textarea',
            'rows'         => 3,
        ],
        [
            'key'          => 'field_resources_items',
            'label'        => 'Resource Items',
            'name'         => 'resources_items',
            'type'         => 'repeater',
            'instructions' => 'One row per resource (hotlines, organizations, services).',
            'layout'       => 'block',
            'button_label' => 'Add Resource',
            'sub_fields'   => [
                [
                    'key'   => 'field_resources_item_title',
                    'label' => 'Title',
                    'name'  => 'title',
                    'type'  => 'text',
                ],
                [
                    'key'     => 'field_resources_item_body',
                    'label'   => 'Description',
                    'name'    => 'body',
                    'type'    => 'wysiwyg',
                    'toolbar' => 'basic',
                    'media_upload' => 0,
                ],
            ],
        ],
        [
            'key'          => 'field_resources_emergency_text',
            'label'        => 'Emergency Callout Text',
            'name'         => 'resources_emergency_text',
            'type'         => 'textarea',
            'rows'         => 2,
            'instructions' => 'Shown in the red warning band below the resources list.',
            'placeholder'  => 'If you are experiencing a mental health emergency, please call 988 or go to your nearest emergency department.',
        ],
    ],
] );
