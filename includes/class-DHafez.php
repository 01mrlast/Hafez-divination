<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

class DHafez {
	/**
	 * DHafez constructor.
	 */
	public function __construct() {
		$this->set_constants();
		$this->includes();
		$this->init_hooks();
	}

	/**
	 * Define Constants.
	 */
	private function set_constants() {
		define( 'DHafez_ABSPATH', plugin_dir_path( DHafez_PLUGIN_FILE ) );
		define( 'DHafez_URL', plugin_dir_url( dirname( __FILE__ ) ) );
	}

	/**
	 * Initial plugin setup.
	 */
	private function init_hooks() {
		register_activation_hook( DHafez_PLUGIN_FILE, array( '\DHafez\Install', 'install' ) );

		// Load text domain
		add_action( 'init', array( $this, 'load_textdomain' ) );
	}

	/**
	 * Load plugin textdomain.
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'DHafez', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Includes classes and functions.
	 */
	public function includes() {
		require_once DHafez_ABSPATH . 'includes/class-DHafez-install.php';

		if ( is_admin() ) {
			require_once DHafez_ABSPATH . 'includes/admin/class-DHafez-admin.php';
		} else {
			require_once DHafez_ABSPATH . 'includes/class-DHafez-public.php';
		}

		// Utility classes.
		require_once DHafez_ABSPATH . 'includes/class-DHafez-option.php';
		require_once DHafez_ABSPATH . 'includes/class-DHafez-public.php';

		// API classes.
		require_once DHafez_ABSPATH . 'includes/class-DHafez-rest-api.php';
		require_once DHafez_ABSPATH . 'includes/api/v1/class-DHafez-api-controller.php';

		// Template functions.
		require_once DHafez_ABSPATH . 'includes/template-functions.php';
	}
}