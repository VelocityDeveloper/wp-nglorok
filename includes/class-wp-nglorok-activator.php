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
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // tb_webhost
        $table_name_webhost = $wpdb->prefix . 'webhost';
        $sql_webhost = "CREATE TABLE $table_name_webhost (
            id_webhost int(11) NOT NULL AUTO_INCREMENT,
            nama_web varchar(64) DEFAULT NULL,
            id_paket text DEFAULT NULL,
            tgl_mulai date DEFAULT NULL,
            id_server2 int(11) DEFAULT 1,
            id_server int(11) NOT NULL DEFAULT 1,
            space int(11) DEFAULT NULL,
            space_use int(11) DEFAULT NULL,
            hp varchar(64) DEFAULT NULL,
            telegram varchar(64) DEFAULT NULL,
            hpads text DEFAULT NULL,
            wa varchar(64) DEFAULT NULL,
            email varchar(200) DEFAULT NULL,
            tgl_exp date DEFAULT NULL,
            tgl_update date DEFAULT NULL,
            server_luar enum('0','1') DEFAULT NULL,
            saldo text DEFAULT NULL,
            kategori text DEFAULT NULL,
            waktu datetime DEFAULT NULL,
            via text DEFAULT NULL,
            konfirmasi_order text NOT NULL,
            kata_kunci text DEFAULT NULL,
            PRIMARY KEY  (id_webhost)
        ) $charset_collate;";

        // tb_wm_project
        $table_name_wm_project = $wpdb->prefix . 'wm_project';
        $sql_wm_project = "CREATE TABLE $table_name_wm_project (
            id_wm_project int(11) NOT NULL AUTO_INCREMENT,
            id_karyawan int(11) DEFAULT NULL,
            id int(11) DEFAULT NULL,
            start datetime DEFAULT NULL,
            stop datetime DEFAULT NULL,
            durasi float DEFAULT NULL,
            webmaster text DEFAULT NULL,
            date_mulai text DEFAULT NULL,
            date_selesai text DEFAULT NULL,
            qc text DEFAULT NULL,
            catatan varchar(128) DEFAULT NULL,
            status_multi enum('pending','selesai') DEFAULT 'pending',
            PRIMARY KEY  (id_wm_project)
        ) $charset_collate;";

		// tb_cs_main_project
		$table_name_cs_main_project = $wpdb->prefix . 'cs_main_project';
		$sql_cs_main_project = "CREATE TABLE $table_name_cs_main_project (
		id int(11) NOT NULL AUTO_INCREMENT,
		id_webhost int(11) DEFAULT NULL,
		jenis varchar(64) DEFAULT NULL,
		deskripsi mediumtext DEFAULT NULL,
		trf text DEFAULT NULL,
		tgl_masuk date DEFAULT NULL,
		tgl_deadline date DEFAULT NULL,
		biaya int(11) DEFAULT NULL,
		dibayar int(11) DEFAULT NULL,
		status enum('pending','selesai') DEFAULT 'pending',
		status_pm enum('pending','selesai') DEFAULT 'pending',
		lunas enum('belum','lunas') DEFAULT 'belum',
		dikerjakan_oleh varchar(100) DEFAULT '0',
		tanda int(1) NOT NULL DEFAULT 0,
		PRIMARY KEY  (id)
		) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        
        // Eksekusi query untuk membuat tabel
        dbDelta($sql_webhost);
        dbDelta($sql_wm_project);
		dbDelta($sql_cs_main_project);
    }
}