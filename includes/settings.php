<?php

if ( ! defined( 'ABSPATH' ) ) exit;

// Changing default labels
function meteomatics_modify_post_type_labels() {
	global $wp_post_types;

	if (isset($wp_post_types['meteomatics_widget'])) {
		$wp_post_types['meteomatics_widget']->labels->add_new = __('Add widget', 'meteomatics-weather-widget');
		$wp_post_types['meteomatics_widget']->labels->add_new_item = __('Add widget', 'meteomatics-weather-widget');
		$wp_post_types['meteomatics_widget']->labels->edit_item = __('Edit', 'meteomatics-weather-widget');
		$wp_post_types['meteomatics_widget']->labels->new_item = __('Add widget', 'meteomatics-weather-widget');
		$wp_post_types['meteomatics_widget']->labels->view_item = __('View widget', 'meteomatics-weather-widget');
	}
}
add_action('init', 'meteomatics_modify_post_type_labels', 99);


// Add new column to the post table
add_filter('manage_meteomatics_widget_posts_columns', function ($columns) {
	$date = $columns['date'];
	unset($columns['date']);

	$columns['shortcode'] = __('Shortcode', 'meteomatics-weather-widget');

	// Attach 'date' column after 'shortcode'
	$columns['date'] = $date;
	return $columns;
});

// Output for the new column (in this case, the item's the shortcode)
add_action('manage_meteomatics_widget_posts_custom_column', function ($column_key, $post_id) {
	if ($column_key == 'shortcode') {
		echo '<div class="meteomatics-widget-code">[MeteomaticsWeatherWidget id="' . esc_html($post_id) . '"]</div>';
	}
}, 10, 2);

// Translations
add_action('plugins_loaded', 'meteomatics_load_textdomain');
function meteomatics_load_textdomain() {
	load_plugin_textdomain( 'meteomatics-weather-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
