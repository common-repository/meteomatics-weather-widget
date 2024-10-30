<?php
/**
 * Plugin Name:     Meteomatics Weather Widget
 * Plugin URI:      https://www.meteomatics.com/en/weather-widget/
 * Description:     The most accurate weather forecast widget for WordPress, powered by the Meteomatics Weather API.
 * Version:         1.0.1
 * Author:          Meteomatics
 * Author URI:      https://www.meteomatics.com/
 * License:         GPL-2.0+
 * License URI:     http://www.opensource.org/licenses/GPL-2.0
 * Text Domain:     meteomatics-weather-widget
 * Domain Path:     /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

define('METEOMATICS_DEFAULT_LOCATION', 'St. Gallen');
define('METEOMATICS_DEFAULT_LATITUDE', 47.4250593);
define('METEOMATICS_DEFAULT_LONGITUDE', 9.3765878);
define('METEOMATICS_DEFAULT_COLOR', 'primary');
define('METEOMATICS_DEFAULT_VARIANT', 'vertical');
define('METEOMATICS_DEFAULT_UNITS', 'celsius');

// Register menu
include plugin_dir_path( __FILE__ ) . 'includes/menu.php';

// Styles and scripts
include plugin_dir_path( __FILE__ ) . 'includes/enqueue_styles_scripts.php';

// Register CPT and metabox
include plugin_dir_path( __FILE__ ) . 'includes/meteomatics_post_type.php';

// Shortcode for the widget
include plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

// Settings and view
include plugin_dir_path( __FILE__ ) . 'includes/settings.php';