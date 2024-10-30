<?php

function meteomatics_load_plugin_scripts_styles($hook) {
	$plugin_url = plugin_dir_url( __FILE__ );

	wp_enqueue_style( 'meteomatics_styles', $plugin_url . '../assets/css/meteomatics_styles.css', [], '1.0.1');
	wp_enqueue_script( 'meteomatics_scripts', $plugin_url . '../assets/js/meteomatics_scripts.js', array('jquery'), '1.0.1', ['strategy' => 'async', 'in_footer' => true] );

	wp_enqueue_style('meteomatics_widget_styles', 'https://widget.meteomatics.com/v2/meteomatics-weather-widget.css', [], '1.0.1');
	wp_enqueue_script('meteomatics_widget_scripts', 'https://widget.meteomatics.com/v2/meteomatics-weather-widget.js', [], '1.0.1', ['strategy' => 'async', 'in_footer' => true]);

	$meteomatics_variables = array(
		'DEFAULT_COLOR' => METEOMATICS_DEFAULT_COLOR,
		'DEFAULT_VARIANT' => METEOMATICS_DEFAULT_VARIANT,
		'DEFAULT_UNITS' => METEOMATICS_DEFAULT_UNITS,
	);
	wp_localize_script('meteomatics_scripts', 'php_vars', $meteomatics_variables);
}
add_action( 'admin_enqueue_scripts', 'meteomatics_load_plugin_scripts_styles' );


function meteomatics_load_client_scripts_styles() {
	wp_enqueue_style('meteomatics_widget_styles', 'https://widget.meteomatics.com/v2/meteomatics-weather-widget.css', [], '1.0.1');
	wp_enqueue_script('meteomatics_widget_scripts', 'https://widget.meteomatics.com/v2/meteomatics-weather-widget.js', [], '1.0.1', ['strategy' => 'async', 'in_footer' => true]);
}
add_action( 'wp_enqueue_scripts', 'meteomatics_load_client_scripts_styles');
