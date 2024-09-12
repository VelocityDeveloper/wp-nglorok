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
		$number = (int) $number;
		return 'Rp ' . number_format( $number, 0, ',', '.' );
	}

	public static function convert_to_dmY( $date ) {
		return date( 'd-m-Y', strtotime( $date ) );
	}

	public static function convert_to_dmonY( $date ) {
		$months = [
			'01' => 'Jan',
			'02' => 'Feb',
			'03' => 'Mar',
			'04' => 'Apr',
			'05' => 'Mei',
			'06' => 'Jun',
			'07' => 'Jul',
			'08' => 'Agt',
			'09' => 'Sep',
			'10' => 'Okt',
			'11' => 'Nov',
			'12' => 'Des'
		];
	
		$timestamp = strtotime( $date );
		$day = date( 'd', $timestamp );
		$month = date( 'm', $timestamp );
		$year = date( 'Y', $timestamp );
	
		// Format the date as 'tanggal d M Y'
		return $day . ' ' . $months[ $month ] . ' ' . $year;
	}

    public static function get_user_names( string $input ) : string {
        // Pisahkan input berdasarkan koma
        $parts = explode(',', $input);
		$part = [];
		foreach ($parts as $key => $value) {
			// explode 	,10[100] menjadi 10 dan 100
			$id_karyawan = explode('[', $value)[0];
			$user = get_users(array(
				'meta_query' => array(
					array(
						'key' => 'id_karyawan',
						'value' => '"'.$id_karyawan.'"',
						'compare' => 'LIKE',
					),
				),
			));
			// echo '<pre>'.print_r($user, true).'</pre>';
			$display_name = $user[0]->display_name ?? '';
			$part[$key] = $display_name;
		}

        // Gabungkan kembali array menjadi string
		$part = array_filter( $part );
        return implode(',', $part);
    }

}