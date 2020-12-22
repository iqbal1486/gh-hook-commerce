<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/admin
 * @author     Momin Iqbal <Iqbal.Brightnessgroup@gmail.com>
 */
class Gh_Cf7_Insightly_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gh_Cf7_Insightly_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Cf7_Insightly_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gh-cf7-insightly-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Gh_Cf7_Insightly_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Cf7_Insightly_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gh-cf7-insightly-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function edit_update_mapping(){
		if ( ! is_admin() || ! isset( $_POST['save_gh_cf7_insightly_mapping'] )  || !wp_verify_nonce($_REQUEST['gh_cf7_insightly_save_mapping_nonce_field'], 'gh_cf7_insightly_save_mapping_nonce')) {
            return;
        }

        $post_data               = stripslashes_deep( $_POST );
        echo "<pre style='margin-left:250px'>";
        print_r($post_data);
        echo "</pre>";


        $mapping_settings  = array(
						'gh_enable_widget_on_cart' => isset($post_data['gh_enable_widget_on_cart']) ? $post_data['gh_enable_widget_on_cart'] : '0',
						'gh_cf7_insightly_api_key' => isset($post_data['gh_cf7_insightly_api_key']) ? $post_data['gh_cf7_insightly_api_key'] : '',
			        );

        //update_option( 'gh_cf7_insightly_mapping', $mapping_settings );

	}

	public function edit_update_basic_options(){
		if ( ! is_admin() || ! isset( $_POST['save_gh_cf7_insightly_options'] )  || !wp_verify_nonce($_REQUEST['gh_cf7_insightly_options_nonce_field'], 'gh_cf7_insightly_options_nonce')) {
            return;
        }

        $post_data               = stripslashes_deep( $_POST );

        $basic_settings  = array(
						'gh_enable_widget_on_cart' => isset($post_data['gh_enable_widget_on_cart']) ? $post_data['gh_enable_widget_on_cart'] : '0',
						'gh_cf7_insightly_api_key' => isset($post_data['gh_cf7_insightly_api_key']) ? $post_data['gh_cf7_insightly_api_key'] : '',
			        );

        update_option( 'gh_cf7_insightly_options', $basic_settings );

	}

	public function register_sub_menu(){
		add_menu_page('GH CF7 to Insighlty', 'GH CF7 to Insighlty', 'manage_options', 'gh-cf-insightly');
		$hook = add_submenu_page(
	        'gh-cf-insightly',
	        __( 'GH CF7 to Insighlty Settings', 'gh-cf7-insightly' ),
	        __( 'GH CF7 to Insighlty Settings', 'gh-cf7-insightly' ),
	        'manage_options',
	        'gh-cf-insightly',
	        array( $this, 'gh_cf_insightly_settings_callback' )
	    );
		
		add_action( "load-$hook", [ $this, 'initialize_object' ] );

	}

	public function gh_cf_insightly_settings_callback(){
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/gh-cf7-insightly-admin-display.php';
	}

	
	public function initialize_object() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gh-cf7-insightly-admin-logs.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-gh-cf7-insightly-admin-mapping.php';
		$this->gh_cf7_insightly_logs_obj = new GH_CF7_Insightly_Logs();
		$this->gh_cf7_insightly_mappings_obj = new GH_CF7_Insightly_Mapping();
	}
}