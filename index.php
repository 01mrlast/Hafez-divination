<?php
/**
 * Plugin Name: WP Hafez
 * Plugin URI: https://github.com/01mrlast/Hafez-divination
 * Description: فال حافظ  شیرازی
 * Version: 1.0
 * Author: Samson last
 * Author URI: https://mrlast.com/
 * Text Domain: DHafez
 * Domain Path: /languages
 */

// Define IGNITE_PLUGIN_FILE.
if ( ! defined( 'DHafez_PLUGIN_FILE' ) ) {
	define( 'DHafez_PLUGIN_FILE', __FILE__ );
}

/**
 * Load main class.
 */
require 'includes/class-DHafez.php';

/**
 * Main instance of plugin.
 */
new DHafez();