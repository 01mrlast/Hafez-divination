<?php

namespace DHafez;

/**
 * Class Admin
 * @package DHafez
 */
class Admin {
	/**
	 * Admin constructor.
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initial plugin
	 */
	private function init_hooks() {
		// Check exists require function
		if ( ! function_exists( 'wp_get_current_user' ) ) {
			include( ABSPATH . "wp-includes/pluggable.php" );
		}

		// Add plugin caps to admin role
		if ( is_admin() and is_super_admin() ) {
			$this->add_cap();
		}

		// Actions.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_assets' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Adding new capability in the plugin
	 */
	public function add_cap() {
		// Get administrator role
		$role = get_role( 'administrator' );

		$role->add_cap( 'DHafez_table' );
		$role->add_cap( 'DHafez_setting' );
	}

	/**
	 * Include admin assets
	 *
	 * @param $hook
	 */
	public function admin_assets( $hook ) {
		if ( 'edit.php' == $hook ) {
			return;
		}

		
	}

	/**
	 * Register admin menu
	 */
	public function admin_menu() {
		add_menu_page( __( 'DHafez', 'DHafez' ), __( 'فال حافظ', 'DHafez' ), 'DHafez_table', 'DHafez', array( $this, 'DHafez_callback' ),plugins_url('icon.png', __FILE__));
		add_submenu_page( 'DHafez', __( 'Example Table Data', 'DHafez' ), __( 'Example Table Data', 'DHafez' ), 'DHafez_table', 'DHafez', array( $this, 'callback' ) );
	}

	/**
	 * Callback outbox page.
	 */
	public function callback() {
  ?>
    <div class="container">
        <br/>
        <div class="clearfix">
        </div>
        <style>
            .alert {
                margin: 50px;
                padding: 20px;
                background-color: #28a745;
                /* Red */
                color: white;
                text-align: center;
                direction: ltr
            }
            
            .center {
                text-align: center;
            }
        </style>
        <div style="margin-top: 25px">
            <h1 class="center">فال حافظ
            </h1>

            <br>
            <div class="row">

                <h1 class="center">  برای نمایش فایل در سایت خود کد زیر را قرار دهید
</h1>

                <br>
                <div class="alert">

                    <?php

echo htmlentities('<form method="POST">
<input type="submit" name="hafez" value="نمایش فال">
</form><br>[hafez]');

?>
                </div>

                <hr>

            </div>
        </div>
    </div>
    <?php
	}
}

new Admin();
