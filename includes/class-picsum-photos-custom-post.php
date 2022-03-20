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
                'supports' => array( 'title',  'author', 'thumbnail' )
        )
    	);
	}

    public function get_all_posts(){
        $posts = get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> $this->plugin_name,
        ));

        return $posts;
    }

    public function is_exist($id){
        return get_posts(array(
            'numberposts'	=> -1,
            'post_type'		=> $this->plugin_name,
            'meta_query' => array(
                 array(
                    'key' => $this->plugin_name . '_id',
                    'value' => $id,
                ),
            ),
        ));
    }

    public function insert_post($post) {

        $attach_id = (new Picsum_Photos_Images)->upload_file($post);

        $post_data = array(
            'post_title'    => 'obrazek-' . $post->id,
            'post_type'     =>  $this->plugin_name,
            'post_status'   => 'publish',
        );

        $post_id = wp_insert_post( $post_data );

        // Save a basic text value.
        $field_key = $this->plugin_name . "_url";
        update_field( $field_key, $post->url, $post_id );

        $field_key = $this->plugin_name . "_author";
        update_field( $field_key, $post->author, $post_id );
        
        $field_key = $this->plugin_name . "_id";
        update_field( $field_key, $post->id, $post_id );

        set_post_thumbnail( $post_id, $attach_id );
    }

}