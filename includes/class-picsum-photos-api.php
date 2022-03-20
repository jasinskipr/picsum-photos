<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       empty
 * @since      1.0.0
 *
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Picsum_Photos
 * @subpackage Picsum_Photos/includes
 * @author     Kamil Jasiński <jasinskipr@gmail.com>
 */
class Picsum_Photos_API {


    private $plugin_name;

    private $api_url;

	/**
	 * 
	 * @since    1.0.0
	 */
	public function __construct() {
        $this->api_url = PICSUM_PHOTOS_API_URL;
        $this->plugin_name = PICSUM_PHOTOS_PLUGIN_NAME;
	}

    public function get_data_json(){
        $json_data = file_get_contents($this->api_url);
        return json_decode($json_data);
    }

    public function insert_post() {
        // Create post object
        // Create new post.
        $post_data = array(
            'post_title'    => 'My post',
            'post_type'     => 'post',
            'post_status'   => 'publish'
        );
        $post_id = wp_insert_post( $post_data );


        // Read JSON file
        $json_data = file_get_contents($this->api_url);

        // Save a basic text value.
        $field_key = "field_123456";
        $value = $json_data;
        update_field( $field_key, $value, $post_id );

    }

}