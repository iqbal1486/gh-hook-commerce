<?php
/*
Swagger Library: https://transak.stoplight.io/docs/transak-docs/1.swagger.yaml
*/

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Plugin file.
 * 
 */
if ( ! defined( 'TRANSAK_PLUGIN_FILE' ) ) {
    define( 'TRANSAK_PLUGIN_FILE', __FILE__ );
}

/**
 * Defined Plugin ABSPATH
 * 
 */
if ( ! defined( 'TRANSAK_PLUGIN_PATH' ) ) {
    define( 'TRANSAK_PLUGIN_PATH', plugin_dir_path( TRANSAK_PLUGIN_FILE ) );
}

/**
 * Defined Plugin URL
 * 
 */
if ( ! defined( 'TRANSAK_PLUGIN_URL' ) ) {
    define( 'TRANSAK_PLUGIN_URL', plugin_dir_url( TRANSAK_PLUGIN_FILE ) );
}


/**
 * Defined plugin version
 * 
 */
if ( ! defined( 'TRANSAK_PLUGIN_VER' ) ) {
    define( 'TRANSAK_PLUGIN_VER', '1.0.0' );
}

/**
 * Define TRANSAK API URL
 * 
 */
if ( ! defined( 'TRANSAK_API_URL' ) ) {
    define( 'TRANSAK_API_URL', "http://5.32.84.74:3051" );
}

/**
 * Define TRANSAK API KEY
 * 
 */
if ( ! defined( 'TRANSAK_API_KEY' ) ) {
    //define( 'TRANSAK_API_KEY', get_option('transak_api_key') );
    define( 'TRANSAK_API_KEY', 'a673cda5-d044-4017-b4f0-9d1c4dc22ab6' );
}


/**
 * Define TRANSAK API SECRET
 * 
 */
if ( ! defined( 'TRANSAK_API_SECRET' ) ) {
    //define( 'TRANSAK_API_KEY', get_option('transak_api_secret') );
    define( 'TRANSAK_API_SECRET', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJBUElfS0VZIjoiYTY3M2NkYTUtZDA0NC00MDE3LWI0ZjAtOWQxYzRkYzIyYWI2IiwiaWF0IjoxNjA3NTc2MDc0fQ.Esw65MO-76xDt21ijvsmqNvIx1mEUvWodf8C7ArOiPM' );
}



// Load plugin with plugins_load
function transak_init() {
    require_once TRANSAK_PLUGIN_PATH . 'class-transak-init.php';
    
    $transak_init = new TRANSAK_Init;
    $transak_init->init();
}
add_action( 'plugins_loaded', 'transak_init', 20 );


function transak_registration_activation_init_callback(){
        require_once CFC_PLUGIN_PATH . 'class-registration-activation-init.php';
    }   
register_activation_hook( __FILE__, 'transak_registration_activation_init_callback' );   
?>