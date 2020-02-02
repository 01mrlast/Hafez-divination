<?php

namespace DHafez;

/**
 * Class Option
 * @package DHafez
 */
class Option {
	/**
	 * @var mixed|void
	 */
	static $option;

	/**
	 * Option constructor.
	 */
	public function __construct() {
		self::$option = get_option('DHafez_settings');
	}

	/**
	 * Get the whole Plugin Options
	 * @return mixed|void
	 */
	public static function getOptions() {
		return self::$option;
	}

	/**
	 * Get the only Option that we want
	 *
	 * @param $option_name
	 *
	 * @return string
	 */
	public static function get( $option_name ) {
		return isset( self::$option[ $option_name ] ) ? self::$option[ $option_name ] : '';

	}
}

new Option();