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
		echo 'Rp ' . number_format( $number, 0, ',', '.' );
	}

	public static function convert_to_dmY( $date ) {
		echo date( 'd-m-Y', strtotime( $date ) );
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
		echo $day . ' ' . $months[ $month ] . ' ' . $year;
	}

	public static function modal( $id='', $title='', $content='', $footer='' ) {
		// ob_start();
		?>
		<div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" aria-labelledby="<?php echo $id; ?>Label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="<?php echo $id; ?>Label"><?php echo $title; ?></h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<?php echo $content; ?>
					</div>
					<?php if( !empty( $footer ) ) { ?>
					<div class="modal-footer">
						<?php echo $footer; ?>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php
		// return ob_get_clean();
	}

}