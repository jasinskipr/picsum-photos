<?php

// defined( 'ABSPATH' ) || exit;


/**
 * Plugin Name: Gutenberg examples dynamic
 */
 
function gutenberg_examples_dynamic_render_callback( $attributes, $content, $block_instance ) {
    
	$args = array(
		'numberposts' => 10,
		'post_type'   => 'picsum-photos'
	);
	
	$post_query = new WP_Query($args);
    ob_start();
	/**
	 * Keeping the markup to be returned in a separate file is sometimes better, especially if there is very complicated markup.
	 * All of passed parameters are still accessible in the file.
	 */
	require plugin_dir_path( __FILE__ ) . 'build/template.php';
	return ob_get_clean();
}
 
function gutenberg_examples_dynamic() {
    // automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
	
    wp_register_script(
        'gutenberg-examples-dynamic',
        plugins_url( 'build/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );
 
    register_block_type( 'gutenberg-examples/example-dynamic', array(
        'api_version' => 2,
        'editor_script' => 'gutenberg-examples-dynamic',
        'render_callback' => 'gutenberg_examples_dynamic_render_callback'
    ) );
 
}
add_action( 'init', 'gutenberg_examples_dynamic' );