<?php
    /*
    Plugin Name: WP Good Perception
    Plugin URI: https://www.demo.com/en
    Description: WordPress Good Perception
    Author: Demo
    Version: 1.0.0
    */

    // Preventing to direct access
    defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

    if ( ! defined( 'WPGP_PLUGIN_FILE' ) ) {
        define( 'WPGP_PLUGIN_FILE', __FILE__ );
    }

    if ( ! defined( 'WPGP_PLUGIN_PATH' ) ) {
        define( 'WPGP_PLUGIN_PATH', plugin_dir_path( WPGP_PLUGIN_FILE ) );
    }

    if ( ! defined( 'WPGP_PLUGIN_URL' ) ) {
        define( 'WPGP_PLUGIN_URL', plugin_dir_url( WPGP_PLUGIN_FILE ) );
    }

    if ( ! defined( 'WPGP_PLUGIN_VER' ) ) {
        define( 'WPGP_PLUGIN_VER', '1.0.0'.rand() );
    }

    // Load plugin with plugins_load
    function wpgp_init() {
        require_once WPGP_PLUGIN_PATH . 'class-wpgp-init.php';
        $wpgp_init = new WPGP_Init;
        $wpgp_init->init();
    }
    add_action( 'plugins_loaded', 'wpgp_init', 20 );



    /*
    *Registration deactivation hook
    */  
    register_deactivation_hook( __FILE__, 'wpgp_deactivate_callback' ); 
 
    function wpgp_deactivate_callback() {
       
    }

    /*
    *Registration deactivation hook
    */  
    register_activation_hook( __FILE__, 'wpgp_activate_callback' ); 
 
    function wpgp_activate_callback() {
    }
?>