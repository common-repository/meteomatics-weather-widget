<?php

function meteomatics_widget_custom_post_type() {
	$args = array(
		'public'                => false,
		'show_ui'               => true,
		'show_in_menu'          => 'meteomatics-settings',
		'label'                 => 'Widgets',
		'query_var'             => false,
		'rewrite'               => array('slug' => 'meteomatics_widget'),
		'supports'              => array('title', 'custom-fields', 'revisions'),
		'publicly_queryable'    => false,
        'exclude_from_search'   => true
	);
	register_post_type('meteomatics_widget', $args);
}
add_action('init', 'meteomatics_widget_custom_post_type');


function meteomatics_add_meta_boxes() {
	add_meta_box(
		'meteomatics_widget_info',
		__('Meteomatics Widget Info', 'meteomatics-weather-widget'),
		'meteomatics_render_widget_info_box',
		'meteomatics_widget',
		'normal',
		'high'
	);

	remove_meta_box('postcustom', 'meteomatics_widget', 'normal'); // custom fields
	remove_post_type_support('meteomatics_widget', 'editor'); // content editor
}
add_action('add_meta_boxes', 'meteomatics_add_meta_boxes');

function meteomatics_render_widget_info_box($post) {
	$post_id = $post->ID;

	wp_nonce_field(plugin_basename(__FILE__), 'meteomatics_nonce');

	$latitude = get_post_meta($post->ID, 'meteomatics_latitude', true) ?: METEOMATICS_DEFAULT_LATITUDE;
	$longitude = get_post_meta($post->ID, 'meteomatics_longitude', true) ?: METEOMATICS_DEFAULT_LONGITUDE;
	$location = get_post_meta($post->ID, 'meteomatics_location', true) ?: METEOMATICS_DEFAULT_LOCATION;
	$color = get_post_meta($post->ID, 'meteomatics_color_select', true) ?: METEOMATICS_DEFAULT_COLOR;
	$variant = get_post_meta($post->ID, 'meteomatics_variant_select', true) ?: METEOMATICS_DEFAULT_VARIANT;
	$units = get_post_meta($post->ID, 'meteomatics_units_select', true) ?: METEOMATICS_DEFAULT_UNITS;

	?>


	<div class="meteomatics-widget-settings">
		<div class="meteomatics-widget-configurator">
			<h3><?php esc_html_e('Widget Configuration', 'meteomatics-weather-widget') ?></h3>

			<table class="form-table" role="presentation">
				<tbody>
				<tr>
					<th><label for="meteomatics_latitude"><?php esc_html_e("Latitude", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<input type='number' name='meteomatics_latitude' id="meteomatics_latitude" value='<?php echo esc_attr($latitude); ?>' min="-90" max="90" step="any">
                        <div class="meteomatics-input-helper"><?php esc_html_e('Min value -90, max value 90', 'meteomatics-weather-widget'); ?></div>
					</td>
				</tr>
				<tr>
					<th><label for="meteomatics_longitude"><?php esc_html_e("Longitude", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<input type='number' name='meteomatics_longitude' id="meteomatics_longitude" value='<?php echo esc_attr($longitude); ?>' min="-180" max="180" step="any">
                        <div class="meteomatics-input-helper"><?php esc_html_e('Min value -180, max value 180', 'meteomatics-weather-widget'); ?></div>
                        <div class="meteomatics-input-helper">
                            <a href="https://www.meteomatics.com/en/weather-widget/" target="_blank">
                                <?php esc_html_e('You can get latitude and longitude here' , 'meteomatics-weather-widget'); ?>
                            </a>
                        </div>
					</td>
				</tr>
				<tr>
					<th><label for="meteomatics_location"><?php esc_html_e("Location title", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<input type='text' name='meteomatics_location' id="meteomatics_location" value='<?php echo esc_attr($location); ?>'>
					</td>
				</tr>
				<tr>
					<th><label for="meteomatics_color_select"><?php esc_html_e("Color", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<select name='meteomatics_color_select' id="meteomatics_color_select">
							<option value='primary' <?php selected($color, 'primary'); ?>>Primary</option>
							<option value='black' <?php selected($color, 'black'); ?>>Black</option>
							<option value='white' <?php selected($color, 'white'); ?>>White</option>
							<option value='light-gray' <?php selected($color, 'light-gray'); ?>>Light Gray</option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="meteomatics_variant_select"><?php esc_html_e("Variant", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<select name='meteomatics_variant_select' id="meteomatics_variant_select">
							<option value='horizontal' <?php selected($variant, 'horizontal'); ?>>Horizontal</option>
							<option value='vertical' <?php selected($variant, 'vertical'); ?>>Vertical</option>
						</select>
					</td>
				</tr>
				<tr>
					<th><label for="meteomatics_units_select"><?php esc_html_e("Units", 'meteomatics-weather-widget'); ?></label></th>
					<td>
						<select name='meteomatics_units_select' id="meteomatics_units_select">
							<option value='celsius' <?php selected($units, 'celsius'); ?>>Celsius</option>
							<option value='fahrenheit' <?php selected($units, 'fahrenheit'); ?>>Fahrenheit</option>
						</select>
					</td>
				</tr>
				</tbody>
			</table>

            <div class="meteomatics-preview-errors"></div>

			<div class="meteomatics-widget-configurator-buttons">
				<span id="meteomatics-preview" class="meteomatics-button meteomatics-button-primary">
                    <?php esc_html_e("Preview", 'meteomatics-weather-widget'); ?>
                </span>
				<button type="submit" id="meteomatics-preview" class="meteomatics-button meteomatics-button-secondary">
                    <?php esc_html_e("Save", 'meteomatics-weather-widget'); ?>
                </button>
			</div>
		</div>
		<div class="meteomatics-widget-preview">
			<h3><?php esc_html_e('Widget Preview', 'meteomatics-weather-widget') ?></h3>
			<div>
				<div
					id="meteomatics-widget"
					data-meteomatics-weather-widget="<?php echo esc_attr($variant); ?>"
					data-meteomatics-weather-widget-color="<?php echo esc_attr($color); ?>"
					data-meteomatics-weather-widget-title="<?php echo esc_attr($location); ?>"
					data-meteomatics-weather-widget-latitude="<?php echo esc_attr($latitude); ?>"
					data-meteomatics-weather-widget-longitude="<?php echo esc_attr($longitude); ?>"
					data-meteomatics-weather-widget-measurement-unit-temperature="<?php echo esc_attr($units); ?>"
				>
					<a href="https://www.meteomatics.com"><?php esc_html_e("Meteomatics Weather Widget", 'meteomatics-weather-widget'); ?></a>
				</div>
			</div>

			<h4><?php esc_html_e('Shortcode', 'meteomatics-weather-widget') ?></h4>
			<div class="meteomatics-widget-shortcode">
				[MeteomaticsWeatherWidget id="<?php echo esc_html($post_id); ?>"]
			</div>

			<div class="meteomatics-widget-logo">
				<a href="https://www.meteomatics.com/" target="_blank">
					<img src="<?php echo esc_url(plugins_url( '../assets/img/logo.svg', __FILE__ )); ?>" alt="Meteomatics Logo">
				</a>
			</div>
		</div>
	</div>
	<?php
}

function meteomatics_widget_save_postdata($post_id) {
	// Check if our nonce is set.
	if (!isset($_POST['meteomatics_nonce'])) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! isset( $_POST['meteomatics_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['meteomatics_nonce'] ) ) , plugin_basename(__FILE__) ) ) {
		return;
	}



	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// Check the user's permissions.
	if (isset($_POST['post_type']) && 'meteomatics_widget' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return;
		}
	} else {
		if (!current_user_can('edit_post', $post_id)) {
			return;
		}
	}

	// Update the meta field in the database.
	update_post_meta($post_id, 'meteomatics_latitude', sanitize_text_field($_POST['meteomatics_latitude']));
	update_post_meta($post_id, 'meteomatics_longitude', sanitize_text_field($_POST['meteomatics_longitude']));
	update_post_meta($post_id, 'meteomatics_location', sanitize_text_field($_POST['meteomatics_location']));
	update_post_meta($post_id, 'meteomatics_color_select', sanitize_text_field($_POST['meteomatics_color_select']));
	update_post_meta($post_id, 'meteomatics_variant_select', sanitize_text_field($_POST['meteomatics_variant_select']));
	update_post_meta($post_id, 'meteomatics_units_select', sanitize_text_field($_POST['meteomatics_units_select']));
}
add_action('save_post', 'meteomatics_widget_save_postdata');