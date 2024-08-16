<?php

/**
 * Class Page_Billing
 */
class Page_Billing {
    
    /**
     * Page_Billing constructor.
     */
    public function __construct() {
        add_shortcode('page-billing', array($this, 'billing_data_shortcode_callback')); // [billing-data]
    }

    public function form_filter_date() {
        ob_start();
        $dari = isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-01');
        $sampai = isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d');
        ?>
<form action="" method="get">
    <div class="row align-items-end">
        <div class="col-md-5">
            <div class="form-group">
                <label for="dari">Tanggal masuk Dari</label>
                <input type="date" name="dari" id="dari" class="form-control date-picker form-control-sm"
                    value="<?php echo $dari; ?>">
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label for="sampai">Tanggal Masuk Sampai</label>
                <input type="date" name="sampai" id="sampai" class="form-control date-picker form-control-sm"
                    value="<?php echo $sampai; ?>">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </div>
</form>
<?php
    return ob_get_clean();
    }

    /**
    * Shortcode callback to display billing data.
    *
    * @param array $atts Shortcode attributes.
    * @param string $content Shortcode content.
    *
    * @return string
    */
    public function billing_data_shortcode_callback($atts, $content = null) {
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

    // Inisialisasi variabel
    $totalbulan = [];

    // Loop hasil query dan proses data

    ob_start();
    echo $this->form_filter_date();
    ?>
<div class="table-responsive" style="
    height: calc(100vh - 96px);
    overflow: auto;
">
    <table class="table table-striped">
        <tbody>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Nama Web</th>
                <th>Paket</th>
                <th>Deskripsi</th>
                <th>Trf</th>
                <th>Masuk Tanggal</th>
                <th>Deadline Tanggal</th>
                <th>Total Biaya</th>
                <th>Dibayar</th>
                <th>Kurang</th>
                <th>Saldo</th>
                <th>HP</th>
                <th>Telegram</th>
                <th>HP ads</th>
                <th>WA</th>
                <th>Email</th>
                <th>Dikerjakan Oleh</th>
                <th></th>
            </tr>
            <?php foreach ($results as $value) { 
                // echo '<pre>'.print_r($value, true).'</pre>';
                ?>
            <tr>
                <td style="font-size:12px;text-align:center;"><input class="tanda" type="checkbox" kode=""></td>
                <td><?php echo $value['jenis']; ?></td>
                <td><?php echo $value['nama_web']; ?></td>
                <td><?php echo $value['paket']; ?></td>
                <td><?php echo $value['deskripsi']; ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['trf']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_dmonY($value['tgl_masuk']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_dmonY($value['tgl_deadline']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['biaya']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['dibayar']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['biaya'] - $value['dibayar']); ?>
                </td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['saldo']); ?></td>
                <td><?php echo $value['hp']; ?></td>
                <td><?php echo $value['telegram']; ?></td>
                <td><?php echo $value['hpads']; ?></td>
                <td><?php echo $value['wa']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['dikerjakan_oleh']; ?></td>
                <td>
                    <a href="index.php?pg=billing&amp;ac=edit&amp;id=<?php echo $value['id']; ?>'"
                        class="btn btn-primary btn-sm text-white"><i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <button class="btn btn-danger btn-sm text-white" type="submit"><i class="fa fa-trash"
                            aria-hidden="true"></i>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php
        return ob_get_clean();
    }
}

// Inisialisasi class Page_Billing
new Page_Billing();