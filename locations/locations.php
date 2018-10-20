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
		);

		register_post_type('locations', $locationsArgs);
	}

	public function __construct() {
		if(!post_type_exists('locations')) {
			add_action('init', array($this, 'register_locations'));
		} else {
			return;
		}
	}
}