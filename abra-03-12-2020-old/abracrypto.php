<?php
/*
* Plugin Name: Abra Crypto Payment Integrator
* Description: Abra Buy Sell Crypto currency using different payment providers
* Plugin URI:  https://www.abra.com/
* Author:      Demansol Tech. Pvt Ltd
* Author URI:  https://www.demansol.com/
* Version:     1.0.0
* Text Domain: wc-abrac
* Domain Path: languages
*/

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );
global $simplex_crypto_currencies_array, $simplex_fiat_currencies_array, $payment_method_array, $simplex_state_list_array, $simplex_not_supported_countries_array, $simplex_not_supported_state_list_array, $get_payment_method_label, $delist_countries, $banxa_payment_method_widget_mapping, $transak_crypto_suppoted_countries;
/**
 * Plugin file.
 * 
 */
if ( ! defined( 'ABRAC_PLUGIN_FILE' ) ) {
    define( 'ABRAC_PLUGIN_FILE', __FILE__ );
}

/**
 * Defined Plugin ABSPATH
 * 
 */
if ( ! defined( 'ABRAC_PLUGIN_PATH' ) ) {
    define( 'ABRAC_PLUGIN_PATH', plugin_dir_path( ABRAC_PLUGIN_FILE ) );
}

/**
 * Defined Plugin URL
 * 
 */
if ( ! defined( 'ABRAC_PLUGIN_URL' ) ) {
    define( 'ABRAC_PLUGIN_URL', plugin_dir_url( ABRAC_PLUGIN_FILE ) );
}

/**
 * Defined ABRAC_REMOVE_ALL_DATA to true to remove all data on uninstallation
 * 
 */
if ( ! defined( 'ABRAC_REMOVE_ALL_DATA' ) ) {
    define( 'ABRAC_REMOVE_ALL_DATA', true );
}




/**
 * Defined ABRAC_REDIRECT_URL
 * 
 */
if ( ! defined( 'ABRAC_REDIRECT_URL' ) ) {
    define( 'ABRAC_REDIRECT_URL', get_option('abrac_redirect_url') );
}



/**
 * Defined Transak API Key
 * 
 */
if ( ! defined( 'ABRAC_TRANSAK_API_KEY' ) ) {
    if(get_option('abrac_live') == "yes"){
        define( 'ABRAC_TRANSAK_API_KEY', get_option('abrac_transak_live_api_key') );
    }else{
        define( 'ABRAC_TRANSAK_API_KEY', get_option('abrac_transak_test_api_key') );
    }
}


/**
 * Defined Transak API Secret
 * 
 */
if ( ! defined( 'ABRAC_TRANSAK_API_SECRET' ) ) {
    if(get_option('abrac_live') == "yes"){
        define( 'ABRAC_TRANSAK_API_SECRET', get_option('abrac_transak_live_api_secret') );
    }else{
        define( 'ABRAC_TRANSAK_API_SECRET', get_option('abrac_transak_test_api_secret') );
    }
}

/**
 * Defined Transak Currency API
 * 
 */
if ( ! defined( 'ABRAC_TRANSAK_CURRENCY_API' ) ) {
    if(get_option('abrac_live') == "yes"){
        define( 'ABRAC_TRANSAK_CURRENCY_API', 'https://api.transak.com/api/v2/currencies/price' );
    }else{
        define( 'ABRAC_TRANSAK_CURRENCY_API', 'https://staging-api.transak.com/api/v2/currencies/price' );
    }
}


/**
 * Defined Transak Currency API
 * 
 */
if ( ! defined( 'TRANSAK_THIRD_PARTY_PAGE' ) ) {
    if(get_option('abrac_live') == "yes"){
        define( 'TRANSAK_THIRD_PARTY_PAGE', 'https://global.transak.com/' );
    }else{
        define( 'TRANSAK_THIRD_PARTY_PAGE', 'https://staging-global.transak.com/' );
    }
}


/**
 * Defined Default Currency
 * 
 */
if ( ! defined( 'ABRAC_DEFAULT_CURRENCY' ) ) {
    define( 'ABRAC_DEFAULT_CURRENCY', 'usd' );
}


