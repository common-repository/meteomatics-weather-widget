<?php

function meteomatics_add_admin_menu(  ) {
	add_menu_page(
		__('Meteomatics Weather Widget', 'meteomatics-weather-widget'),
		__('Meteomatics Weather Widget', 'meteomatics-weather-widget'),
		'manage_options',
		'meteomatics-settings',
		'meteomatics_options_page',
		'dashicons-cloud'
	);
}
add_action( 'admin_menu', 'meteomatics_add_admin_menu' );