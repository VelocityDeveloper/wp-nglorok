<?php

/**
 * Helpers class for common utility functions
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 */

/**
 * Defines various utility functions used throughout the plugin.
 *
 * This class provides common utility functions such as number conversion to Rupiah,
 * user role registration, and date formatting.
 *
 * @since      1.0.0
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Helpers {


	public static function convert_to_rupiah( $number ) {
		return 'Rp ' . number_format( $number, 0, ',', '.' );
	}

	public static function convert_to_dmY( $date ) {
		return date( 'd-m-Y', strtotime( $date ) );
	}

}