/**
 * Defined Default Currency
 * 
 */
if ( ! defined( 'ABRAC_DEFAULT_CRYPTO_CURRENCY' ) ) {
    define( 'ABRAC_DEFAULT_CRYPTO_CURRENCY', 'btc' );
}


/**
 * Defined Default Country
 * 
 */
if ( ! defined( 'ABRAC_DEFAULT_COUNTRY' ) ) {
    define( 'ABRAC_DEFAULT_COUNTRY', 'US' );
}


/**
 * Defined Term URL
 * 
 */
if ( ! defined( 'ABRAC_TERMS_URL' ) ) {
    define( 'ABRAC_TERMS_URL', get_option('abrac_terms_url') );
}

/**
 * Defined Privacy URL
 * 
 */
if ( ! defined( 'ABRAC_PRIVACY_URL' ) ) {
    define( 'ABRAC_PRIVACY_URL', get_option('abrac_privacy_url') );
}

/**
 * Defined KYC URL
 * 
 */
if ( ! defined( 'ABRAC_KYC_URL' ) ) {
    define( 'ABRAC_KYC_URL', get_option('abrac_kyc_url') );
}


/**
 * Defined plugin version
 * 
 */
if ( ! defined( 'ABRAC_PLUGIN_VER' ) ) {
    define( 'ABRAC_PLUGIN_VER', '1.0.0' );
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
function abrac_init() {
    global $wpdb, $table_prefix, $get_fiat_currencies, $get_crypto_currencies, $get_list_countries, $get_payment_method, $get_States_list;

    $abra_countries_list_table  = $table_prefix . "abra_countries_list";

    $abra_fiat_currency_table   = $table_prefix . "abra_fiat_currency";

    $abra_crypto_currency_table = $table_prefix . "abra_crypto_currency";

    $abra_payment_method_table  = $table_prefix . "abra_payment_method";

    $abra_state_list_table      = $table_prefix . "abra_state_list";

    $get_list_countries         = $wpdb->get_results( "SELECT * FROM ".$abra_countries_list_table." ORDER BY `country_name`", ARRAY_A);
    
    $get_fiat_currencies        = $wpdb->get_results( "SELECT * FROM ".$abra_fiat_currency_table." ORDER BY `iso_code`", ARRAY_A);
    
    $get_crypto_currencies      = $wpdb->get_results( "SELECT * FROM ".$abra_crypto_currency_table." ORDER BY `ticker_symbol`", ARRAY_A);

    $get_payment_method         = $wpdb->get_results( "SELECT * FROM ".$abra_payment_method_table, ARRAY_A);
    
    $get_States_list            = $wpdb->get_results( "SELECT * FROM ".$abra_state_list_table." ORDER BY `alpha2`", ARRAY_A);


    require_once ABRAC_PLUGIN_PATH . 'class-abrac-init.php';
    $abrac_init = new ABRAC_Init;
    $abrac_init->init();

    
}
add_action( 'plugins_loaded', 'abrac_init', 20 );



/**
 * This is our callback function that embeds our phrase in a WP_REST_Response
 * SITE_URL/wp-json/transak/v1/response
 */

function abrac_get_transak_endpoint_phrase(){
    require_once ABRAC_PLUGIN_PATH . 'public/php-jwt/src/SignatureInvalidException.php';
    require_once ABRAC_PLUGIN_PATH . 'public/php-jwt/src/JWT.php';
    
    $headers = getallheaders();
        
    $json_string = file_get_contents('php://input');
    $json_string = json_decode($json_string, true);

    if(!empty($json_string['data'])){
        global $table_prefix, $wpdb;
                
        $tks = explode('.', $json_string['data']);       
        list($headb64, $bodyb64, $cryptob64) = $tks;

        $bodydecrypted          = \Firebase\JWT\JWT::jsonDecode(Firebase\JWT\JWT::urlsafeB64Decode($bodyb64));
        $webhookData            = $bodydecrypted->webhookData;
        $id                     = $webhookData->id;
        $walletAddress          = $webhookData->walletAddress;
        $status                 = $webhookData->status;
        $baseCurrencyCode       = strtolower($webhookData->fiatCurrency);
        $defaultCurrencyCode    = strtolower($webhookData->cryptoCurrency);
        $externalTransactionId  = $webhookData->partnerOrderId;
        $externalCustomerId     = $webhookData->partnerCustomerId;
        $baseCurrencyAmount     = $webhookData->fiatAmount;
        $crypto_currency_amount = $webhookData->cryptoAmount;

        $ip  = "";

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip = $_SERVER['REMOTE_ADDR'];
        }    

        $existing_record = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}abra_transaction WHERE transaction_id = '".$externalTransactionId."'", ARRAY_A );
        
        if ( null == $existing_record ) {
            
            $wpdb->insert("{$wpdb->prefix}abra_transaction", array(
                'customer_id'       => $externalCustomerId,
                'transaction_id'    => $externalTransactionId,
                'currency'          => $baseCurrencyCode,
                'crypto_currency'   => $defaultCurrencyCode,
                'amount'            => $baseCurrencyAmount,
                'crypto_currency_amount' => $crypto_currency_amount,
                'provider_name'     => 'transak',
                'raw_data'          => maybe_serialize($bodydecrypted),
                'user_agent'        => $_SERVER['HTTP_USER_AGENT'],
                'webhook_status'    => $status,
                'ip_address'        => $ip,
            ));
            
        }else{
            
            $wpdb->update(
                "{$wpdb->prefix}abra_transaction", 
                array( 
                    'customer_id'       => $externalCustomerId,
                    'currency'          => $baseCurrencyCode,
                    'crypto_currency'   => $defaultCurrencyCode,
                    'amount'            => $baseCurrencyAmount,
                    'provider_name'     => 'transak',
                    'webhook_status'    => $status,
                    'raw_data'          => maybe_serialize($bodydecrypted),
                ), 
                array( 'transaction_id' => $externalTransactionId ), 
                array( 
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s',
                    '%s'
                ), 
                array( '%s' ) 
            );    
        }
        /*
        $msg = "";
        $msg .= $id."<br>";
        $msg .= $walletAddress."<br>";
        $msg .= $status."<br>";
        $msg .= $fiatCurrency."<br>";
        $msg .= $cryptoCurrency."<br>";
        $msg .= $partnerOrderId."<br>";
        $msg .= $partnerCustomerId."<br>";
        $msg .= $fiatAmount."<br>";
        $msg .= $cryptoAmount."<br>";

        $msg .= print_r($bodydecrypted, true);
        $msg .= print_r($headers, true);
        $msg .= print_r($json_string, true);

        mail("iahmed964@gmail.com","Transak WEbhook",$msg);    
        */
    }
}
 
