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
* Text Domain: wc-wcl
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
function wcl_init() {
	$wcl_whatslink_active = 'yes';
	update_option('wcl_whatslink_active', $wcl_whatslink_active);	
	update_option('wcl_whatsapp_number_prefix_code', '123456789');	
	update_option('wcl_whatsapp_number', '123456789');	
	update_option('wcl_whatsapp_text', 'Hello, How are you?');	
	
	if(isset($_POST['activate_submit']) && !empty($_POST['wcl_activation_key'])){
		/*	
			remote put cost
			
			key : 672-130-699-743
			domain name 
			mac  = 38B1DBE349A9	
			unique_id = BFEBFBFF000306D4
			http://www.waam-it.com/api.php?a=Check&l={license}&m={mac_address}&p={unique_id}
			http://www.waam-it.com/api.php?a=Check&l=788-972-763-404&m=90B11C6F08F5&p=BFEBFBFF000206D7
			788-972-763-404
			90B11C6F08F5
			BFEBFBFF000206D7
			{	
		*/

		$wcl_whatslink_active = 'yes';
		update_option('wcl_whatslink_active', $wcl_whatslink_active);	
	}

	require_once WCL_PLUGIN_PATH . 'class-wcl-init.php';
    
    $wcl_init = new WCL_Init;
    $wcl_init->init();
}
add_action( 'plugins_loaded', 'wcl_init', 20 );


?>