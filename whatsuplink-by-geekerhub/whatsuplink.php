<?php
/*
* Plugin Name: WAAM-it WhatsLink
* Description: The user inserts a phone number and desired text, the plugin creates two different bit.ly shortened WhatApp links and shows the corresponding link depends on the screen resolution or desktop/mobile device.
* Plugin URI:  http://www.geekerhub.com/
* Author:      NisarAhmed Momin
* Author URI:  http://www.geekerhub.com/
* Version:     1.0.0
* License:     GPL2
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wc-gh
* Domain Path: languages
*/

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Plugin file.
 * 
 */
if ( ! defined( 'WCL_PLUGIN_FILE' ) ) {
    define( 'WCL_PLUGIN_FILE', __FILE__ );
}

/**
 * Defined Plugin ABSPATH
 * 
 */
if ( ! defined( 'WCL_PLUGIN_PATH' ) ) {
    define( 'WCL_PLUGIN_PATH', plugin_dir_path( WCL_PLUGIN_FILE ) );
}

/**
 * Defined Plugin URL
 * 
 */
if ( ! defined( 'WCL_PLUGIN_URL' ) ) {
    define( 'WCL_PLUGIN_URL', plugin_dir_url( WCL_PLUGIN_FILE ) );
}

/**
 * Defined plugin version
 * 
 */
if ( ! defined( 'WCL_PLUGIN_VER' ) ) {
    define( 'WCL_PLUGIN_VER', '1.0.0' );
}


/**
 * Defined Bitly API URL
 * 
 */
if ( ! defined( 'BITLY_API_URL' ) ) {
	define('BITLY_API_URL','https://api-ssl.bitly.com/v3/shorten');
}

// Load plugin with plugins_load
function gh_init() {
	require_once WCL_PLUGIN_PATH . 'class-gh-init.php';
    
    $gh_init = new WCL_Init;
    $gh_init->init();
}
add_action( 'plugins_loaded', 'gh_init', 20 );


?>