/**
 * This function is where we register our routes for our example endpoint.
 */
function abrac_register_example_routes() {
    // register_rest_route() handles more arguments but we are going to stick to the basics for now.
    register_rest_route( 'transak/v1', '/response', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        //'methods'  => WP_REST_Server::EDITABLE,
        'methods'  => WP_REST_Server::ALLMETHODS,
        // Here we register our callback. The callback is fired when this endpoint is matched by the WP_REST_Server class.
        'callback' => 'abrac_get_transak_endpoint_phrase',
    ) );
}
 
add_action( 'rest_api_init', 'abrac_register_example_routes' );


function abrac_create_database_table(){
    global $table_prefix, $wpdb, $simplex_fiat_currencies_array, $simplex_crypto_currencies_array, $payment_method_array, $simplex_state_list_array, $simplex_not_supported_countries_array, $simplex_not_supported_state_list_array;

    $table_name = 'abra_transaction';
    $abra_transaction_table = $table_prefix . "$table_name";

    if($wpdb->get_var( "show tables like '$abra_transaction_table'" ) != $abra_transaction_table) {

        $sql = "CREATE TABLE $abra_transaction_table (
                  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                  `customer_id` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `transaction_id` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
                  `country_code` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `currency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `crypto_currency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `amount` float NOT NULL,
                  `crypto_currency_amount` float NOT NULL,
                  `provider_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `raw_data` text COLLATE utf8mb4_unicode_ci NOT NULL,
                  `user_agent` varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `ip_address` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `webhook_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_received',
                  `transaction_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    }

     /** 
     * Snippet Name: Alter WordPress sql tables: add a new column 
     */  
    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$abra_transaction_table."' AND column_name = 'payment_id'"  );  
  
    if(empty($row)){
       $wpdb->query("ALTER TABLE $abra_transaction_table ADD payment_id varchar(255) NOT NULL DEFAULT '0'");  
    } 

    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$abra_transaction_table."' AND column_name = 'wallet_address'"  );  
  
    if(empty($row)){
       $wpdb->query("ALTER TABLE $abra_transaction_table ADD wallet_address varchar(255) NOT NULL DEFAULT '0'");  
    }

    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$abra_transaction_table."' AND column_name = 'payment_method'"  );  
  
    if(empty($row)){
       $wpdb->query("ALTER TABLE $abra_transaction_table ADD payment_method varchar(255) NOT NULL DEFAULT ''");  
    } 

    /*Creating Country Table on Plugin Activation*/
    $table_name = 'abra_countries_list';
    $abra_countries_list_table = $table_prefix . "$table_name";

    if($wpdb->get_var( "show tables like '$abra_countries_list_table'" ) != $abra_countries_list_table) {

        $sql = "CREATE TABLE $abra_countries_list_table (
                  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                  `alpha2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `alpha3` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `country_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    /**
    * Add currency_code column
    */
    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$abra_countries_list_table."' AND column_name = 'currency_code'"  );  
  
    if(empty($row)){
       $wpdb->query("ALTER TABLE $abra_countries_list_table ADD currency_code varchar(10) NOT NULL DEFAULT 'no'");  
    }


    /*Creating Fiat Currency Table on Plugin Activation*/
    $table_name = 'abra_fiat_currency';
    $abra_fiat_currency_table = $table_prefix . "$table_name";

    if($wpdb->get_var( "show tables like '$abra_fiat_currency_table'" ) != $abra_fiat_currency_table) {

        $sql = "CREATE TABLE $abra_fiat_currency_table (
                  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                  `currency` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `iso_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    /** 
     * Snippet Name: Alter WordPress sql tables: add a new column 
     */  
    $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$abra_fiat_currency_table."' AND column_name = 'transak_supported'"  );  
  
    if(empty($row)){
       $wpdb->query("ALTER TABLE $abra_fiat_currency_table ADD transak_supported varchar(10) NOT NULL DEFAULT 'no'");  
    }



    /*Creating Crypto Currency Table on Plugin Activation*/
    $table_name = 'abra_crypto_currency';
    $abra_crypto_currency_table = $table_prefix . "$table_name";

    if($wpdb->get_var( "show tables like '$abra_crypto_currency_table'" ) != $abra_crypto_currency_table) {

        $sql = "CREATE TABLE $abra_crypto_currency_table (
                  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                  `currency` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `ticker_symbol` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `network` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }


    /*Creating State List Table on Plugin Activation*/
    $table_name = 'abra_state_list';
    $abra_state_list_table = $table_prefix . "$table_name";

    if($wpdb->get_var( "show tables like '$abra_state_list_table'" ) != $abra_state_list_table) {

        $sql = "CREATE TABLE $abra_state_list_table (
                  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                  `alpha2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `alpha3` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                  `state_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `country_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                  `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                  PRIMARY KEY (`ID`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }

    /*Fetch and Insert crypto Currencies from Trasak*/
    $apiUrl         = 'https://staging-api.transak.com/api/v2/currencies/crypto-currencies';
    $response       = wp_remote_get($apiUrl);
    $responseBody   = wp_remote_retrieve_body( $response );
    $result         = json_decode( $responseBody );
    
    if (  $result  && ! is_wp_error( $result ) ) {
        $get_list_currencies = $result->response;
        if($get_list_currencies){
            foreach ($get_list_currencies as $key => $value) {
                $selected = "";
                $code = $value->symbol;
                $name = $value->name;
                $code = strtolower($code);
                $network        = $value->network;
                $networkName    = $network->name; 
        
                $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $abra_crypto_currency_table WHERE ticker_symbol = '$code' ");

                if($rowcount > 0){
                    $wpdb->update( 
                        $abra_crypto_currency_table,
                        array( 
                            'transak_supported' => 'yes',
                        ), 
                        array( 'ticker_symbol'     => $code ), 
                        array( '%s' ), 
                        array( '%s' ) 
                    );
                }else{
                    $wpdb->insert(
                    $abra_crypto_currency_table,
                        array(
                            'currency'          => $name,
                            'ticker_symbol'     => $code,
                            'network'           => ucfirst($networkName),    
                            'transak_supported' => 'yes',
                        ),
                        array(
                            '%s',
                            '%s',
                            '%s',
                            '%s'
                        )
                    );
                }
                
            }
        }
    }




    /*Fetch and Insert fiat Currencies from Trasak*/
    $apiUrl         = 'https://staging-api.transak.com/api/v2/currencies/fiat-currencies';
    $response       = wp_remote_get($apiUrl);
    $responseBody   = wp_remote_retrieve_body( $response );
    $result         = json_decode( $responseBody );
    
    if (  $result  && ! is_wp_error( $result ) ) {
        $get_list_currencies = $result->response;
        if($get_list_currencies){
            foreach ($get_list_currencies as $key => $value) {
                $selected = "";
                $code = $value->symbol;
                $name = $value->name;
                $code = strtolower($code);
                
                $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $abra_fiat_currency_table WHERE iso_code = '$code' ");

                if($rowcount > 0){
                    $wpdb->update( 
                        $abra_fiat_currency_table,
                        array( 
                            'transak_supported' => 'yes',
                        ), 
                        array( 'iso_code'     => $code ), 
                        array( '%s' ), 
                        array( '%s' ) 
                    );
                }else{
                    $wpdb->insert(
                    $abra_fiat_currency_table,
                        array(
                            'currency'          => $name,
                            'iso_code'          => $code,
                            'transak_supported'  => 'yes',
                        ),
                        array(
                            '%s',
                            '%s',
                            '%s',
                            '%s'
                        )
                    );
                }
            }
        }
    }

    /*Fetch and Insert Countries from trasak API*/
    $apiUrl         = 'https://staging-api.transak.com/api/v2/countries';
    $response       = wp_remote_get($apiUrl);
    $responseBody   = wp_remote_retrieve_body( $response );
    $result         = json_decode( $responseBody );
    
    if (  $result  && ! is_wp_error( $result ) ) {
        $get_list_countries = $result->response;
        foreach ($get_list_countries as $key => $value) {
            $alpha2     = $value->alpha2;
            $alpha3     = $value->alpha3;
            $name       = $value->name;
            
            $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $abra_countries_list_table WHERE alpha2 = '$alpha2' ");
        
            if($rowcount > 0){
                $wpdb->update( 
                    $abra_countries_list_table,
                    array( 
                        'transak_supported' => 'yes',
                    ), 
                    array( 'alpha2'     => $alpha2 ), 
                    array( '%s' ), 
                    array( '%s' ) 
                );
            }else{
                $wpdb->insert(
                $abra_countries_list_table,
                    array(
                        'alpha2'            => $alpha2,
                        'alpha3'            => $alpha3,
                        'country_name'      => $name,
                        'transak_supported' => 'yes',
                    ),
                    array(
                        '%s',
                        '%s',
                        '%s',
                        '%s'
                    )
                );
            }
        }
    }
  
}

register_activation_hook( __FILE__, 'abrac_create_database_table' );




function slugify($text){
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}


function custom_http_request_timeout( ) {
    return 25;
}
add_filter( 'http_request_timeout', 'custom_http_request_timeout' );

function array_flatten($array) { 
  if (!is_array($array)) { 
    return FALSE; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } 
    else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
}

function sess_start() {
    if (!session_id())
    session_start();
}
add_action('init','sess_start');
?>