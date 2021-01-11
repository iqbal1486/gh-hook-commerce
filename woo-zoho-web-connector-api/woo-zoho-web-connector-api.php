<?php

/*
	Plugin Name: WooCommerce Zoho Web Connector with Latest API
	Description: WooCommerce Zoho Web Connector with Latest API allow to synchronize WooCommerce modules with the ZOHO CRM. This plugin will do two way  synchronization. This plugin will synchronize data from your WooCommerce customers, products and orders to Zoho CRM accounts, leads, contacts, products, orders and invoices.
	Plugin URI: https://www.geekerhub.com
	Version: 1.0.0
	Author: Geekerhub
	Author URI: https://www.geekerhub.com
	WC requires at least: 2.5
	WC tested up to: 3.4.5
	License: GPLv2 or later
	Text Domain: gh-wc-zoho
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	if ( ! defined( 'GH_WC_ZOHO_CURRENT_USER_EMAIL' ) ) {

		define( 'GH_WC_ZOHO_CURRENT_USER_EMAIL', 'iqbal.brightnessgroup@gmail.com' );

	}


	if ( ! defined( 'GH_WC_ZOHO_GRANT_TOKEN' ) ) {

		define( 'GH_WC_ZOHO_GRANT_TOKEN', '1000.7bc3988993b614ba08bc65a5fd5af205.d053b5c70fce5ce34c4131edf1dd91b9' );

	}


	if ( ! defined( 'GH_WC_ZOHO_CLIENT_ID' ) ) {

		define( 'GH_WC_ZOHO_CLIENT_ID', '1000.TV4930GN38592N4NWCGSSMQGMJ4IGT' );

	}


	if ( ! defined( 'GH_WC_ZOHO_CLIENT_SECRET' ) ) {

		define( 'GH_WC_ZOHO_CLIENT_SECRET', '3702fbbed21e1f4c30308385a5d363265e48575b97' );

	}


	if ( ! defined( 'GH_WC_ZOHO_REDIRECT_URL' ) ) {

		define( 'GH_WC_ZOHO_REDIRECT_URL', home_url('wc-api/gh_wc_zoho_auth')  );

	}



	if ( ! defined( 'GH_WC_ZOHO_ABSPATH' ) ) {

		define( 'GH_WC_ZOHO_ABSPATH', dirname( __FILE__ ) . '/' );

	}



	if ( ! defined( 'GH_WC_ZOHO_PLUGIN_PATH' ) ) {

		define( 'GH_WC_ZOHO_PLUGIN_PATH', __FILE__ );

	}


	// Add custom action links
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wc_zohocrm_action_link_callback' );
	
	function wc_zohocrm_action_link_callback( $links ) {
		$plugin_links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=wc_zohocrm_settings' ) . '">' . __( 'Settings', 'wc-zohocrm-integration' ) . '</a>',
		);

		// Merge our new link with the default ones
		return array_merge( $plugin_links, $links );	
	}

	//require_once GH_WC_ZOHO_ABSPATH.'includes/vendor/autoload.php';

	//require_once GH_WC_ZOHO_ABSPATH.'includes/class.initialize.php';

	//require_once GH_WC_ZOHO_ABSPATH.'includes/class.init.php';
	
}

