<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * TRANSAK_Registration_Activation_Init class responsable to load all the scripts and styles.
 */
class TRANSAK_Registration_Activation_Init {

    public function __construct() {
        
        $this->transak_check_woocommerce_is_active_callback();
        //$this->transak_settings_update_options_callback();
        //add_action( 'activated_plugin', array( $this, 'transak_redirect_on_activation_callback' ) );

    }


    /*
    * Check woocommerce is active or not.
    */
    public function transak_check_woocommerce_is_active_callback(){
        
        
        global $wpdb;
        if($wpdb->get_var( "show tables like '".TRANSAK_TABLE_TRANSACTION."'" ) != TRANSAK_TABLE_TRANSACTION) {

            $sql = "CREATE TABLE ".TRANSAK_TABLE_TRANSACTION." (
                      `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                      `customer_id` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `transaction_id` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `payment_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
                      `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                      `wallet_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
                      `country_code` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `currency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `crypto_currency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `amount` float NOT NULL,
                      `cryptoAmount` float NOT NULL,
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

        /*Creating Country Table on Plugin Activation*/
        
        if($wpdb->get_var( "show tables like '".TRANSAK_TABLE_COUNTRIES_LIST."'" ) != TRANSAK_TABLE_COUNTRIES_LIST) {

            $sql = "CREATE TABLE ".TRANSAK_TABLE_COUNTRIES_LIST." (
                      `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                      `alpha2` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `alpha3` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `currency_code` varchar(10) NOT NULL DEFAULT 'no',
                      `country_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                      PRIMARY KEY (`ID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }


        /*Creating Fiat Currency Table on Plugin Activation*/
         $transak_fiat_currency_table = TRANSAK_TABLE_FIAT_CURRENCIES;

        if($wpdb->get_var( "show tables like '$transak_fiat_currency_table'" ) != $transak_fiat_currency_table) {

            $sql = "CREATE TABLE $transak_fiat_currency_table (
                      `ID` bigint(20) NOT NULL AUTO_INCREMENT,
                      `currency` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `iso_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                      `transak_supported` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
                      PRIMARY KEY (`ID`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

            require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }


        /*Creating Crypto Currency Table on Plugin Activation*/
        $transak_crypto_currency_table = TRANSAK_TABLE_CRYPTO_CURRENCIES;

        if($wpdb->get_var( "show tables like '".TRANSAK_TABLE_CRYPTO_CURRENCIES."'" ) != TRANSAK_TABLE_CRYPTO_CURRENCIES ) {

            $sql = "CREATE TABLE ".TRANSAK_TABLE_CRYPTO_CURRENCIES." (
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
            
                    $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM ".TRANSAK_TABLE_CRYPTO_CURRENCIES." WHERE ticker_symbol = '$code' ");

                    if($rowcount > 0){
                        $wpdb->update( 
                            TRANSAK_TABLE_CRYPTO_CURRENCIES,
                            array( 
                                'transak_supported' => 'yes',
                            ), 
                            array( 'ticker_symbol'     => $code ), 
                            array( '%s' ), 
                            array( '%s' ) 
                        );
                    }else{
                        $wpdb->insert(
                        TRANSAK_TABLE_CRYPTO_CURRENCIES,
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
                    
                    $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM $transak_fiat_currency_table WHERE iso_code = '$code' ");

                    if($rowcount > 0){
                        $wpdb->update( 
                            $transak_fiat_currency_table,
                            array( 
                                'transak_supported' => 'yes',
                            ), 
                            array( 'iso_code'     => $code ), 
                            array( '%s' ), 
                            array( '%s' ) 
                        );
                    }else{
                        $wpdb->insert(
                        $transak_fiat_currency_table,
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
                
                $rowcount = $wpdb->get_var("SELECT COUNT(*) FROM ".TRANSAK_TABLE_COUNTRIES_LIST." WHERE alpha2 = '$alpha2' ");
            
                if($rowcount > 0){
                    $wpdb->update( 
                        TRANSAK_TABLE_COUNTRIES_LIST,
                        array( 
                            'transak_supported' => 'yes',
                        ), 
                        array( 'alpha2'     => $alpha2 ), 
                        array( '%s' ), 
                        array( '%s' ) 
                    );
                }else{
                    $wpdb->insert(
                    TRANSAK_TABLE_COUNTRIES_LIST,
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