<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
*/

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */

class Wp_Nglorok_Profile
{
    private $prefix = '';

    public function init()
    {
        add_shortcode('edit-user', array($this, 'render_user_meta_form'));
        add_action('cmb2_admin_init', array($this, 'register_user_meta'));
        add_action('cmb2_init', array($this, 'register_user_frontend_form'));
    }

    public function divisi(){
        
        global $wpdb;
        $result         = [];
        $tb_karyawan    = $wpdb->prefix . 'wpng_divisi_karyawan';
        $karyawan       = $wpdb->get_results("SELECT * FROM $tb_karyawan",ARRAY_A);

        if (!empty($karyawan)) {
            foreach ($karyawan as $row) {
                $result[$row['divisi']] = $row['nama_divisi'];
            }
        }

        return $result;
    }

    public function register_user_meta(){        
        $cmb_user = new_cmb2_box(array(
            'id'           => $this->prefix . 'user_meta_form',
            'object_types' => array('user'),
            'hookup'       => true,
            'save_fields'  => true,
        ));
        $cmb_user->add_field(array(
            'name'      => 'ID Karyawan',
            'id'        => $this->prefix . 'id_karyawan',
            'type'      => 'text',
            'column'    => true,
            'repeatable'  => true,
        ));
        $cmb_user->add_field(array(
            'name'    => 'Catatan',
            'id'      => $this->prefix . 'catatan',
            'type'    => 'textarea',
            'attributes' => [
                'rows' => 2
            ]
        ));
    }

    public function register_user_frontend_form()
    {
        $cmb_user = new_cmb2_box(array(
            'id'           => $this->prefix . 'user_frontend_form',
            'object_types' => array('user'),
            'hookup'       => true,
            'save_fields'  => true,
        ));

        $cmb_user->add_field(array(
            'name'    => 'Nama Lengkap',
            'id'      => $this->prefix . 'first_name',
            'type'    => 'text',
        ));

        $cmb_user->add_field(array(
            'name'    => 'No Handphone',
            'id'      => $this->prefix . 'number_handphone',
            'type'    => 'text',
        ));

        $cmb_user->add_field(array(
            'name'    => 'Email',
            'id'      => $this->prefix . 'user_email',
            'type'    => 'text_email',
        ));

        $cmb_user->add_field(array(
            'name'    => 'Tanggal Masuk',
            'id'      => $this->prefix . 'entry_date',
            'type'    => 'text_date',
            'date_format' => 'Y-m-d',
            // 'attributes' => [
            //     'type' => 'date',
            // ]
        ));

        $cmb_user->add_field(array(
            'name'    => 'Alamat Lengkap',
            'id'      => $this->prefix . 'address',
            'type'    => 'textarea',
            'attributes' => [
                'rows' => 2
            ]
        ));

        $cmb_user->add_field(array(
            'name'    => 'Divisi',
            'id'      => $this->prefix . 'divisi',
            'type'    => 'select',
            'options' => $this->divisi(),
            'column' => true,
        ));

        $cmb_user->add_field(array(
            'name'    => 'Status',
            'id'      => $this->prefix . 'status',
            'type'    => 'select',
            'options' => array(
                'aktif'  => 'Aktif',
                'resign' => 'Resign',
            ),
        ));

        $cmb_user->add_field(array(
            'name'    => 'Foto Profil',
            'id'      => $this->prefix . 'avatar',
            'type'    => 'file',
            'options' => array(
                'url' => false, // Hide the text input for the url
            ),
        ));
    }

