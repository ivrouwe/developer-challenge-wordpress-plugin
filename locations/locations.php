<?php

class Locations {
	public function add_locations_meta_box() {
		add_meta_box(
			_x('location', 'meta box ID value', 'developer-challenge-wordpress-plugin'),
			__('Specify The Location\'s Coordinates/Zoom Level', 'developer-challenge-wordpress-plugin'),
			array($this, 'locations_meta_box_html'),
			_x('locations', 'post type slug', 'developer-challenge-wordpress-plugin')
		);
	}

	public function initialize_plugin() {
		if(!post_type_exists(__('locations', 'developer-challenge-wordpress-plugin'))) {
			// Register the Locations post type
			add_action('init', array($this, 'register_locations'));

			// Modify the "Enter title here" placeholder text
			add_filter('enter_title_here', function () {
				$screen = get_current_screen();

				if ($screen->post_type == _x('locations', 'post type slug', 'developer-challenge-wordpress-plugin')) {

					$title = _x('Enter Location name here', 'title placeholder text (on edit screen)', 'developer-challenge-wordpress-plugin');
				}

				return $title;
			});

			// Add custom fields
			add_action('add_meta_boxes', array($this, 'add_locations_meta_box'));

			// Sanitize and save the custom field values when a Location is added/updated
			add_action('save_post_locations', array($this, 'update_location'), 100, 1);
		} else {
			return;
		}
	}

	public function locations_meta_box_html() {
		global $post;

		$lat = get_post_meta($post->ID, 'locationLat', true);
		$lng = get_post_meta($post->ID, 'locationLng', true);
		$zoom = get_post_meta($post->ID, 'locationZoom', true);

		ob_start(); ?>

		<div id="location-meta">
			<?php wp_nonce_field('specify-location', 'location-altitude'); ?>

			<label for="location-meta-lat"><?php _e('Latitude', 'developer-challenge-wordpress-plugin'); ?></label>
			<input type="number" step="0.000001" min="-90.000000" max="90.000000" name="locationLat" id="location-meta-lat" value="<?php echo esc_attr($lat); ?>" required>
			<label for="location-meta-lng"><?php _e('Longitude', 'developer-challenge-wordpress-plugin'); ?></label>
			<input type="number" step="0.000001" min="-180.000000" max="180.000000" name="locationLng" id="location-meta-lng" value="<?php echo esc_attr($lng); ?>" required>
			<label for="location-meta-zoom"><?php _e('Zoom', 'developer-challenge-wordpress-plugin'); ?></label>
			<input type="number" name="locationZoom" id="location-meta-zoom" value="<?php echo esc_attr($zoom); ?>" required>
		</div>
	<?php }

	public function register_locations() {
		$labels = array(
			'name' => _x('Locations', 'post type general name', 'developer-challenge-wordpress-plugin'),
			'singular_name' => _x('Location', 'post type singular name', 'developer-challenge-wordpress-plugin'),
			'menu_name' => _x('Locations', 'admin menu', 'developer-challenge-wordpress-plugin'),
			'name_admin_bar' => _x('Location', 'add new on admin bar', 'developer-challenge-wordpress-plugin'),
			'add_new' => _x('Add New', 'Location', 'developer-challenge-wordpress-plugin'),
			'add_new_item' => __('Add New Location', 'developer-challenge-wordpress-plugin'),
			'new_item' => __('New Location', 'developer-challenge-wordpress-plugin'),
			'edit_item' => __('Edit Location', 'developer-challenge-wordpress-plugin'),
			'view_item' => __('View Location', 'developer-challenge-wordpress-plugin'),
			'all_items' => __('All Locations', 'developer-challenge-wordpress-plugin'),
			'search_items' => __('Search Locations', 'developer-challenge-wordpress-plugin'),
			'parent_item_colon' => __('Parent Locations:', 'developer-challenge-wordpress-plugin'),
			'not_found' => __('No locations found.', 'developer-challenge-wordpress-plugin'),
			'not_found_in_trash' => __('No locations found in Trash.', 'developer-challenge-wordpress-plugin')
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'supports' => array('title'),
		);

		register_post_type('locations', $args);
	}

	public function update_location() {
		global $post;

		if (!empty($_POST) && check_admin_referer('specify-location', 'location-altitude')) {
			$floats = array(
				'locationLat' => $_POST['locationLat'],
				'locationLng' => $_POST['locationLng'],
			);

			$ints = array(
				'locationZoom' => $_POST['locationZoom'],
			);

			foreach($floats as $key => $value) {
				if(filter_var($value, FILTER_VALIDATE_FLOAT) !== '') {
					update_post_meta($post->ID, $key, filter_var($value, FILTER_VALIDATE_FLOAT));
				}
			}

			foreach($ints as $key => $value) {
				if(filter_var($value, FILTER_VALIDATE_INT) !== '') {
					update_post_meta($post->ID, $key, filter_var($value, FILTER_VALIDATE_INT));
				}
			}
		}
	}
}