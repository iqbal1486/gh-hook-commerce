<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/iqbal1486/
 * @since      1.0.0
 *
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gh_Hook_Commerce
 * @subpackage Gh_Hook_Commerce/public
 * @author     Geekerhub <iahmed964@gmail.com>
 */
class Gh_Hook_Commerce_Public {

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
	public function __construct( $plugin_name, $version, $options_en ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options_en = $options_en;

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
		 * defined in Gh_Hook_Commerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Hook_Commerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/gh-hook-commerce-public.css', array(), $this->version, 'all' );

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
		 * defined in Gh_Hook_Commerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Gh_Hook_Commerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/gh-hook-commerce-public.js', array( 'jquery' ), $this->version, false );

	}


	public function gh_rename_checkout_page_label_callback( $fields ) {
		
		
		$checkout_page_label_mapping = $this->options_en['gh_rename_checkout_page_label_mapping'];
		if($checkout_page_label_mapping){
			foreach ($checkout_page_label_mapping as $key => $value) {
				if( $fields['billing'][$value['gh_existing_field']] ){
					$fields['billing'][$value['gh_existing_field']]['label'] = $value['gh_label_tobe_replaced'];
				}

				if( $fields['shipping'][$value['gh_existing_field']] ){
					$fields['shipping'][$value['gh_existing_field']]['label'] = $value['gh_label_tobe_replaced'];
				}

				if( $fields['account'][$value['gh_existing_field']] ){
					$fields['account'][$value['gh_existing_field']]['label'] = $value['gh_label_tobe_replaced'];
				}

				if( $fields['order'][$value['gh_existing_field']] ){
					$fields['order'][$value['gh_existing_field']]['label'] = $value['gh_label_tobe_replaced'];
				}
				
			}	
		}
		
	    
	    return $fields;
	}


	public function gh_custom_checkout_fields_callback( $fields ){
		
		$custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

		if( $custom_checkout_field_mapping ){

			/*
				echo "<pre>";
				print_r( $fields );
				echo "</pre>";

				echo "<pre>";
				print_r( $custom_checkout_field_mapping );
				echo "</pre>";
			*/

			foreach ($custom_checkout_field_mapping as $key => $value) {
				$gh_type 				=   $value['gh_checkout_field_type'];
	            $gh_add_to 				=   $value['gh_checkout_field_add_to'];
	            $gh_unique_id 			=   $value['gh_checkout_field_unique_id'];
	            $gh_label 				=   $value['gh_checkout_field_label'];
	            $gh_placeholder 		=   $value['gh_checkout_field_placeholder'];
	            $gh_class 				=   explode(" ", $value['gh_checkout_field_class']);
	            $gh_required 			=   ( $value['gh_checkout_field_required'] == 'yes' ) ? true : false;

	            /*
		            $gh_error_message 		=   $value['gh_checkout_field_error_message'];
		            $gh_show_on_view_order 	=   $value['gh_checkout_field_show_on_view_order'];
		            $gh_add_to_email 		=   $value['gh_checkout_field_add_to_email'];
				*/

	            if ($gh_add_to == "shipping" || $gh_add_to == "billing"){

					$fields[$gh_add_to][$gh_unique_id] = array(
						'label'     	=> __($gh_label, 'woocommerce'),
						'type'      	=> $gh_type,
						'placeholder'   => _x($gh_placeholder, 'placeholder', 'woocommerce'),
						'required'   	=> $gh_required,
						'class'     	=> $gh_class,
						'clear'     	=> true
					);
				}
			}
			

		}

		return $fields;
	}


	public function gh_custom_checkout_fields_on_order_notes_callback($checkout){

		$custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

		if( $custom_checkout_field_mapping ){
			foreach ($custom_checkout_field_mapping as $key => $value) {
				$gh_type 				=   $value['gh_checkout_field_type'];
	            $gh_add_to 				=   $value['gh_checkout_field_add_to'];
	            $gh_unique_id 			=   $value['gh_checkout_field_unique_id'];
	            $gh_label 				=   $value['gh_checkout_field_label'];
	            $gh_placeholder 		=   $value['gh_checkout_field_placeholder'];
	            $gh_class 				=   explode(" ", $value['gh_checkout_field_class']);
	            $gh_required 			=   ( $value['gh_checkout_field_required'] == 'yes' ) ? true : false;

	            if ($gh_type == "after_order_notes"){

	            	echo '<div>';
						woocommerce_form_field( 
								$id, array(
										'label'     	=> __($gh_label, 'woocommerce'),
										'type'      	=> $gh_type,
										'placeholder'   => _x($gh_placeholder, 'placeholder', 'woocommerce'),
										'required'   	=> $gh_required,
										'class'     	=> $gh_class,
										'clear'     	=> true
										), $checkout->get_value( $id )
						);

					echo '</div>';	
	            }
			}	
		}	
	}


	public function gh_custom_checkout_fields_process_callback(){

    	$custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

		if( $custom_checkout_field_mapping ){
			foreach ($custom_checkout_field_mapping as $key => $value) {
		       	$gh_unique_id 			=   $value['gh_checkout_field_unique_id'];
	     		$gh_error_message 		=   $value['gh_checkout_field_error_message'];
	     		$gh_required 			=   ( $value['gh_checkout_field_required'] == 'yes' ) ? true : false;

	            if ( ! $_POST[$gh_unique_id] && $gh_required )
        			wc_add_notice( __( $gh_error_message ), 'error' );
			}	
		}
	}


	public function gh_custom_checkout_fields_update_order_meta_callback( $order_id ){

    	$custom_checkout_field_mapping = $this->options_en['gh_add_custom_checkout_field_mapping'];

		if( $custom_checkout_field_mapping ){
			foreach ($custom_checkout_field_mapping as $key => $value) {
		       	$gh_unique_id 			=   $value['gh_checkout_field_unique_id'];
	     		
	     		if ( ! empty( $_POST[$gh_unique_id] ) )
        			update_post_meta( $order_id, $gh_unique_id, sanitize_text_field( $_POST[$gh_unique_id] ) );
			}	
		}
	}
}
