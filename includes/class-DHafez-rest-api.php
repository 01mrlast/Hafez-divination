<?php

namespace DHafez\API;

/**
 * Class REST
 * @package DHafez\API
 */
class REST {

	/**
	 * API constructor.
	 */
	public function __construct() {

	}

	/**
	 * @return mixed
	 */
	public function get_data() {
		$data = array(
			array(
				'name' => 'Pamela',
				'date' => '00:00:00 00:00:00',
				'text' => 'Text 1',
			),
			array(
				'name' => 'Michelle',
				'date' => '00:00:00 00:00:00',
				'name' => 'Text 2',
			),
			array(
				'name' => 'Jeffrey',
				'date' => '00:00:00 00:00:00',
				'name' => 'Text 3',
			),
			array(
				'name' => 'John',
				'date' => '00:00:00 00:00:00',
				'name' => 'Text 4',
			)
		);

		return $data;
	}
}