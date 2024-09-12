<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/public
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->register_page_shortcodes();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Nglorok_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Nglorok_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		*/

		if(get_page_template_slug() !== 'wp-nglorok-app')
		return false;

		$assets_css = [
			'feather' 				=> 'vendors/feather/feather.css',
			'themify' 				=> 'vendors/ti-icons/css/themify-icons.css',
			'bundle' 				=> 'vendors/css/vendor.bundle.base.css',
			'font-awesome' 			=> 'vendors/font-awesome/css/font-awesome.min.css',
			'materialdesignicons' 	=> 'vendors/mdi/css/materialdesignicons.min.css',
			'dataTables.bootstrap5' => 'vendors/datatables/dataTables.bootstrap5.css',
			'responsive.dataTables' => 'vendors/datatables/responsive.dataTables.css',
			'themify-icons' 		=> 'vendors/ti-icons/css/themify-icons.css',
			'select.dataTables' 	=> 'js/select.dataTables.min.css',
			'style'					=> 'css/style.css',
		];
		foreach ($assets_css as $key => $css_path) {
			wp_enqueue_style( $this->plugin_name.'-'.$key, plugin_dir_url( __FILE__ ) . 'assets/'.$css_path, array(), $this->version, 'all' );
		}

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/wp-nglorok-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Nglorok_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Nglorok_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if(get_page_template_slug() !== 'wp-nglorok-app')
		return false;

		$assets_js = [
			'bundle' 				=> 'vendors/js/vendor.bundle.base.js',
			'chart.umd'				=> 'vendors/chart.js/chart.umd.js',
			// 'datatablejs'			=> 'vendors/datatables/dataTables.min.js',
			// 'dataTables-bootstrap5' => 'vendors/datatables/dataTables.bootstrap5.js',
			// 'dataTables-responsive' => 'vendors/datatables/dataTables.responsive.js',
			// 'responsive-dataTables' => 'vendors/datatables/responsive.dataTables.js',
			// 'dataTables-select' 	=> 'js/dataTables.select.min.js',
			'off-canvas'			=> 'js/off-canvas.js',
			'template'				=> 'js/template.js',
			'settings'				=> 'js/settings.js',
			'todolist'				=> 'js/todolist.js',
			'jquery.cookie'			=> 'js/jquery.cookie.js',
			'dashboard'				=> 'js/dashboard.js',
		];
		foreach ($assets_js as $key => $js_path) {
			wp_enqueue_script( $this->plugin_name.'-'.$key, plugin_dir_url( __FILE__ ) . 'assets/'.$js_path, array('jquery'), $this->version, false );
		}

		$cdn_js = [
			'datatablejs'				=> 'https://cdn.datatables.net/2.1.6/js/dataTables.min.js',
			'datatablejs.bootstrap5'	=> 'https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.min.js',
			'datatablejs.responsive'	=> 'https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.min.js',
			'responsive.datatablejs'	=> 'https://cdn.datatables.net/responsive/3.0.3/js/responsive.bootstrap5.min.js',
			'datatablejs.select'		=> 'https://cdn.datatables.net/select/2.0.5/js/dataTables.select.min.js',
			'select.datatablejs'		=> 'https://cdn.datatables.net/select/2.0.5/js/select.bootstrap5.min.js',
			'datatablejs.fixedHeader'	=> 'https://cdn.datatables.net/fixedheader/4.0.1/js/dataTables.fixedHeader.js',
			'fixedHeader.datatablejs'	=> 'https://cdn.datatables.net/fixedheader/4.0.1/js/fixedHeader.dataTables.js',
		];
		foreach ($cdn_js as $key => $js_url) {
			wp_enqueue_script( $this->plugin_name.'-'.$key, $js_url, array( 'jquery' ), $this->version, false );
		}

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/wp-nglorok-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'wpnglorok',
			array(
				'ajaxUrl'        => admin_url('admin-ajax.php'),
				'restUrl'        => rest_url(),
			)
		);

	}

	//hide admin bar
	public function hide_admin_bar(){
		if (get_page_template_slug() === 'wp-nglorok-app') {
			return false;
		}
		return true;
	}

	//Register Page template
	public function page_templates($post_templates){
		$post_templates['wp-nglorok-app'] = __( 'App Nglorok', 'wp-nglorok' );
		return $post_templates;
	}
	public function template_include($template){
		if ( is_singular() ) {
			$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			if ( 'wp-nglorok-app' === $page_template ) {
				$template = plugin_dir_path( __FILE__ ) . '/page-app.php';
			}
		}
		return $template;
	}

	//register menu
	public function register_nav_menu(){
		register_nav_menus( array(
	    	'billing_menu' => __( 'Billing', 'wp-nglorok' ),
	    	'webmaster_menu'  => __( 'Webmaster', 'wp-nglorok' ),
		) );
	}

	// Register Page Shortcode 		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-nglorok-admin.php';
	public function register_page_shortcodes() {
		$list_pages = [
			'page-dashboard'	=> 'Dashboard',
			'page-billing'		=> 'Billing',
			'page-bill-dataweb'	=> 'Database Web',
			'page-karyawan'		=> 'Karyawan',
		];
		foreach ($list_pages as $key => $value) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/page/'.$key.'.php';
		}
	}
}
