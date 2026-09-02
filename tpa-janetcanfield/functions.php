<?php
/**
 * TPA - Wise Counsel (Janet Canfield) child theme.
 */

// The parent LP ACF field groups target page_template == page-landing.php.
// The bespoke brand-adapted LP uses page-landing-nest.php, so make those rules
// also match it — keeps every lp_* field editable in wp-admin on the new template.
add_filter('acf/location/rule_match/page_template', function ($result, $rule, $screen) {
    if (($rule['value'] ?? '') === 'page-landing.php'
        && ($screen['page_template'] ?? '') === 'page-landing-nest.php'
        && ($rule['operator'] ?? '==') === '==') {
        return true;
    }
    return $result;
}, 10, 3);

function tpa_janetcanfield_enqueue() {
    // Dequeue parent theme CSS
    wp_dequeue_style('tpa-base-css');
    wp_dequeue_style('tpa-nav-css');
    wp_dequeue_style('tpa-animations-css');
    wp_dequeue_style('tpa-responsive-css');
    wp_dequeue_style('tpa-forms-css');

    // Dequeue parent JS
    wp_dequeue_script('tpa-scroll-animations');
    wp_dequeue_script('tpa-parallax');
    wp_dequeue_script('tpa-nav');

    // Landing pages own their CSS/JS — bail before enqueuing client assets.
    if ( is_page_template('page-landing.php') || is_page_template('page-landing-nest.php') ) {
        return;
    }

    $child_dir = get_stylesheet_directory();
    $child_uri = get_stylesheet_directory_uri();

    // Inline critical above-fold CSS (handle ends in -client so
    // perf-optimizations.php inlines it).
    wp_enqueue_style(
        'tpa-janetcanfield-client',
        $child_uri . '/assets/css/client-critical.css',
        [],
        filemtime($child_dir . '/assets/css/client-critical.css')
    );

    // Enqueue client JS with defer
    wp_enqueue_script(
        'tpa-janetcanfield-client-js',
        $child_uri . '/assets/js/client.js',
        [],
        filemtime($child_dir . '/assets/js/client.js'),
        ['in_footer' => true, 'strategy' => 'defer']
    );
}
add_action('wp_enqueue_scripts', 'tpa_janetcanfield_enqueue', 20);

// Defer the full (below-fold) client.css with high-priority preload.
add_action('wp_head', function() {
    if (is_page_template('page-landing.php') || is_page_template('page-landing-nest.php')) return;
    $child_uri = get_stylesheet_directory_uri();
    $child_dir = get_stylesheet_directory();
    $full = $child_dir . '/assets/css/client.css';
    if (!file_exists($full)) return;
    $ver = filemtime($full);
    $url = esc_url($child_uri . '/assets/css/client.css?ver=' . $ver);
    echo '<link rel="preload" as="style" href="' . $url . '" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
    echo '<noscript><link rel="stylesheet" href="' . $url . '"></noscript>' . "\n";
}, 20);

// Remove WordPress emoji scripts/styles
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove wp-embed script
function tpa_janetcanfield_deregister_embed() {
    wp_deregister_script('wp-embed');
}
add_action('wp_footer', 'tpa_janetcanfield_deregister_embed');

// Remove jQuery migrate on frontend
function tpa_janetcanfield_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'tpa_janetcanfield_remove_jquery_migrate');

// Disable global styles/SVGs (block editor CSS not needed on frontend)
function tpa_janetcanfield_remove_global_styles() {
    wp_dequeue_style('global-styles');
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'tpa_janetcanfield_remove_global_styles', 100);

// Dequeue dashicons for logged-out visitors
add_action('wp_enqueue_scripts', function() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}, 100);

// Dequeue Essential Blocks frontend assets
add_action('wp_enqueue_scripts', function() {
    global $wp_scripts, $wp_styles;
    foreach ( array_keys( $wp_scripts->registered ?? [] ) as $h ) {
        if ( strpos( $h, 'essential-blocks' ) !== false || strpos( $h, 'eb-blocks' ) !== false ) {
            wp_dequeue_script( $h );
            wp_deregister_script( $h );
        }
    }
    foreach ( array_keys( $wp_styles->registered ?? [] ) as $h ) {
        if ( strpos( $h, 'essential-blocks' ) !== false || strpos( $h, 'eb-blocks' ) !== false ) {
            wp_dequeue_style( $h );
            wp_deregister_style( $h );
        }
    }
}, 100);

