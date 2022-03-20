<?php

/**
 * Fired during plugin deactivation
 *
 * @link       empty
 * @since      1.0.0
 *
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 * @author     Kamil Jasiński <jasinskipr@gmail.com>
 */
class Picsum_Photos_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook( 'wpshout_do_thing' );
	}

}