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
class Picsum_Photos_Custom_Post {

    private $plugin_name;

	/**
	 * 
	 * @since    1.0.0
	 */
	public function __construct() {
        $this->plugin_name = PICSUM_PHOTOS_PLUGIN_NAME;

        add_action('init', array($this, 'add_custom_post_type'));
	}

    	/**
	 * Register custom post type.
	 *
	 * @since     1.0.0
	 * @access   private
	 */
	public function add_custom_post_type() {
		register_post_type($this->plugin_name, 
        array(
            'labels'      => array(
                'name'          => __('Piscum Photos', 'picsum-photos'),
                'singular_name' => __('Piscum Photo', 'picsum-photos'),
            ),
                'public'      => true,
                'has_archive' => true,
        )
    	);
	}

    public function get_all_posts(){
        $posts = get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> $this->plugin_name,
        ));

        foreach ($posts as $key => $post) {
            $post[ $this->plugin_name . '_id'] = get_field( $this->plugin_name . '_id') ?? null;
        }

        return $posts;
    }

    public function insert_post() {
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