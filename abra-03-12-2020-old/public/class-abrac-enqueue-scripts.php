<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * ABRAC_Enqueue_Scripts class responsable to load all the scripts and styles.
 */
class ABRAC_Enqueue_Scripts {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 10);
    }

    public function public_enqueue_scripts() {

        
        
        wp_enqueue_script( 'abrac-public-script', ABRAC_PLUGIN_URL . '/assets/js/abrac-public-script.js', array('jquery'), ABRAC_PLUGIN_VER.rand() );
        wp_register_script( 'abrac-front-form-script', ABRAC_PLUGIN_URL . '/assets/js/abrac-front-form-script.js', array('jquery'), ABRAC_PLUGIN_VER.rand() );
        wp_register_script( 'wallet-address-validator-min', ABRAC_PLUGIN_URL . '/assets/js/wallet-address-validator.min.js', array('jquery'), ABRAC_PLUGIN_VER.rand() );
                
        wp_localize_script( 'abrac-public-script', 'abracObj', array(
            'plugin_url'            => esc_url( ABRAC_PLUGIN_URL ),
            'is_mobile'             => ( wp_is_mobile() ) ? '1' : '0',
            'current_page_id'       => get_the_ID(),
            'current_page_url'      => get_permalink(),
            'ajax_url'              => admin_url( 'admin-ajax.php?ver=' . uniqid() ),
            'version'               => ABRAC_PLUGIN_VER,
        ) );

       wp_enqueue_style( 'abrac-public-style', ABRAC_PLUGIN_URL . 'assets/css/abrac-public-style.css', array(), ABRAC_PLUGIN_VER.rand() );
        
    }
    
} // end of class ABRAC_Enqueue_Scripts

$abrac_enqueue_scripts = new ABRAC_Enqueue_Scripts;