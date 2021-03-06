<?php

/*
Plugin Name:  Developer Challenge - WordPress Plugin
Plugin URI:   https://github.com/ivrouwe/developer-challenge-wordpress-plugin
Description:  A WordPress plugin for saving, editing, and outputting Google Maps locations
Version:      1.0
Author:       Ivan Vrouwe
Author URI:   https://github.com/ivrouwe/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  developer-challenge-wordpress-plugin
Domain Path:  /languages
*/

require_once('locations/locations.php');

$locations = new Locations();
$locations->initialize_plugin();