/**
 * Turn bare phone numbers (client prefers TEXT -> sms:) and email addresses in
 * rendered content into obvious links. Existing <a>…</a> are left untouched.
 */
function tpa_linkify($html) {
    if (!$html) return $html;
    $pattern = '#(<a\b[^>]*>.*?</a>)|(\(\d{3}\)\s*\d{3}[.\-\s]?\d{4})|([a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,})#is';
    return preg_replace_callback($pattern, function ($m) {
        if (!empty($m[1])) return $m[1];                    // existing anchor — leave alone
        if (!empty($m[2])) {                                 // phone -> sms
            $d = preg_replace('/\D/', '', $m[2]);
            return '<a href="sms:' . $d . '">' . $m[2] . '</a>';
        }
        if (!empty($m[3])) return '<a href="mailto:' . $m[3] . '">' . $m[3] . '</a>'; // email
        return $m[0];
    }, $html);
}

/**
 * Block-aware paragraph wrapping for post_content rendered with wpautop
 * disabled. page.php / page-service.php / page-contact.php / page-faq.php all
 * skip wpautop to stop it from wrapping the bare <img> inside .svc-img-section
 * grids in a <p> (which breaks the grid). But skipping wpautop entirely also
 * removes the only thing that turns blank-line-separated plain text into <p>
 * tags — so any edit made via a plain-text metabox, or pasted from Word/Docs,
 * silently loses its paragraph spacing.
 *
 * This wraps loose text lines in <p>, but leaves lines that are already
 * block-level markup untouched. Consecutive bare lines with no blank line
 * between them (e.g. a hand-typed address — "Wise Counsel" / street / city,
 * state zip / country, one per line, no <br>) are grouped into a single <p>
 * joined by <br>, matching what core wpautop() would have produced — rather
 * than each line becoming its own separate paragraph. It also tracks
 * open/close state for an explicit <p> that itself spans multiple raw lines,
 * so continuation lines inside it aren't re-wrapped.
 */
function tpa_janetcanfield_safe_autop( $content ) {
    static $block_tags = [
        'div', 'section', 'article', 'aside', 'figure', 'blockquote', 'table',
        'thead', 'tbody', 'tr', 'td', 'th',
        'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
        'ul', 'ol', 'li', 'p', 'img',
    ];

    $lines  = preg_split( '/\r\n|\r|\n/', $content );
    $out    = [];
    $in_p   = false;
    $buffer = [];

    $flush = function () use ( &$buffer, &$out ) {
        if ( $buffer ) {
            $out[]  = '<p>' . implode( '<br>', $buffer ) . '</p>';
            $buffer = [];
        }
    };

    foreach ( $lines as $line ) {
        $trimmed = trim( $line );
        if ( $trimmed === '' ) {
            $flush();
            continue;
        }

        if ( $in_p ) {
            $out[] = $trimmed;
            if ( stripos( $trimmed, '</p>' ) !== false ) {
                $in_p = false;
            }
            continue;
        }

        $is_block = false;
        foreach ( $block_tags as $tag ) {
            if ( preg_match( '/^<\/?' . $tag . '(\s|>|$)/i', $trimmed ) ) {
                $is_block = true;
                break;
            }
        }

        if ( $is_block ) {
            $flush();
            $out[] = $trimmed;
            if ( preg_match( '/^<p(\s|>)/i', $trimmed ) && stripos( $trimmed, '</p>' ) === false ) {
                $in_p = true;
            }
            continue;
        }

        $buffer[] = $trimmed;
    }
    $flush();

    return implode( "\n", $out );
}

/**
 * Shared render helper for post_content on templates that disable wpautop.
 * Runs {{IMG_BASE}} substitution + tpa_janetcanfield_safe_autop() before
 * handing off to the normal 'the_content' filter chain (do_blocks,
 * wptexturize, shortcodes — everything except wpautop, which stays disabled
 * since safe_autop already produced real <p> tags).
 */
