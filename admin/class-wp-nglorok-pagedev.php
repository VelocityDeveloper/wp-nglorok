<?php
class Wp_Nglorok_PageDev {
    
    public function register_page() {
        add_menu_page(
            'Dev Nglorok',
            'Dev Nglorok',
            'manage_options',
            'dev-nglorok',
            [$this, 'render_page'],
            'dashicons-superhero',
            6
        );
    }

    public function render_page() {
        $run = [
            'default_page'      => 'Generate Default Halaman',
            'default_tb'        => 'Generate Default Tabel Database',
            'default_divisi'    => 'Generate Default Tabel Divisi',
        ];

        if(isset($_POST['submit'])){
            $this->run($_POST['run']);
        }

        ?>
        <div class="wrap">
            <h1>Developer Nglorok</h1>
            <form method="post" action="">
                <table class="form-table">
                    <?php foreach( $run as $k => $v): ?>
                        <tr> 
                            <th><label for="<?php echo $k; ?>"><?php echo $v; ?></label></th>
                            <td><input type="checkbox" name="run[<?php echo $k; ?>]" id="<?php echo $k; ?>" value="1"></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php submit_button('Jalankan'); ?>
            </form>
        </div>
        <?php
    }

    public function run($data){
        if(empty($data)){
            return false;
        }
        require_once WP_NGLOROK_PLUGIN_DIR . 'admin/class-wp-nglorok-defaultpage.php';
        require_once WP_NGLOROK_PLUGIN_DIR . 'admin/class-wp-nglorok-defaultdb.php';
        $page_creator   = new Wp_Nglorok_DefaultPage();
        $db_creator     = new Wp_Nglorok_Defaultdb();

        foreach ($data as $k => $v) {
            switch ($k) {
                case 'default_page':
                    $page_creator->create_pages();
                    break;
                case 'default_tb':
                    $db_creator->create_table();        
                    break;  
                case 'default_divisi':
                    $db_creator->insert_divisi();            
                    break;             
                default:
                    break;
            }
        }

    }

}
