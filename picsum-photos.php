<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              empty
 * @since             1.0.0
 * @package           Picsum_Photos
 *
 * @wordpress-plugin
 * Plugin Name:       PicsumPhotos
 * Plugin URI:        empty
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Kamil Jasiński
 * Author URI:        empty
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       picsum-photos
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PICSUM_PHOTOS_VERSION', '1.0.0' );

/**
 */
define( 'PICSUM_PHOTOS_CUSTOM_POST_TYPE', 'picsum_photos' );

/**
 */
define( 'PICSUM_PHOTOS_API_URL', 'https://picsum.photos/v2/list' );

/**
 */
define( 'PICSUM_PHOTOS_PLUGIN_NAME', 'picsum-photos' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-picsum-photos-activator.php
 */
function activate_picsum_photos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-picsum-photos-activator.php';
	Picsum_Photos_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-picsum-photos-deactivator.php
 */
function deactivate_picsum_photos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-picsum-photos-deactivator.php';
	Picsum_Photos_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_picsum_photos' );
register_deactivation_hook( __FILE__, 'deactivate_picsum_photos' );

/**
 * Add custom blocks gutenberg
 */
require plugin_dir_path( __FILE__ ) . 'custom-blocks/index.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-picsum-photos.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_picsum_photos() {

	$plugin = new Picsum_Photos();
	$plugin->run();

}
run_picsum_photos();