<?php
/**
 * Buat page/halaman default.
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/admin
*/

class Wp_Nglorok_DefaultPage {

    private $pages_data = array(
        array(
            'slug'      => 'dashboard',
            'title'     => 'Dashboard',
            'content'   => '[page_dashboard]'
        ),
        array(
            'slug'      => 'billing',
            'title'     => 'Billing',
            'content'   => '[page_billing]'
        ),
        array(
            'slug'      => 'bill_dataweb',
            'title'     => 'Database Web',
            'content'   => '[page_bill_dataweb]'
        ),
        array(
            'slug'      => 'lead',
            'title'     => 'Lead Order',
            'content'   => '[page_lead]'
        ),
        array(
            'slug'      => 'leadads',
            'title'     => 'Lead Iklan',
            'content'   => '[page_leadads]'
        ),
        array(
            'slug'      => 'iklan_google_per_bulan',
            'title'     => 'Iklan Google per bulan',
            'content'   => '[page_iklan_google_per_bulan]'
        ),
        array(
            'slug'      => 'form',
            'title'     => 'Jumlah Form',
            'content'   => '[page_form]'
        ),
        array(
            'slug'      => 'rincian_transaksi_grafik',
            'title'     => 'Rincian Transaksi Grafik',
            'content'   => '[page_rincian_transaksi_grafik]'
        ),
        array(
            'slug'      => 'kelola_cuti',
            'title'     => 'Data Cuti',
            'content'   => '[page_kelola_cuti]'
        ),
        array(
            'slug'      => 'jurnal',
            'title'     => 'Jurnal',
            'content'   => '[page_jurnal]'
        ),
        array(
            'slug'      => 'pemakaian_themes',
            'title'     => 'Pemakaian Themes',
            'content'   => '[page_pemakaian_themes]'
        ),
        array(
            'slug'      => 'peningkatan_order_cs',
            'title'     => 'Peningkatan Order CS',
            'content'   => '[page_peningkatan_order_cs]'
        ),
    );

    public function create_pages() {
        foreach ($this->pages_data as $page_data) {
            if(get_page_by_path($page_data['slug']) == null){
                $page_id = $this->create($page_data['title'], $page_data['slug'], $page_data['content']);
            }
        }
    }
    
    public function create($title,$slug,$content) {
        
        $page_id = wp_insert_post(array(
            'post_title'    => wp_strip_all_tags( $title ),
            'post_content'  => $content,
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'guid'          => $slug,
            'post_name'     => $slug,
            'page_template' => 'wp-nglorok-app'
        ));

        return $page_id;
    }


}