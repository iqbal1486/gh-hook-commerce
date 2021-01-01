<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gh_Cf7_Insightly
 * @subpackage Gh_Cf7_Insightly/public
 * @author     Momin Iqbal <Iqbal.Brightnessgroup@gmail.com>
 */
class Gh_Cf7_Insightly_Public {

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
		 * defined in Gh_Cf7_Insightly_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Cf7_Insightly_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gh-cf7-insightly-public.css', array(), $this->version, 'all' );

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
		 * defined in Gh_Cf7_Insightly_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Cf7_Insightly_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gh-cf7-insightly-public.js', array( 'jquery' ), $this->version, false );

	}

	public function form_submitted($form){
		global $wpdb;

		$tags 		=	$mapping = array();	
		$form_id 	=	$form->id();
		$form_title =	$form->title();
		$submission =	WPCF7_Submission::get_instance();  

		$lead 		= $submission->uploaded_files();

		if( !is_array($lead) ){  

				$lead 	=	array(); 

		}
	
		if( method_exists( 'WPCF7_ShortcodeManager','get_instance' ) || method_exists( 'WPCF7_FormTagsManager','get_instance' ) ){

			$form_text 	= get_post_meta($form_id ,'_form',true); 

			if( method_exists( 'WPCF7_FormTagsManager','get_instance' ) ){
				
				$manager 	=	WPCF7_FormTagsManager::get_instance(); 

				$contents 	=	$manager->scan($form_text); 

				$tags 		=	$manager->get_scanned_tags();   

			}else if( method_exists( 'WPCF7_ShortcodeManager','get_instance' ) ){
				
				$manager 	=	WPCF7_ShortcodeManager::get_instance();

				$contents 	=	$manager->do_shortcode($form_text);

				$tags 		=	$manager->get_scanned_tags();    

			} 
		}


		if( is_array( $tags ) ){

			foreach( $tags as $key	=>	$value ){

				if( !empty( $value['name'] ) ){

					$name 	=	$value['name'];

					$val 	=	$submission->get_posted_data($name);

					if( !isset( $lead[$name] ) ){  

						$lead[$name] 	=	$val;  

					}

				}  

			}
		}
			

		$form_arr 	=	array(
							'id' 	=> 	$form_id,
							'name' 	=>	$form_title,
							'fields'=>	$tags,
							'lead'  =>	$lead,

						);
		
		
		$mapping_data = $wpdb->get_results( "SELECT * FROM ".GH_CF7_INSIGHTLY_TABLE_MAPPING." WHERE form_ID = $form_id");
		
		if( !empty( $mapping_data ) ){

			foreach ( $mapping_data as $single_mapping_data ) {
			    
			    $module_name = $single_mapping_data->module_name;

			    $mapping = array_filter( unserialize( $single_mapping_data->mapping ) );

				foreach ($mapping as $key => $cf7_field) {
					if( !empty( $lead[$cf7_field] ) ){
						$mapping[$key] = $lead[$cf7_field];
					}
				}

				if( !empty( $module_name ) ){
					$headers = array(
				        "Authorization" 	=> "Basic " . base64_encode( GH_CF7_INSIGHTLY_API_KEY . ':' . "" ),
				        "Content-Type"  	=> "application/json",
				        "Accept"        	=> "application/json",
				        "Accept-Encoding"  	=> "gzip"
				    );

					$args = array(
				        "headers" => $headers,
				        "body" => json_encode( $mapping )
				    );

				    $response = wp_remote_post( GH_CF7_INSIGHTLY_API_URL.$module_name, $args );
				}
			}	
		}
	}
}
