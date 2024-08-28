<?php
/**
 * Buat table.
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/admin
*/

class Wp_Nglorok_Defaultdb {

    private $table_karyawan;
    private $table_divisi_karyawan;

    public function __construct() {
        global $wpdb;
        $this->table_karyawan = $wpdb->prefix . 'karyawan';
        $this->table_divisi_karyawan = $wpdb->prefix . 'divisi_karyawan';
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        
        // SQL untuk membuat tabel
        $sql_jenis_karyawan = "CREATE TABLE IF NOT EXISTS $this->table_divisi_karyawan (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            divisi tinytext NOT NULL,
            nama_divisi tinytext NOT NULL,
            id_karyawan tinytext NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_jenis_karyawan);
    }

    public function insert_divisi() {
        global $wpdb;

        $query = "
            SELECT jenis, GROUP_CONCAT(id_karyawan) as id_karyawan_list
            FROM $this->table_karyawan
            GROUP BY jenis
        ";
        $results = $wpdb->get_results($query, ARRAY_A);

        // Mengubah hasil menjadi array
        $idkaryawan = [];
        foreach ($results as $row) {
            $idkaryawan[$row['jenis']] = explode(',', $row['id_karyawan_list']);
        }
        $idkaryawan['webmaster_b'] = [10];

        // Data default untuk tabel divisi_karyawan
        $default_divisi_karyawan = [
            'webmaster_b'       => 'Webmaster Biasa',
            'webmaster'         => 'Webmaster Custom',
            'project_manager'   => 'Project Manager',
            'client_support'    => 'Support',
            'keuangan'          => 'Keuangan',
            'finance'           => 'Finance',
            'billing'           => 'Billing',
            'pemilik'           => 'Pemilik',
            'superadmin'        => 'Super Admin',
        ];
        foreach ($default_divisi_karyawan as $d => $divisi) {

            // Cek apakah data sudah ada
            $exists = $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM $this->table_divisi_karyawan WHERE divisi = %s",$d
            ));

            if ($exists == 0) {
                $id_karyawan = isset($idkaryawan[$d])?json_encode($idkaryawan[$d]):'';
                // Insert data jika belum ada
                $wpdb->insert($this->table_divisi_karyawan, array(
                    'divisi'        => $d,
                    'nama_divisi'   => $divisi,
                    'id_karyawan'   => $id_karyawan,
                ));
                echo '<p>Berhasil menambahkan divisi '.$divisi.'</p>';
            }

        }
    }
}