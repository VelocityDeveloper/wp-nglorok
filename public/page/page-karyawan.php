<?php
/**
 * Class Page_Karyawan
 * shortcode : [page-karyawan]
 */
class Page_Karyawan {

    public $permalink;

     /**
     * constructor.
     */
    public function __construct() {
        add_shortcode('page_karyawan', array($this, 'render_page'));
    }

    function render_page(){        
        ob_start();
            $page = isset($_GET['pg'])?$_GET['pg']:'';
            $this->permalink = get_the_permalink();
            ?>
            <div class="card">
                <div class="card-body">
                    <?php
                    switch ($page) {
                        case 'edit':
                            $this->edit_users();
                            break;
                        default:
                            $this->table_users();
                            break;
                    }
                    ?>
                </div>
            </div>
            <?php
        return ob_get_clean();
    }

    function edit_users(){
        $id = isset($_GET['id'])?$_GET['id']:'';
        ?>
        <div class="text-end mb-3"> 
            <a href="<?php echo $this->permalink; ?>" title="Kembali ke Daftar Karyawan" class="btn btn-primary">
                <i class="mdi mdi-arrow-left"></i> Kembali
            </a>
        </div>
        <h4 class="card-title">Edit Karyawan</h4>
        <?php echo do_shortcode( '[edit-user user_id="'.$id.'"]' ); ?>
        <?php
    }

    function table_users(){
        $wng_profil = new Wp_Nglorok_Profile();
        $getusers = get_users();
        // $getusers = get_users( array( 'role__in' => array( 'subscriber' ) ) );
        ?>
        <h4 class="card-title">Karyawan</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Divisi</th>
                        <th>HP</th>
                        <th>Email</th>
                        <th>Masuk</th>
                        <th>Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($getusers): ?>
                        <?php foreach( $getusers as $user): ?>
                            <?php
                            $user_id    = $user->ID;
                            $nama       = get_user_meta($user_id,'full_name',true);
                            $nohp       = get_user_meta($user_id,'number_handphone',true);
                            $email      = get_user_meta($user_id,'email',true);
                            $entry      = get_user_meta($user_id,'entry_date',true);
                            $address    = get_user_meta($user_id,'address',true);
                            $divisi     = get_user_meta($user_id,'divisi',true);
                            $divisi     = $divisi?$wng_profil->divisi()[$divisi]:'';
                            
                            ?>
                            <tr>
                                <td>
                                    <?php echo $nama??'-';?>
                                </td>
                                <td>
                                    <?php echo $divisi??'-';?>
                                </td>
                                <td>
                                    <?php echo $nohp??'-';?>
                                </td>
                                <td>
                                    <?php echo $email??'-';?>
                                </td>
                                <td>
                                    <?php echo $entry??'-';?>
                                </td>
                                <td>
                                    <?php echo $address??'-';?>
                                </td>
                                <td class="text-end">
                                    <a href="<?php echo $this->permalink; ?>?pg=edit&id=<?php echo $user_id;?>" title="Edit" class="btn btn-inverse-primary btn-rounded p-2">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-inverse-danger btn-rounded p-2">
                                        <i class="ti-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

}

// Inisialisasi class Page_Karyawan
new Page_Karyawan();