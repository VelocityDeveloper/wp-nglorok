<?php

/**
 * Class Page_Billing
 */
class Page_Billing {
    
    private $dari;
    private $sampai;

    /**
     * Page_Billing constructor.
     */
    public function __construct() {
        $this->dari = $_GET['dari'] ?? '';
        $this->sampai = $_GET['sampai'] ?? '';
        add_shortcode('page_billing', array($this, 'render_page')); // [billing-data]
    }

    public function before_card() {
        ob_start();
        $modal_filter_date = new Wp_Nglorok_Modal('filterDateModal', 'Tanggal Masuk', $this->form_filter_date(), '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>');
        ?>
        
        <div class="d-flex justify-content-between mb-2">
            <div class="d-flex">
                <?php echo $modal_filter_date->render(); ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    public function content() {
        global $wpdb; // Gunakan $wpdb untuk query ke database WordPress

        // Ambil tanggal sekarang
        $date = new DateTime();
        $sampai = $date->format('Y-m-d');
        $dari = $date->format('Y-m-01');

        // Query ke database menggunakan $wpdb
        $query = "
        SELECT id, {$wpdb->prefix}cs_main_project.id_webhost as id_webhost, jenis, nama_web, deskripsi, trf,
        paket, biaya, dibayar, saldo, tgl_masuk, tgl_deadline, hp, telegram, hpads, wa, email, dikerjakan_oleh
        FROM {$wpdb->prefix}cs_main_project
        INNER JOIN {$wpdb->prefix}webhost
        ON {$wpdb->prefix}cs_main_project.id_webhost = {$wpdb->prefix}webhost.id_webhost
        INNER JOIN {$wpdb->prefix}paket
        ON {$wpdb->prefix}webhost.id_paket = {$wpdb->prefix}paket.id_paket
        ORDER BY {$wpdb->prefix}cs_main_project.tgl_masuk DESC
        LIMIT 10
        ";
        $results = $wpdb->get_results($query, ARRAY_A);
        ob_start();

        $tb_body    = [];
        foreach ($results as $row) {
            $tb_body[] = [
                $row['id'],
                $row['jenis'],
                $row['nama_web'],
                $row['paket'],
                $row['deskripsi'],
                Wp_Nglorok_Helpers::convert_to_rupiah($row['trf']),
                Wp_Nglorok_Helpers::convert_to_dmonY($row['tgl_masuk']),
                Wp_Nglorok_Helpers::convert_to_dmonY($row['tgl_deadline']),
                Wp_Nglorok_Helpers::convert_to_rupiah($row['biaya']),
                Wp_Nglorok_Helpers::convert_to_rupiah($row['dibayar']),
                Wp_Nglorok_Helpers::convert_to_rupiah($row['dibayar'] - $row['biaya']),
                Wp_Nglorok_Helpers::convert_to_rupiah($row['saldo']),
                $row['hp'],
                $row['telegram'],
                $row['hpads'],
                $row['wa'],
                $row['email'],
                Wp_Nglorok_Helpers::get_user_names($row['dikerjakan_oleh']),
                '<a href="#" class="btn btn-sm btn-primary" title="Edit"><i class="mdi mdi-pencil"></i></a>'
            ];
        }
                
        $args = [
            'id'            => 'tablebilling',
            'header'        => ['No','Jenis','Nama Web','Paket','Deskripsi','Trf','Masuk Tgl','Deadline Tgl','Total Biaya','Dibayar','Kurang','Saldo','HP','Telegram','HP ads','WA','Email','Dikerjakan Oleh','Tindakan'],
            'body'          => $tb_body,
        ];
        $table  = new Wp_Nglorok_Table($args);
        echo $table->render();

        return ob_get_clean();
    }

    public function after_card(){
        ob_start();
        ?>
        <?php
        return ob_get_clean();
    }

    public function form_filter_date() {
        ob_start();

        ?>
        <form action="" method="get">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->dari; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sampai">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->sampai; ?>">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }

    public function form_filter_jenis() {
        ob_start();
        ?>
        <form action="" method="get">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->dari; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sampai">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->sampai; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dari">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->dari; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sampai">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control date-picker form-control-sm"
                            value="<?php echo $this->sampai; ?>">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }

    public function render_page(){
        ob_start();
        $before_card = $this->before_card();
        $card_body   = $this->content();
        $after_card  = $this->after_card();
        $args = [
            'before-card'   => $before_card,
            'card-title'    => 'Billing',
            'card-body'     => $card_body,
            'after-card'   => $after_card,
        ];
        $card  = new Wp_Nglorok_Card($args);
        echo $card->render();
        return ob_get_clean();
    }
}

// Inisialisasi class Page_Billing
new Page_Billing();