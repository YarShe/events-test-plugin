<?php

namespace App\bootstrap;

/**
 * Admin Pages Handler
 */
class Admin {

	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Register our menu page
	 *
	 * @return void
	 */


	/**
	 * Initialize our hooks for the admin page
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Load scripts and styles for the app
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'testplugin-admin' );
		wp_enqueue_script( 'testplugin-admin' );
	}

	/**
	 * Render our admin page
	 *
	 * @return void
	 */
	public function plugin_page() {
		echo '<div class="wrap"><div id="vue-admin-app"></div></div>';
	}
}