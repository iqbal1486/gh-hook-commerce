<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * TRANSAK_Registration_Activation_Init class responsable to load all the scripts and styles.
 */
class TRANSAK_Registration_Activation_Init {

    public function __construct() {
        
        //$this->transak_check_woocommerce_is_active_callback();
        //$this->transak_settings_update_options_callback();
        //add_action( 'activated_plugin', array( $this, 'transak_redirect_on_activation_callback' ) );

    }


    /*
    * Check woocommerce is active or not.
    */
    public function transak_check_woocommerce_is_active_callback(){
        $error = 'Please install and activate <b>woocommerce</b> plugin.';
        if ( !class_exists( 'WooCommerce' ) ) {
           die( 'Plugin not activated: ' . $error );
        }
    }

    /*
    * Updating default option for settings tab
    */
    public function transak_settings_update_options_callback(){

        $transak_settings = get_option( 'transak_settings_options' );
        if( isset( $transak_settings['transak_offset_amount'] ) && !empty($transak_settings['transak_offset_amount']) ){
            return true;
        }

        $transak_settings  = array(
            'transak_enable_widget_on_cart'     => 1,
            'transak_offset_amount'             => 2,
            'transak_card_management_prefered_topup' => 20,
        );

        update_option( 'transak_settings_options', $transak_settings );
    }
    

    /*
    * Redirect to onboarding process on plugin activation
    */
    public function transak_redirect_on_activation_callback(){
        
        /*
        * If the onboarding status is complete then redirect to dashboard page. If the status is pending then redirect to onboarding page
        */
        $transak_onboarding_status = get_option( 'cfc-onboarding-status' );

        $redirect_url =  get_admin_url().'admin.php?page=cfc-dashboard&tab=cfc-onboarding';
        
        if( isset( $transak_onboarding_status['status'] ) &&  $transak_onboarding_status['status'] == 'complete' ){
            $redirect_url =  get_admin_url().'admin.php?page=cfc-dashboard';
        }

        wp_redirect($redirect_url);
        exit();

    }

} // end of class TRANSAK_Registration_Activation_Init

$transak_registration_activation_init = new TRANSAK_Registration_Activation_Init;