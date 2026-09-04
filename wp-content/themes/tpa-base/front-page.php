<?php
/**
 * Homepage template.
 * Reads sections.json from the child theme and assembles template parts.
 */
get_header();
tpa_render_homepage_sections();
get_footer();
