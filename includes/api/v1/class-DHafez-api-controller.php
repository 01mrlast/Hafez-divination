<?php

namespace DHafez\API;

/**
 * Class Table
 * @package DHafez\API
 */
class Table extends REST {
	/**
	 * Building constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register routes
	 */
	public function register_routes() {
		register_rest_route( 'DHafez/v1', '/table', array(
			'methods'  => 'GET',
			'callback' => array( $this, 'table_callback' ),
		) );
	}

	/**
	 * @param \WP_REST_Request $request
	 *
	 * @return array|mixed|object|\WP_Error
	 */
	public function table_callback( \WP_REST_Request $request ) {
		// Get params
		$params = $request->get_params();

		$response = $this->get_data();

		return $response;
	}
}

new Table();