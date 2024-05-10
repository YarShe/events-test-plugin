<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://local.org
 * @since             0.1.0
 * @package           Test_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Test Plugin
 * Plugin URI:        https://local.org
 * Description:       A test plugin. Creates a custom post type and taxonomy for sliders
 * Version:           1.0.0
 * Author:            ysh
 * Author URI:        https://local.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       test-plugin
 * Domain Path:       /languages
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


final class Test_Plugin {
	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public $version = '0.1.0';

	/**
	 * Holds various class instances
	 *
	 * @var array
	 */
	private $container = [];

	/**
	 * Constructor for the Base_Plugin class
	 *
	 * Sets up all the appropriate hooks and actions
	 * within our plugin.
	 */
	public function __construct() {

		$this->define_constants();

		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * Initializes the Test_Plugin() class
	 *
	 * Checks for an existing Test_Plugin() instance
	 * and if it doesn't find one, creates it.
	 */

	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self;
		}

		return $instance;
	}
	/**
	 * Magic getter to bypass referencing plugin.
	 *
	 * @param $prop
	 *
	 * @return mixed
	 */
	public function __get( $prop ) {
		if ( array_key_exists( $prop, $this->container ) ) {
			return $this->container[ $prop ];
		}

		return $this->{$prop};
	}

	/**
	 * Magic isset to bypass referencing plugin.
	 *
	 * @param $prop
	 *
	 * @return mixed
	 */
	public function __isset( $prop ) {
		return isset( $this->{$prop} ) || isset( $this->container[ $prop ] );
	}



	/**
	 * Define the constants
	 *
	 * @return void
	 */
	public function define_constants() {
		define( 'TESTPLUGIN_VERSION', $this->version );
		define( 'TESTPLUGIN_FILE', __FILE__ );
		define( 'TESTPLUGIN_PATH', dirname( TESTPLUGIN_FILE ) );
		define( 'TESTPLUGIN_INCLUDES', TESTPLUGIN_PATH . '/includes' );
		define( 'TESTPLUGIN_BOOT', TESTPLUGIN_INCLUDES . '/bootstrap' );
		define( 'TESTPLUGIN_MODELS', TESTPLUGIN_INCLUDES . '/models' );
		define( 'TESTPLUGIN_VIEWS', TESTPLUGIN_INCLUDES . '/views' );
		define( 'TESTPLUGIN_URL', plugins_url( '', TESTPLUGIN_FILE ) );
		define( 'TESTPLUGIN_ASSETS', TESTPLUGIN_URL . '/assets' );
	}

	/**
	 * Load the plugin after all plugis are loaded
	 *
	 * @return void
	 */
	public function init_plugin() {
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Include the required files
	 *
	 * @return void
	 */
	public function includes() {

		require_once TESTPLUGIN_BOOT . '/Assets.php';
		require_once TESTPLUGIN_MODELS . '/Events.php';
		require_once TESTPLUGIN_MODELS . '/EventsGetter.php';
		require_once TESTPLUGIN_VIEWS . '/Pages.php';

		if ( $this->is_request( 'admin' ) ) {
			require_once TESTPLUGIN_BOOT . '/Admin.php';
		}

		if ( $this->is_request( 'frontend' ) ) {
			require_once TESTPLUGIN_BOOT . '/Frontend.php';
		}


	}

	/**
	 * Initialize the hooks
	 *
	 * @return void
	 */
	public function init_hooks() {

		add_action( 'init', array( $this, 'init_classes' ) );

		// Localize our plugin
		add_action( 'init', array( $this, 'localization_setup' ) );
	}

	/**
	 * Instantiate the required classes
	 *
	 * @return void
	 */
	public function init_classes() {

		if ( $this->is_request( 'admin' ) ) {
			$this->container['admin'] = new \App\bootstrap\Admin();
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->container['frontend'] = new \App\bootstrap\Frontend();
		}

		$this->container['assets'] = new \App\bootstrap\Assets();
		$this->container['events'] = new \App\models\Events();
		$this->container['pages'] = new App\views\Pages();

	}

	/**
	 * Initialize plugin for localization
	 *
	 * @uses load_plugin_textdomain()
	 */
	public function localization_setup() {
		load_plugin_textdomain( 'test-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * What type of request is this?
	 *
	 * @param  string $type admin, ajax, cron or frontend.
	 *
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}




}
$baseplugin = Test_Plugin::init();


