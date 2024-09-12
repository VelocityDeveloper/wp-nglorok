<?php

/**
 * Class Page_Bill_Dataweb
 */
class Page_Bill_Dataweb {

    private $wpdb;
    private $prefix;

    /**
     * constructor.
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->prefix = $wpdb->prefix;

        add_shortcode('page_bill_dataweb', array($this, 'render_page'));
        add_action('wp_ajax_page_bill_dataweb', array($this, 'ajax'));
    }

    public function ajax() {

        $limit      = $_POST['length'] ?? 100;
        $offset     = $_POST['start'] ?? 0;
        $search     = $_POST['search']['value'] ??'';

        $query          = "SELECT * FROM {$this->prefix}webhost JOIN {$this->prefix}paket ON {$this->prefix}webhost.id_paket={$this->prefix}paket.id_paket LIMIT $limit";
        $results        = $this->wpdb->get_results($query, ARRAY_A);

        $query_total    = "SELECT COUNT(*) FROM {$this->prefix}webhost";
        
        $data       = [];
        foreach ($results as $row) {
            $data[] = [
                $row['nama_web'],
                $row['paket'],
                $row['tgl_mulai'],
                '',
                $row['hp'],
                $row['telegram']!=0?$row['telegram']:'',
                $row['hpads'],
                $row['wa'],
                $row['email'],
                '',
            ];
        }

        $response = [
            'draw'              => $_POST['draw'] ?? 1,
            'recordsTotal'      => $this->wpdb->get_var($query_total),
            'recordsFiltered'   => $this->wpdb->get_var($query_total),
            'data'              => $data
        ];

        wp_send_json($response);
    }

    public function content(){
        ob_start();

        $args = [
            'id'            => 'tablebill_dataweb',
            'header'        => ['Nama Web', 'Paket', 'Masuk Tanggal', 'Saldo', 'HP', 'Telegram','HP ads','WA','Email',''],
            'datatables'    => [
                'ajax_action'   => 'page_bill_dataweb',
                'ordering'      => 'false',
            ]
        ];
        $table      = new Wp_Nglorok_Table($args);
        $table->render();

        return ob_get_clean();
    }

    public function render_page(){
        ob_start();
        
            $card_body   = $this->content();
            $args = [
                'before-card'   => '',
                'card-title'    => 'Database Web',
                'card-body'     => $card_body,
                'after-card'    => '',
            ];
            $card  = new Wp_Nglorok_Card($args);
            echo $card->render();

        return ob_get_clean();
    }

}

// Inisialisasi class Page_Billing
new Page_Bill_Dataweb();