    public function render_user_meta_form($atts = array())
    {
        if (!is_user_logged_in()) {
            return '<p>You need to be logged in to edit your profile.</p>';
        }

        // Current user
        if(isset($atts['user_id']) && $atts['user_id']=='new'){
            $user_id = 'new-object-id';
        } else {
            $user_id = isset($atts['user_id'])?absint( $atts['user_id'] ):get_current_user_id();
        }

        // Use ID of metabox in wds_frontend_form_register
        $metabox_id = isset($atts['id']) ? esc_attr($atts['id']) : $this->prefix . 'user_frontend_form';

        // Get CMB2 metabox object
        $cmb = cmb2_get_metabox($metabox_id, $user_id);

        if (empty($cmb)) {
            return 'Metabox ID not found';
        }

        // Initiate our output variable
        $output = '';

        $updated = $this->handle_submit($cmb, $user_id);
        if ($updated) {

            if (is_wp_error($updated)) {

                // If there was an error with the submission, add it to our output.
                $output .= '<div class="alert alert-warning">' . sprintf(__('There was an error in the submission: %s', 'cmb2-user-submit'), '<strong>' . $updated->get_error_message() . '</strong>') . '</div>';
            } else {

                // Add notice of submission
                $output .= '<div class="alert alert-success">' . __('Profile has been updated successfully.', 'cmb2-user-submit') . '</div>';
            }
        }

        // Get our form
        $form = cmb2_get_metabox_form($cmb, $user_id, array('save_button' => __('Update Profile', 'cmb2-user-submit')));

        // Format our form use Bootstrap 5
        $styling = [
            'regular-text'                              => 'regular-text form-control',
            'cmb2-text-small'                           => 'cmb2-text-small form-control',
            'cmb2-text-medium'                          => 'cmb2-text-medium form-control',
            'cmb2-timepicker'                           => 'cmb2-timepicker form-control d-inline-block',
            'cmb2-datepicker'                           => 'cmb2-datepicker d-inline-block',
            'cmb2-text-money'                           => 'cmb2-text-money form-control d-inline-block',
            'cmb2_textarea'                             => 'cmb2_textarea form-control w-100',
            'cmb2-textarea-small'                       => 'cmb2-textarea-small form-control d-inline-block',
            'cmb2_select'                               => 'cmb2_select form-select',
            'cmb2-upload-file regular-text'             => 'cmb2-upload-file regular-text form-control d-block w-100',
            'type="radio" class="cmb2-option"'          => 'type="radio" class="cmb2-option form-check-input"',
            'type="checkbox" class="cmb2-option"'       => 'type="checkbox" class="cmb2-option form-check-input"',
            'class="button-primary"'                    => 'class="button-primary btn btn-primary float-end"',
            'cmb2-metabox-description'                  => 'cmb2-metabox-description fw-normal small',
            'class="cmb-th"'                            => 'class="cmb-th w-100 p-0"',
            'class="cmb-td"'                            => 'class="cmb-th w-100 p-0 pb-2"',
            'class="cmb-add-row"'                       => 'class="cmb-add-row text-end"',
            'button-secondary'                          => 'button-secondary btn-sm btn btn-outline-secondary',
            'cmb2-upload-button'                        => 'cmb2-upload-button mt-1 ms-0',
            'button-secondary btn-sm btn btn-outline-secondary cmb-remove-row-button' => 'button-secondary btn btn-danger cmb-remove-row-button',
        ];

        $form = strtr($form, $styling);

        $output .= $form;

        return $output;
    }

    function handle_submit($cmb, $user_id)
    {

        // If no form submission, bail
        if (empty($_POST)) {
            return false;
        }

        // Fetch sanitized values
        $sanitized_values = $cmb->get_sanitized_values($_POST);

        if($sanitized_values['first_name'] && $sanitized_values['user_email'] && $user_id ){
            $args_user = array(
                'ID'            => $user_id,
                'user_email'    => esc_attr( $sanitized_values['user_email'] ),
                'display_name'  => esc_attr( $sanitized_values['first_name'] ),
            );
            wp_update_user( $args_user );
        }

        // Loop through remaining (sanitized) data, and save to user-meta
        foreach ($sanitized_values as $key => $value) {
            update_user_meta($user_id, $key, $value);
        }

        return true;
    }

    function avatar($user_id=null){
        if(empty($user_id)){
            $user_id = get_current_user_id();
        }

        $foto = get_user_meta($user_id,'avatar',true);
        $foto = $foto?$foto:WP_NGLOROK_PLUGIN_URL.'public/assets/images/ava.webp';

        return $foto;

    }

}

// Inisialisasi kelas
$Wp_Nglorok_Profile = new Wp_Nglorok_Profile();
$Wp_Nglorok_Profile->init();

// Remove the action hook
// remove_action('cmb2_init', array($Wp_Nglorok_Profile, 'register_user_frontend_form'));