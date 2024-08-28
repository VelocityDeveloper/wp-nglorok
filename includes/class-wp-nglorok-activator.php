<?php

/**
 * Fired during plugin activation
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Activator {

    /**
     * Code to run during plugin activation.
     *
     * @since    1.0.0
     */
    public static function activate() {
        
        /**
		 * The class untuk membuat table.
        */
		require_once WP_NGLOROK_PLUGIN_DIR . 'admin/class-wp-nglorok-defaultdb.php';
		$db_creator = new Wp_Nglorok_Defaultdb();
        $db_creator->create_table();

    }
}