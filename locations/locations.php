<?php

class Locations {
	public function register_locations() {
		$locationsArgs = array(
			'labels' => array(
				'name' => __('Locations'),
				'singular_name' => __('Location'),
			),
			'public' => true,
			'has_archive' => false,
			'supports' => array('title'),
		);

		register_post_type('locations', $locationsArgs);
	}

	public function locations_map_html() {
		ob_start(); ?>

		<div id="map"></div>
	<?php }

	public function add_locations_meta_boxes() {
		add_meta_box(
			'locations_map',
			'Choose The Location',
			array($this, 'locations_map_html'),
			'locations'
		);
	}

	public function __construct() {
		if(!post_type_exists('locations')) {
			add_action('init', array($this, 'register_locations'));
			add_action('add_meta_boxes', array($this, 'add_locations_meta_boxes'));
		} else {
			return;
		}
	}
}