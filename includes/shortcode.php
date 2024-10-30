<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function meteomatics_weather_widget_shortcode($atts) {
	$atts = shortcode_atts(
		array(
			'id'     => '',
		),
		$atts,
		'MeteomaticsWeatherWidget'
	);

	if (empty($atts['id'])) {
		return '<p class="meteomatics-error">' . __('No widget ID was passed', 'meteomatics-weather-widget') . '</p>';
	}

	$location  = get_post_meta($atts['id'], 'meteomatics_location', true);
	$latitude  = get_post_meta($atts['id'], 'meteomatics_latitude', true);
	$longitude = get_post_meta($atts['id'], 'meteomatics_longitude', true);
	$variant   = get_post_meta($atts['id'], 'meteomatics_variant_select', true);
	$color     = get_post_meta($atts['id'], 'meteomatics_color_select', true);
	$units     = get_post_meta($atts['id'], 'meteomatics_units_select', true);

	ob_start();

	echo '<div
            class="meteomatics-widget"
            data-meteomatics-weather-widget="' . esc_attr($variant) . '"
            data-meteomatics-weather-widget-color="' . esc_attr($color) . '"
            data-meteomatics-weather-widget-title="' . esc_attr($location) . '"
            data-meteomatics-weather-widget-latitude="' . esc_attr($latitude) . '"
            data-meteomatics-weather-widget-longitude="' . esc_attr($longitude) . '"
            data-meteomatics-weather-widget-measurement-unit-temperature="' . esc_attr($units) . '"
          >
            <a href="https://www.meteomatics.com">Meteomatics Weather Widget</a>
          </div>';

	return ob_get_clean();
}
add_shortcode('MeteomaticsWeatherWidget', 'meteomatics_weather_widget_shortcode');