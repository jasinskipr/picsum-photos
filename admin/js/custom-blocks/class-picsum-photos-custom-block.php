<?php

class Picsum_Photos_Custom_Block {

	/**
	 * 
	 * @since    1.0.0
	 */
	public function __construct() {
        add_action( 'init', array($this, 'gutenberg_examples_01_register_block' ));
	}

    public function gutenberg_examples_01_register_block() {
        register_block_type( __DIR__ );
    }

}