/**
 * Inner-page hero background as a <picture> so WebP-capable browsers get the
 * .webp sibling (the bare <img> was serving JPG to everyone — 30-57% heavier on
 * most inner pages). Intrinsic width/height are read from the file rather than
 * hardcoded: the heroes are variously 1700x525, 2040x525 and 1400x955, but every
 * template declared 1400x1028.
 */
function tpa_janetcanfield_hero_picture( $file ) {
    $dir   = get_stylesheet_directory() . '/assets/images/';
    $attrs = [
        'class'         => 'inner-hero-bg inner-page-hero-bg',
        'fetchpriority' => 'high',
        'loading'       => 'eager',
        'decoding'      => 'async',
    ];
    if ( file_exists( $dir . $file ) ) {
        $size = @getimagesize( $dir . $file );
        if ( $size ) {
            $attrs['width']  = $size[0];
            $attrs['height'] = $size[1];
        }
    }
    tpa_picture( $file, '', $attrs );
}

/**
 * Photo whose URL may come from ACF. If it resolves to a file in the child
 * theme's images dir we can route it through tpa_picture() for the WebP
 * sibling; a Media Library upload has no sibling, so it stays a plain <img>.
 */
function tpa_janetcanfield_photo( $url, $alt = '', $attrs = [] ) {
    $img_uri = get_stylesheet_directory_uri() . '/assets/images/';
    if ( $url && strpos( $url, $img_uri ) === 0 ) {
        tpa_picture( basename( parse_url( $url, PHP_URL_PATH ) ), $alt, $attrs );
        return;
    }
    $attr_str = '';
    foreach ( $attrs as $k => $v ) {
        $attr_str .= ' ' . $k . '="' . esc_attr( $v ) . '"';
    }
    echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '"' . $attr_str . '>';
}

function tpa_janetcanfield_render_body( $post_id ) {
    $child_img = get_stylesheet_directory_uri() . '/assets/images/';
    $raw       = get_post_field( 'post_content', $post_id );
    $replaced  = str_replace( '{{IMG_BASE}}', esc_url( $child_img ), $raw );
    $safe      = tpa_janetcanfield_safe_autop( $replaced );

    remove_filter( 'the_content', 'wpautop' );
    $content = apply_filters( 'the_content', $safe );
    add_filter( 'the_content', 'wpautop' );

    return $content;
}

