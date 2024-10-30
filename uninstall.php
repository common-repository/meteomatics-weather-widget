<?php

// If uninstall not called from WordPress, then exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
	exit;
}

// Remove custom post type posts
$meteomatics_widgets = get_posts(array('post_type' => 'meteomatics_widget', 'numberposts' => -1));

foreach ($meteomatics_widgets as $meteomatics_widget) {
	wp_delete_post($meteomatics_widget->ID, true);
}

// remove metadata
delete_metadata('post', null, 'meteomatics_latitude', null, true);
delete_metadata('post', null, 'meteomatics_longitude', null, true);
delete_metadata('post', null, 'meteomatics_location', null, true);
delete_metadata('post', null, 'meteomatics_color_select', null, true);
delete_metadata('post', null, 'meteomatics_variant_select', null, true);
delete_metadata('post', null, 'meteomatics_units_select', null, true);
