<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/includes
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
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/includes
 * @author     Geekerhub <iahmed964@gmail.com>
 */
class Gh_Hook_Commerce {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Gh_Hook_Commerce_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'GH_HOOK_COMMERCE_VERSION' ) ) {
			$this->version = GH_HOOK_COMMERCE_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'gh-hook-commerce';
		$this->options = get_option( $this->plugin_name );
		$this->options_en = $this->options['en'];
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
	 * - Gh_Hook_Commerce_Loader. Orchestrates the hooks of the plugin.
	 * - Gh_Hook_Commerce_i18n. Defines internationalization functionality.
	 * - Gh_Hook_Commerce_Admin. Defines all hooks for the admin area.
	 * - Gh_Hook_Commerce_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gh-hook-commerce-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gh-hook-commerce-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gh-hook-commerce-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-gh-hook-commerce-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/exopite-options/exopite-options-framework-class.php';

		$this->loader = new Gh_Hook_Commerce_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Gh_Hook_Commerce_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Gh_Hook_Commerce_i18n();

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

		$plugin_admin = new Gh_Hook_Commerce_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_options_en() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'create_menu', 0 );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'rename_woocoomerce_admin_menu_callback', 999 );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'replace_woocommerce_dashicons_callback' );
		
		if($this->options_en['gh_change_name_of_product_menu'] == "yes"){
			$this->loader->add_filter( 'woocommerce_register_post_type_product', $plugin_admin, 'cpt_label_woo_callback' );
		}

		if($this->options_en['gh_add_custom_checkout_field'] == "yes"){
			
			$this->loader->add_action( 'woocommerce_admin_order_data_after_shipping_address', $plugin_admin, 'gh_custom_checkout_fields_display_after_shipping_address_callback', 10, 1 );

			$this->loader->add_action( 'woocommerce_admin_order_data_after_billing_address', $plugin_admin, 'gh_custom_checkout_fields_display_after_billing_address_callback', 10, 1 );

		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Gh_Hook_Commerce_Public( $this->get_plugin_name(), $this->get_version(), $this->get_options_en() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		if( $this->options_en['gh_rename_checkout_page_label'] == "yes" ){
			$this->loader->add_filter( 'woocommerce_checkout_fields' , $plugin_public, 'gh_rename_checkout_page_label_callback', 9999 );
		}

		if( $this->options_en['gh_add_custom_checkout_field'] == "yes" ){
			
			$this->loader->add_filter( 'woocommerce_checkout_fields' , $plugin_public, 'gh_custom_checkout_fields_callback', 9998 );

			$this->loader->add_action( 'woocommerce_after_order_notes', $plugin_public, 'gh_custom_checkout_fields_on_order_notes_callback' );

			$this->loader->add_action( 'woocommerce_checkout_process', $plugin_public, 'gh_custom_checkout_fields_process_callback' );
			
			$this->loader->add_action( 'woocommerce_checkout_update_order_meta', $plugin_public, 'gh_custom_checkout_fields_update_order_meta_callback' );

		}

		if( $this->options_en['gh_rename_checkout_place_order_button'] ){
			$this->loader->add_filter( 'woocommerce_order_button_text', $plugin_public, 'gh_rename_checkout_place_order_button_callback', 9999 );	
		}

		if( $this->options_en['gh_add_content_under_place_order_button'] == "yes" ){
			$this->loader->add_action( 'woocommerce_review_order_after_submit' , $plugin_public, 'gh_add_content_under_place_order_button_callback', 9999 );
		}


		if( $this->options_en['gh_show_distinct_cart_item_count'] == "yes" ){
			$this->loader->add_filter( 'woocommerce_cart_contents_count', $plugin_public, 'gh_show_distinct_cart_item_count_callback', 9999, 1 );	
		}


		if( $this->options_en['gh_split_cart_table'] == "yes" ){
			$this->loader->add_action( 'wp_footer' , $plugin_public, 'gh_split_cart_table_callback', 9999 );
		}

		if( $this->options_en['gh_edit_continue_shopping_link'] ){
			$this->loader->add_action( 'woocommerce_continue_shopping_redirect' , $plugin_public, 'gh_edit_continue_shopping_link_callback', 9999 );
		}

		

	
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
	 * @return    Gh_Hook_Commerce_Loader    Orchestrates the hooks of the plugin.
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


	public function get_options_en() {
		return $this->options_en;
	}


	public function recursive_array_search_php( $needle, $haystack ){
		foreach( $haystack as $key => $value ) {
			$current_key = $key;
			if(
				$needle === $value
				OR (
					 	is_array( $value )
						&& recursive_array_search_php( $needle, $value ) !== false
				 	)
			){
				return $current_key;
			}
		}
		return false;
 	}
}