// ── ACF field groups ───────────────────────────────────────────────────────
add_action('acf/init', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    acf_add_local_field_group([
        'key'   => 'group_janetcanfield_homepage',
        'title' => 'Homepage Content',
        'fields' => [
            // Hero
            ['key'=>'field_jc_hero_tab','label'=>'Hero','name'=>'','type'=>'tab','menu_order'=>10],
            ['key'=>'field_jc_hero_h1_1','label'=>'Headline line 1','name'=>'hero_headline_1','type'=>'text','menu_order'=>11],
            ['key'=>'field_jc_hero_h1_2','label'=>'Headline line 2','name'=>'hero_headline_2','type'=>'text','menu_order'=>12],
            ['key'=>'field_jc_hero_kicker','label'=>'Kicker band','name'=>'hero_kicker','type'=>'text','menu_order'=>13],
            ['key'=>'field_jc_hero_tagline','label'=>'Tagline (HTML allowed: <em>, <br>)','name'=>'hero_tagline','type'=>'textarea','rows'=>3,'new_lines'=>'','menu_order'=>14],
            ['key'=>'field_jc_hero_cta_t','label'=>'Button text','name'=>'hero_cta_text','type'=>'text','menu_order'=>15],
            ['key'=>'field_jc_hero_cta_u','label'=>'Button URL','name'=>'hero_cta_url','type'=>'text','menu_order'=>16],
            // Services
            ['key'=>'field_jc_svc_tab','label'=>'Services','name'=>'','type'=>'tab','menu_order'=>20],
            ['key'=>'field_jc_svc_head','label'=>'Services heading','name'=>'services_heading','type'=>'text','menu_order'=>21],
            // Vignettes
            ['key'=>'field_jc_vig_tab','label'=>'Vignettes','name'=>'','type'=>'tab','menu_order'=>30],
            ['key'=>'field_jc_vignettes','label'=>'Vignettes (4: Hiding, Fog, Storm, Distress)','name'=>'vignettes','type'=>'repeater','layout'=>'block','button_label'=>'Add Vignette','min'=>1,'max'=>4,'menu_order'=>31,'sub_fields'=>[
                ['key'=>'field_jc_vig_heading','label'=>'Heading','name'=>'heading','type'=>'text'],
                ['key'=>'field_jc_vig_body','label'=>'Body','name'=>'body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0],
                ['key'=>'field_jc_vig_refrain','label'=>'Refrain chip','name'=>'refrain','type'=>'text'],
            ]],
            // Bridge
            ['key'=>'field_jc_bridge_tab','label'=>'Bridge','name'=>'','type'=>'tab','menu_order'=>40],
            ['key'=>'field_jc_bridge_head','label'=>'Bridge heading','name'=>'bridge_heading','type'=>'text','menu_order'=>41],
            ['key'=>'field_jc_bridge_body','label'=>'Bridge body','name'=>'bridge_body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>42],
            // Text band
            ['key'=>'field_jc_band_tab','label'=>'Text Band','name'=>'','type'=>'tab','menu_order'=>50],
            ['key'=>'field_jc_band_text','label'=>'Band text','name'=>'band_text','type'=>'text','menu_order'=>51],
            ['key'=>'field_jc_band_btn','label'=>'Band button text','name'=>'band_button_text','type'=>'text','menu_order'=>52],
            // Bio
            ['key'=>'field_jc_bio_tab','label'=>'Bio','name'=>'','type'=>'tab','menu_order'=>60],
            ['key'=>'field_jc_bio_head','label'=>'Bio heading','name'=>'bio_heading','type'=>'text','menu_order'=>61],
            ['key'=>'field_jc_bio_lead','label'=>'Bio lead','name'=>'bio_lead','type'=>'text','menu_order'=>62],
            ['key'=>'field_jc_bio_body','label'=>'Bio body','name'=>'bio_body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>63],
            ['key'=>'field_jc_bio_pull','label'=>'Bio pull-quote','name'=>'bio_pull','type'=>'textarea','rows'=>3,'new_lines'=>'','menu_order'=>64],
            ['key'=>'field_jc_bio_cta_t','label'=>'Bio button text','name'=>'bio_cta_text','type'=>'text','menu_order'=>65],
            ['key'=>'field_jc_bio_cta_u','label'=>'Bio button URL','name'=>'bio_cta_url','type'=>'text','menu_order'=>66],
            ['key'=>'field_jc_bio_img','label'=>'Headshot','name'=>'bio_image','type'=>'image','return_format'=>'url','preview_size'=>'medium','menu_order'=>67],
            // Final CTA
            ['key'=>'field_jc_fcta_tab','label'=>'Final CTA','name'=>'','type'=>'tab','menu_order'=>70],
            ['key'=>'field_jc_fcta_head','label'=>'Headline','name'=>'final_cta_headline','type'=>'text','menu_order'=>71],
            ['key'=>'field_jc_fcta_body','label'=>'Body','name'=>'final_cta_body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>72],
            ['key'=>'field_jc_fcta_fkick','label'=>'Form kicker','name'=>'final_cta_form_kicker','type'=>'text','menu_order'=>73],
            ['key'=>'field_jc_fcta_fttl','label'=>'Form title','name'=>'final_cta_form_title','type'=>'text','menu_order'=>74],
            ['key'=>'field_jc_fcta_fnote','label'=>'Form note','name'=>'final_cta_form_note','type'=>'text','menu_order'=>75],
        ],
        'location' => [[['param'=>'page_type','operator'=>'==','value'=>'front_page']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);

    acf_add_local_field_group([
        'key'   => 'group_janetcanfield_about',
        'title' => 'About Page Content',
        'fields' => [
            ['key'=>'field_jc_ab_journey_tab','label'=>'Journey','name'=>'','type'=>'tab','menu_order'=>10],
            ['key'=>'field_jc_journey','label'=>'Journey Steps (the therapy arc)','name'=>'journey_steps','type'=>'repeater','layout'=>'block','button_label'=>'Add Step','menu_order'=>11,'sub_fields'=>[
                ['key'=>'field_jc_js_title','label'=>'Step Title','name'=>'title','type'=>'text','required'=>1],
                ['key'=>'field_jc_js_body','label'=>'Step Body','name'=>'body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0],
            ]],
            ['key'=>'field_jc_ab_bio_tab','label'=>'About Janet','name'=>'','type'=>'tab','menu_order'=>20],
            ['key'=>'field_jc_ab_bio_head','label'=>'Heading','name'=>'about_bio_heading','type'=>'text','menu_order'=>21],
            ['key'=>'field_jc_ab_bio_lead','label'=>'Lead line','name'=>'about_bio_lead','type'=>'text','menu_order'=>22],
            ['key'=>'field_jc_ab_bio','label'=>'Bio Body','name'=>'about_bio','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>23],
            ['key'=>'field_jc_ab_bio_img','label'=>'Headshot','name'=>'about_bio_image','type'=>'image','return_format'=>'url','preview_size'=>'medium','menu_order'=>24],
            ['key'=>'field_jc_ab_cta_tab','label'=>'Closing CTA','name'=>'','type'=>'tab','menu_order'=>30],
            ['key'=>'field_jc_ab_cta_head','label'=>'CTA Heading','name'=>'about_cta_heading','type'=>'text','menu_order'=>31],
            ['key'=>'field_jc_ab_cta_body','label'=>'CTA Body','name'=>'about_cta_body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>32],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-about.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);

    acf_add_local_field_group([
        'key'   => 'group_janetcanfield_faq',
        'title' => 'FAQ Content',
        'fields' => [
            ['key'=>'field_jc_faq_groups','label'=>'FAQ Categories','name'=>'faq_groups','type'=>'repeater','layout'=>'block','button_label'=>'Add Category','menu_order'=>10,'sub_fields'=>[
                ['key'=>'field_jc_faq_cat','label'=>'Category (optional)','name'=>'category','type'=>'text'],
                ['key'=>'field_jc_faq_items','label'=>'Questions','name'=>'items','type'=>'repeater','layout'=>'block','button_label'=>'Add Question','sub_fields'=>[
                    ['key'=>'field_jc_faq_q','label'=>'Question','name'=>'question','type'=>'text','required'=>1],
                    ['key'=>'field_jc_faq_a','label'=>'Answer','name'=>'answer','type'=>'textarea','rows'=>4,'new_lines'=>'wpautop'],
                ]],
            ]],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-faq.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);

    // Janet practices from two offices; the base theme's single Office Address
    // field can't express that, so the footer runs off this repeater instead.
    acf_add_local_field_group([
        'key'   => 'group_janetcanfield_footer_locations',
        'title' => 'Footer Office Locations',
        'fields' => [
            ['key'=>'field_jc_footer_locs','label'=>'Office Locations','name'=>'footer_locations','type'=>'repeater','layout'=>'table','button_label'=>'Add Location','menu_order'=>10,'sub_fields'=>[
                ['key'=>'field_jc_floc_street','label'=>'Street','name'=>'street','type'=>'text'],
                ['key'=>'field_jc_floc_city','label'=>'City, State','name'=>'city','type'=>'text'],
            ]],
        ],
        'location' => [[['param'=>'options_page','operator'=>'==','value'=>'tpa-settings']]],
        'menu_order'=>2,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);

    acf_add_local_field_group([
        'key'   => 'group_janetcanfield_contact',
        'title' => 'Contact Page Content',
        'fields' => [
            ['key'=>'field_jc_ct_info_head','label'=>'Contact Column Heading','name'=>'contact_info_heading','type'=>'text','menu_order'=>10],
            ['key'=>'field_jc_ct_info_body','label'=>'Contact Column Body','name'=>'contact_info_body','type'=>'wysiwyg','tabs'=>'visual','media_upload'=>0,'menu_order'=>11],
            ['key'=>'field_jc_ct_form_head','label'=>'Form Heading','name'=>'contact_form_heading','type'=>'text','menu_order'=>20],
        ],
        'location' => [[['param'=>'page_template','operator'=>'==','value'=>'page-contact.php']]],
        'menu_order'=>0,'position'=>'normal','style'=>'default','label_placement'=>'top',
    ]);
});
