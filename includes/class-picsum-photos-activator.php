<?php

/**
 * Fired during plugin activation
 *
 * @link       empty
 * @since      1.0.0
 *
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 * @author     Kamil Jasiński <jasinskipr@gmail.com>
 */
class Picsum_Photos_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! wp_next_scheduled( 'wpshout_do_thing' ) ) {
        	wp_schedule_event( time(), 'daily', 'wpshout_do_thing' );
    	}
	}

}