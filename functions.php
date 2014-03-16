<?php

/****************************************
Theme Setup
*****************************************/
require get_template_directory() . '/lib/theme-functions.php';
require get_template_directory() . '/lib/inc/template-tags.php';
require get_template_directory() . '/lib/inc/extras.php';
require get_template_directory() . '/lib/inc/jetpack.php';
require get_template_directory() . '/lib/inc/shortcodes.php';
require get_template_directory() . '/lib/inc/walkers.php';

/**
 * Filter Yoast SEO Metabox Priority
 */
add_filter( 'wpseo_metabox_prio', 'foundation_s_filter_yoast_seo_metabox' );
function foundation_s_filter_yoast_seo_metabox() {
	return 'low';
}