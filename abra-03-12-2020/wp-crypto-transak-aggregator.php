<?php
/*
* Plugin Name: Crypto Transak Aggregrator
* Description: Abra Buy Sell Crypto currency using Transak
* Plugin URI:  https://www.test.com/
* Author:      Test Here
* Author URI:  https://www.test.com/
* Version:     1.0.0
* Text Domain: wp-crypto
* Domain Path: languages
*/

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );
global $table_prefix, $wpdb, $get_payment_method_label, $banxa_payment_method_widget_mapping;
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
 * Defined TRANSAK_REDIRECT_URL
 * 
 */
if ( ! defined( 'TRANSAK_REDIRECT_URL' ) ) {
    define( 'TRANSAK_REDIRECT_URL', get_option('transak_redirect_url') );
}


/**
 * Defined Transak API Key
 * 
 */
if ( ! defined( 'TRANSAK_API_KEY' ) ) {
    if(get_option('transak_live') == "yes"){
        define( 'TRANSAK_API_KEY', get_option('transak_live_api_key') );
    }else{
        define( 'TRANSAK_API_KEY', get_option('transak_test_api_key') );
    }
}


/**
 * Defined Transak API Secret
 * 
 */
if ( ! defined( 'TRANSAK_API_SECRET' ) ) {
    if(get_option('transak_live') == "yes"){
        define( 'TRANSAK_API_SECRET', get_option('transak_live_api_secret') );
    }else{
        define( 'TRANSAK_API_SECRET', get_option('transak_test_api_secret') );
    }
}

/**
 * Defined Transak Currency API
 * 
 */
if ( ! defined( 'TRANSAK_CURRENCY_API' ) ) {
    if(get_option('transak_live') == "yes"){
        define( 'TRANSAK_CURRENCY_API', 'https://api.transak.com/api/v2/currencies/price' );
    }else{
        define( 'TRANSAK_CURRENCY_API', 'https://staging-api.transak.com/api/v2/currencies/price' );
    }
}


/**
 * Defined Transak Currency API
 * 
 */
if ( ! defined( 'TRANSAK_THIRD_PARTY_PAGE' ) ) {
    if(get_option('transak_live') == "yes"){
        define( 'TRANSAK_THIRD_PARTY_PAGE', 'https://global.transak.com/' );
    }else{
        define( 'TRANSAK_THIRD_PARTY_PAGE', 'https://staging-global.transak.com/' );
    }
}


/**
 * Defined Default Currency
 * 
 */
if ( ! defined( 'TRANSAK_DEFAULT_CURRENCY' ) ) {
    define( 'TRANSAK_DEFAULT_CURRENCY', 'usd' );
}


/**
 * Defined Default Currency
 * 
 */
if ( ! defined( 'TRANSAK_DEFAULT_CRYPTO_CURRENCY' ) ) {
    define( 'TRANSAK_DEFAULT_CRYPTO_CURRENCY', 'btc' );
}


/**
 * Defined Default Country
 * 
 */
if ( ! defined( 'TRANSAK_DEFAULT_COUNTRY' ) ) {
    define( 'TRANSAK_DEFAULT_COUNTRY', 'US' );
}


/**
 * Defined Term URL
 * 
 */
if ( ! defined( 'TRANSAK_TERMS_URL' ) ) {
    define( 'TRANSAK_TERMS_URL', get_option('transak_terms_url') );
}

/**
 * Defined Privacy URL
 * 
 */
if ( ! defined( 'TRANSAK_PRIVACY_URL' ) ) {
    define( 'TRANSAK_PRIVACY_URL', get_option('transak_privacy_url') );
}

/**
 * Defined KYC URL
 * 
 */
if ( ! defined( 'TRANSAK_KYC_URL' ) ) {
    define( 'TRANSAK_KYC_URL', get_option('transak_kyc_url') );
}


/**
 * Defined plugin version
 * 
 */
if ( ! defined( 'TRANSAK_PLUGIN_VER' ) ) {
    define( 'TRANSAK_PLUGIN_VER', '1.0.0' );
}


if ( ! defined( 'TRANSAK_TABLE_TRANSACTION' ) ) {
        define( 'TRANSAK_TABLE_TRANSACTION', $table_prefix . "transak_transaction" );
    }

    if ( ! defined( 'TRANSAK_TABLE_COUNTRIES_LIST' ) ) {
        define( 'TRANSAK_TABLE_COUNTRIES_LIST', $table_prefix . "transak_countries_list" );
    }

    if ( ! defined( 'TRANSAK_TABLE_FIAT_CURRENCIES' ) ) {
        define( 'TRANSAK_TABLE_FIAT_CURRENCIES', $table_prefix . "transak_fiat_currency" );
    }

    if ( ! defined( 'TRANSAK_TABLE_CRYPTO_CURRENCIES' ) ) {
        define( 'TRANSAK_TABLE_CRYPTO_CURRENCIES', $table_prefix . "transak_crypto_currency" );
    }

    if ( ! defined( 'TRANSAK_TABLE_PAYMENT_METHOD' ) ) {
        define( 'TRANSAK_TABLE_PAYMENT_METHOD', $table_prefix . "transak_payment_method" );
    }


$get_payment_method_label  = array(
                                    'visa'          => "Visa",
                                    'mastercard'    => "Master Card",
                                    'banktransfer'  => "Bank Transfer",
                                    'applepay'      => "Apple Pay (Safari)",
                                    'sepa'          => "Sepa",
                                    'fasterPay'     => "Faster Pay",
                                    'upi'           => "UPI",
                                    'Klarna'        => "Klarna",
                                    'Newsagent'     => "Newsagent",
                                    'NewsAgent'     => "NewsAgent",
                                    'iDEAL'        => "iDEAL",
                                    'Interac'        => "Interac",
                                    'Australia Post' => "Australia Post",
                                    'POLI'          => "POLI",
                                    'samsungpay'    => "Samsung Pay",
                                    'PayID'         => "PayID",
                                    'BPAY'          => "BPAY",
                                    'imps'          => "IMPS",
                                );
   
// Load plugin with plugins_load
function transak_init() {
    global $wpdb, $table_prefix, $get_fiat_currencies, $get_crypto_currencies, $get_list_countries, $get_payment_method;
    $get_list_countries = $wpdb->get_results( "SELECT * FROM ".TRANSAK_TABLE_COUNTRIES_LIST." ORDER BY `country_name`", ARRAY_A);
    $get_fiat_currencies = $wpdb->get_results( "SELECT * FROM ".TRANSAK_TABLE_FIAT_CURRENCIES." ORDER BY `iso_code`", ARRAY_A);
    $get_crypto_currencies = $wpdb->get_results( "SELECT * FROM ".TRANSAK_TABLE_CRYPTO_CURRENCIES." ORDER BY `ticker_symbol`", ARRAY_A);
    
    require_once TRANSAK_PLUGIN_PATH . 'class-transak-init.php';
    $transak_init = new TRANSAK_Init;
    $transak_init->init();
}
add_action( 'plugins_loaded', 'transak_init', 20 );

function transak_plugin_activation_process_callback(){
    require_once TRANSAK_PLUGIN_PATH . 'class-registration-activation-init.php';
}

register_activation_hook( __FILE__, 'transak_plugin_activation_process_callback' );

function sess_start() {
    if (!session_id())
    session_start();
}
add_action('init','sess_start');
?>