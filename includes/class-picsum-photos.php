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
class Picsum_Photos {

	protected $loader;
	protected $plugin_name;
	protected $version;
	protected $acf;
	protected $post;


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PICSUM_PHOTOS_VERSION' ) ) {
			$this->version = PICSUM_PHOTOS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = PICSUM_PHOTOS_PLUGIN_NAME;

		$this->load_dependencies();

		// Register custom post type - picsum-photos
		$this->acf = new Picsum_Photos_ACF();
		
		// Register custom post type - picsum-photos
		$this->posts = new Picsum_Photos_Custom_Post();
		
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'wpshout_do_thing', array($this, 'update_posts'), 10, 2 );

		$this->update_posts();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Picsum_Photos_Loader. Orchestrates the hooks of the plugin.
	 * - Picsum_Photos_i18n. Defines internationalization functionality.
	 * - Picsum_Photos_Admin. Defines all hooks for the admin area.
	 * - Picsum_Photos_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-picsum-photos-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-picsum-photos-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-picsum-photos-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-picsum-photos-public.php';
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-picsum-photos-acf.php';

		/**
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-picsum-photos-api.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-picsum-photos-custom-post.php';

		$this->loader = new Picsum_Photos_Loader();		
		
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Picsum_Photos_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Picsum_Photos_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Picsum_Photos_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Picsum_Photos_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Picsum_Photos_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function update_posts() {
		$api = new Picsum_Photos_API();
		$request_posts = $api->get_data_json();

		$posts = $this->posts->get_all_posts();
		print_r($posts);
		// update_option( PICSUM_PHOTOS_PLUGIN_NAME . '-get-first', $json_data[0]['author'], $autoload = null );
	}

}