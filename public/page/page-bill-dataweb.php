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
        $offset     = $_POST['start'] ?? '';
        $search     = $_POST['search']['value'] ??'';
        $order_col  = $_POST['order'][0]['column']??'';
        $order_dir  = $_POST['order'][0]['dir']??'';

        $orderby    = 'ORDER BY tgl_mulai DESC';
        if($order_col == 2 && $order_dir){
            $orderby = 'ORDER BY tgl_mulai '.$order_dir;
        }

        //filter        
        $filter_masuk_dari      = $_POST['filter_masuk_dari']??'';
        $filter_masuk_sampai    = $_POST['filter_masuk_sampai']??'';
        $filter_kriteria        = $_POST['filter_kriteria']??'';
        $filter_cari            = $_POST['filter_cari']??'';

        //where
        $where = [];
        if($filter_kriteria && $filter_cari){
            $where[] = $filter_kriteria." like '%".$filter_cari."%'";
        }
        $where = $where?'WHERE '.explode(" ",$where):'';

        $query          = "SELECT * FROM {$this->prefix}webhost JOIN {$this->prefix}paket ON {$this->prefix}webhost.id_paket={$this->prefix}paket.id_paket $where $orderby LIMIT $limit OFFSET $offset";
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
                '<a href="#" title="Edit" class="btn btn-inverse-primary btn-rounded p-2"><i class="mdi mdi-pencil"></i></a>
                <a href="#" title="Hapus" class="btn btn-inverse-danger btn-rounded p-2"><i class="mdi mdi-close"></i></a>',
            ];
        }

        $response = [
            'where'             => $where,
            'query'             => $query,
            'draw'              => $_POST['draw'] ?? 1,
            'recordsTotal'      => $this->wpdb->get_var($query_total),
            'recordsFiltered'   => $this->wpdb->get_var($query_total),
            'data'              => $data,
        ];

        wp_send_json($response);
    }

    public function form_filter(){
        ob_start();
        ?>
        <div>
            <div class="row">
                <div class="col-md-12">                    
                    <label class="form-label">Tanggal Masuk</label>
                </div>
                <div class="col-md-6">
                    <input type="date" id="filter_masuk_dari" class="form-control form-control-sm">
                </div>
                <div class="col-md-6">
                    <input type="date" id="filter_masuk_sampai" class="form-control form-control-sm">
                </div>
                <div class="col-md-12 mt-3">                    
                    <label class="form-label">Cari Berdasarkan</label>
                </div>
                <div class="col-md-6">
                    <select name="kriteria" id="filter_kriteria" class="form-select form-select-sm">
                        <?php foreach( [
                            'nama_web'  => 'Nama Web',
                            'paket'     => 'Paket',
                            'hp'        => 'HP',
                            'telegram'  => 'Telegram',
                            'hpads'     => 'HP Ads',
                            'wa'        => 'WA',
                            'email'     => 'Email'
                        ] as $k => $opt): ?>
                            <option value="<?php echo $k; ?>"><?php echo $opt; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" id="filter_cari" class="form-control form-control-sm">
                </div>
            </div>
            <div class="mt-3 text-end">
                <span id="prosesfilter" class="btn btn-primary">
                    Filter
                </span>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function render_page(){
        ob_start();
        
            $args = [
                'id'            => 'tablebill_dataweb',
                'header'        => ['Nama Web', 'Paket', 'Masuk Tanggal', 'Saldo', 'HP', 'Telegram','HP ads','WA','Email',''],
                'datatables'    => [
                    'ajax_action'   => 'page_bill_dataweb',
                    'ordering'      => 'true',
                    'columnDefs'    => "{ orderable: true, className: 'reorder', targets: 2 }, { orderable: false, targets: '_all' },",
                    'ajax_data'     => ['filter_masuk_dari','filter_masuk_sampai','filter_kriteria','filter_cari'],
                    'ajax_reload'   => '#prosesfilter',
                ]
            ];
            $table  = new Wp_Nglorok_Table($args);
            $modal  = new Wp_Nglorok_Modal([
                'id'            => 'cari-billdata',
                'title'         => 'Filter',
                'body'          => $this->form_filter(),
                'button-text'   => 'Filter',
            ]);

            $cardbody = $modal->render();
            $cardbody .= $table->render();

            $args = [
                'before-card'   => '',
                'card-title'    => 'Database Web',
                'card-body'     => $cardbody,
                'after-card'    => '',
            ];
            $card  = new Wp_Nglorok_Card($args);
            echo $card->render();

        return ob_get_clean();
    }

}

// Inisialisasi class Page_Billing
new Page_Bill_Dataweb();