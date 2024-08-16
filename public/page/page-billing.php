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
        $date       = new DateTime();
        $sampai     = $date->format('Y-m-d');
        $dari       = $date->format('Y-m-01');

        // Buat kondisi WHERE

        // Query ke database menggunakan $wpdb
        $query = "
            SELECT * 
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
        ?>
<div class="table-responsive" style="
    height: calc(100vh - 96px);
    overflow: auto;
">
    <table class="table table-striped">
        <tbody>
            <tr>
                <th width="35" scope="col">No</th>
                <th width="80">Jenis</th>
                <th scope="col">Nama Web</th>
                <th scope="col">Paket</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Trf</th>
                <th scope="col"><a href="index.php?pg=billing&amp;ac=short&amp;by=tgl_masuk">Masuk Tanggal</a></th>
                <th scope="col"><a href="index.php?pg=billing&amp;ac=short&amp;by=tgl_deadline">Deadline Tanggal</a>
                </th>
                <th scope="col"><a href="index.php?pg=billing&amp;ac=short&amp;by=biaya">Total Biaya</a></th>
                <th scope="col">Dibayar</th>
                <th scope="col"><a href="index.php?pg=billing&amp;ac=short&amp;by=sisa">Kurang</a></th>
                <th scope="col">Saldo</th>
                <th scope="col">HP</th>
                <th scope="col">Telegram</th>
                <th scope="col"><a href="index.php?pg=billing&amp;ac=short&amp;by=hpads">HP ads</a></th>
                <th scope="col">WA</th>
                <th scope="col" style="width:50px;">Email</th>
                <th scope="col">Dikerjakan Oleh</th>

                <th></th>
            </tr>
            <?php foreach ($results as $value) { 
                echo '<pre>'.print_r($value, true).'</pre>';
                ?>
            <tr>
                <td style="font-size:12px;text-align:center;">
                    <input class="tanda" type="checkbox" kode="38313">
                </td>
                <td><?php echo $value['jenis']; ?></td>
                <td>
                    <div class="nama-web" style="font-size:12px;word-wrap: break-word; ">
                        <?php echo $value['nama_web']; ?></div>
                </td>
                <td><?php echo $value['paket']; ?></td>
                <td><?php echo $value['deskripsi']; ?></td>
                <td><?php echo $value['trf']; ?></td>
                <td><?php echo $value['tgl_masuk']; ?></td>
                <td><?php echo $value['tgl_deadline']; ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['biaya']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['dibayar']); ?></td>
                <td><?php echo Wp_Nglorok_Helpers::convert_to_rupiah($value['biaya'] - $value['dibayar']); ?></td>
                <td> </td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo $value['hp']; ?></td>
                <td><?php echo $value['email']; ?></td>
                <td><?php echo $value['dikerjakan_oleh']; ?></td>
                <td>
                    <center><a href="index.php?pg=billing&amp;ac=edit&amp;id=38313&amp;paging=1#38313"
                            title="Edit Data"><img style="max-width:25px;width:25px" src="images/edit.png"></a>


                        <a onclick="return hapus(&quot;Data rudibermartabat.com , Jenis Jasa Update Web ,Yakin Menghapus Data ini ?? &quot;)"
                            href="index.php?pg=billing&amp;ac=hapus&amp;id=38313&amp;paging=1" title="Hapus Data"><img
                                style="max-width:25px;width:25px" src="images/delete.png"></a>
                    </center>
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