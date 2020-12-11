<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * TRANSAK_Webhook_Init class responsable to load all the scripts and styles.
 SITE_URL/wp-json/transak/v1/response
 */
class TRANSAK_Webhook_Init {

    public function __construct() {
        
        //$this->transak_check_woocommerce_is_active_callback();
        //$this->transak_settings_update_options_callback();
        //add_action( 'activated_plugin', array( $this, 'transak_redirect_on_activation_callback' ) );
        add_action( 'rest_api_init', array( $this, 'transak_register_example_routes' ) );

    }


   public function transak_get_transak_endpoint_phrase(){
        require_once TRANSAK_PLUGIN_PATH . 'public/php-jwt/src/SignatureInvalidException.php';
        require_once TRANSAK_PLUGIN_PATH . 'public/php-jwt/src/JWT.php';
        
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

            $existing_record = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}transak_transaction WHERE transaction_id = '".$externalTransactionId."'", ARRAY_A );
            
            if ( null == $existing_record ) {
                
                $wpdb->insert("{$wpdb->prefix}transak_transaction", array(
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
                    "{$wpdb->prefix}transak_transaction", 
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
        }
    }
    

    public function transak_register_example_routes() {
        register_rest_route( 'transak/v1', '/response', array(
        // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
        //'methods'  => WP_REST_Server::EDITABLE,
        'methods'  => WP_REST_Server::ALLMETHODS,
        'callback' => $this->transak_get_transak_endpoint_phrase(),
        ) );
    }

} // end of class TRANSAK_Webhook_Init

$transak_webhook_init = new TRANSAK_Webhook_Init;