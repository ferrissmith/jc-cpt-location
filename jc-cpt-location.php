<?php
/**
 * Plugin Name: JC CPT Location
 * Description: Creates the "Location" Custom Post Type.
 * Version: 0.1.0
 * Author: Real Big Marketing
 * Author URI: http://realbigmarketing.com
 */

if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Define plugin constants
define( 'CPT_LOCATION_VERSION', '0.1.0' );
define( 'CPT_LOCATION_DIR', plugin_dir_path( __FILE__ ) );
define( 'CPT_LOCATION_URL', plugins_url( '', __FILE__ ) );

/**
 * Class CPT_LOCATION
 *
 * Initiates the plugin.
 *
 * @since   0.1.0
 *
 * @package CPT_LOCATION
 */
class CPT_LOCATION {

	public $cpt_location;

	private function __clone() { }

	private function __wakeup() { }

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @staticvar Singleton $instance The *Singleton* instances of this class.
	 *
	 * @return CPT_LOCATION The *Singleton* instance.
	 */
	public static function getInstance() {

		static $instance = null;

		if ( null === $instance ) {
			$instance = new static();
		}

		return $instance;
	}

	/**
	 * Initializes the plugin.
	 *
	 * @since 0.1.0
	 */
	protected function __construct() {

		$this->add_base_actions();
		$this->require_necessities();
	}

	/**
	 * Requires necessary base files.
	 *
	 * @since 0.1.0
	 */
	public function require_necessities() {

		require CPT_LOCATION_DIR . '/core/class-cpt-location-initcpt.php';
		$this->cpt_location = new CPT_Location_InitCPT();
	}

	/**
	 * Adds global, base functionality actions.
	 *
	 * @since 0.1.0
	 */
	private function add_base_actions() {

		add_action( 'init', array( $this, '_register_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, '_enqueue_assets' ) );
	}

	/**
	 * Registers the plugin's assets.
	 *
	 * @since 0.1.0
	 */
	function _register_assets() {
	}

	function _enqueue_assets() {
	}
}

require_once __DIR__ . '/core/cpt-location-functions.php';
CPT_LOCATION();