<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://velocitydeveloper.com
 * @since      1.0.0
 *
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Nglorok
 * @subpackage Wp_Nglorok/includes
 * @author     Velocity Developer <bantuanvelocity@gmail.com>
 */
class Wp_Nglorok {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Nglorok_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WP_NGLOROK_VERSION' ) ) {
			$this->version = WP_NGLOROK_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wp-nglorok';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Nglorok_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Nglorok_i18n. Defines internationalization functionality.
	 * - Wp_Nglorok_Admin. Defines all hooks for the admin area.
	 * - Wp_Nglorok_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-nglorok-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-nglorok-i18n.php';

		/**
		 * The class responsible for defining all function that occur in the dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-nglorok-helpers.php';

		/**
		 * The class responsible for defining user profile.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-nglorok-profile.php';
		 
		/**
		* The class Wp_Nglorok_Menu
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-nglorok-menu.php';

		/**
		* Page Dev nglorok
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-nglorok-pagedev.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-nglorok-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-nglorok-public.php';

		/**
		 * The class to load all components
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/components/class-wp-nglorok-modal.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/components/class-wp-nglorok-card.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/components/class-wp-nglorok-table.php';

		$this->loader = new Wp_Nglorok_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Nglorok_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Nglorok_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin	= new Wp_Nglorok_Admin( $this->get_plugin_name(), $this->get_version() );
		$page_dev		= new Wp_Nglorok_PageDev();

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $page_dev, 'register_page' );
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Nglorok_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 50 );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'template_include', $plugin_public, 'template_include' );
		$this->loader->add_filter( 'theme_page_templates', $plugin_public, 'page_templates' );
		$this->loader->add_filter( 'show_admin_bar', $plugin_public, 'hide_admin_bar' );
		$this->loader->add_action( 'after_setup_theme', $plugin_public, 'register_nav_menu' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Nglorok_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}