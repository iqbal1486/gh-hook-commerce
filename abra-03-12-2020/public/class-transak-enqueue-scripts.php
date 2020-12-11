<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * TRANSAK_Enqueue_Scripts class responsable to load all the scripts and styles.
 */
class TRANSAK_Enqueue_Scripts {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 10);
    }

    public function public_enqueue_scripts() {

        
        
        wp_enqueue_script( 'transak-public-script', TRANSAK_PLUGIN_URL . '/assets/js/transak-public-script.js', array('jquery'), TRANSAK_PLUGIN_VER.rand() );
        wp_register_script( 'transak-front-form-script', TRANSAK_PLUGIN_URL . '/assets/js/transak-front-form-script.js', array('jquery'), TRANSAK_PLUGIN_VER.rand() );
        wp_register_script( 'wallet-address-validator-min', TRANSAK_PLUGIN_URL . '/assets/js/wallet-address-validator.min.js', array('jquery'), TRANSAK_PLUGIN_VER.rand() );
                
        wp_localize_script( 'transak-public-script', 'transakObj', array(
            'plugin_url'            => esc_url( TRANSAK_PLUGIN_URL ),
            'is_mobile'             => ( wp_is_mobile() ) ? '1' : '0',
            'current_page_id'       => get_the_ID(),
            'current_page_url'      => get_permalink(),
            'ajax_url'              => admin_url( 'admin-ajax.php?ver=' . uniqid() ),
            'version'               => TRANSAK_PLUGIN_VER,
        ) );

       wp_enqueue_style( 'transak-public-style', TRANSAK_PLUGIN_URL . 'assets/css/transak-public-style.css', array(), TRANSAK_PLUGIN_VER.rand() );
        
    }
    
} // end of class TRANSAK_Enqueue_Scripts

$transak_enqueue_scripts = new TRANSAK_Enqueue_Scripts;