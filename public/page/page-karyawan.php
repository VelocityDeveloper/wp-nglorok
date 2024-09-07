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

            $page   = isset($_GET['pg'])?$_GET['pg']:'';
            $id     = isset($_GET['id'])?$_GET['id']:'';
            $this->permalink = get_the_permalink();

            switch ($page) {
                case 'edit':
                    $card_title = 'Edit Karyawan';
                    $card_body  = do_shortcode( '[edit-user user_id="'.$id.'"]' );
                    break;
                default:
                    $card_title = 'Karyawan';
                    $card_body  = $this->table_users();
                    break;
            }

            $before_card = '<div class="text-end mb-3">';
            $before_card .= '<a href="'.get_admin_url().'user-new.php" title="Tambah Karyawan" class="btn btn-sm btn-primary me-1" target="_blank"><i class="mdi mdi-plus"></i> Tambah</a>';
            if($page){
                $before_card .= '<a href="'.$this->permalink.'" title="Kembali ke Daftar Karyawan" class="btn btn-sm btn-outline-primary"><i class="mdi mdi-arrow-left"></i> Kembali</a>';
            }
            $before_card .= '</div>';

            $args = [
                'card-title'    => $card_title,
                'card-body'     => $card_body,
                'before-card'   => $before_card,
            ];
            $card  = new Wp_Nglorok_Card($args);
            echo $card->render();

        return ob_get_clean();
    }
    

    function table_users(){
        ob_start();

            $wng_profil = new Wp_Nglorok_Profile();
            $getusers   = get_users( array( 'role__in' => array( 'subscriber' ) ) );

            $tb_header  = ['Nama','Divisi','HP','Email','Masuk','Status','Alamat',''];
            $tb_body    = [];
            foreach( $getusers as $user){

                $user_id    = $user->ID;
                $nama       = get_user_meta($user_id,'first_name',true);
                $nohp       = get_user_meta($user_id,'number_handphone',true);
                $email      = get_user_meta($user_id,'user_email',true);
                $entry      = get_user_meta($user_id,'entry_date',true);
                $address    = get_user_meta($user_id,'address',true);
                $status     = get_user_meta($user_id,'status',true);
                $divisi     = get_user_meta($user_id,'divisi',true);
                $divisi     = $divisi?$wng_profil->divisi()[$divisi]:'';
                $action     = '<a href="'.$this->permalink.'?pg=edit&id='.$user_id.'" title="Edit" class="btn btn-inverse-primary btn-rounded p-2"><i class="mdi mdi-pencil"></i></a>';

                $tb_body[]  = [
                    $nama,
                    $nohp,
                    $email,
                    $entry,
                    $address,
                    $status,
                    $divisi,
                    $action
                ];
            }
            $table  = new Wp_Nglorok_Table('tablekaryawan',$tb_header,$tb_body);
            echo $table->render();

        return ob_get_clean();
    }

}

// Inisialisasi class Page_Karyawan
new Page_Karyawan();