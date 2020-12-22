<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class TRANSAK_Front_Form_Shortcode {

    public function __construct() {
       
       /*This is disable now*/
        add_action( 'init', array( $this, 'moonpay_insert_update_callback_from_listing_page' ) );
        add_shortcode( 'transak_conversion_form', array( $this, 'display_front_form_callback' ) );
    }

    public function moonpay_insert_update_callback_from_listing_page(){
        if(isset($_GET['externalTransactionId']) && wp_verify_nonce($_GET['transak_buy_now'], 'transak-buy-now')) {
                global $table_prefix, $wpdb;

                $externalTransactionId  = $_GET['externalTransactionId'];
                $externalCustomerId     = $_GET['externalCustomerId'];
                $fiatAmount             = $_GET['fiatAmount'];
                $cryptoAmount           = $_GET['cryptoAmount'];

                $baseCurrencyCode       = $_GET['baseCurrencyCode'];
                $defaultCurrencyCode    = $_GET['defaultCurrencyCode'];
                $countryValue           = $_GET['countryValue'];
                $provider_name          = $_GET['provider_name'];
                $paymentmethod          = $_GET['paymentmethod'];
                
                $ip                     = "";

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
                        'country_code'      => $countryValue,    
                        'amount'            => $fiatAmount,
                        'cryptoAmount'      => $cryptoAmount,
                        'provider_name'     => $provider_name,
                        'raw_data'          => maybe_serialize($_GET),
                        'user_agent'        => $_SERVER['HTTP_USER_AGENT'],
                        'ip_address'        => $ip,
                        'payment_method'    => $paymentmethod,

                    ));
                    
                }else{
                    

                    /*Update Query*/
                    $wpdb->update( 
                        "{$wpdb->prefix}transak_transaction", 
                        array( 
                            'currency'          => $baseCurrencyCode,
                            'crypto_currency'   => $defaultCurrencyCode,
                            'country_code'      => $countryValue,    
                            'amount'            => $fiatAmount,
                            'cryptoAmount'      => $cryptoAmount,
                            'provider_name'     => $provider_name,
                            'payment_method'    => $paymentmethod,
                            'raw_data'          => maybe_serialize($_GET),
                            'user_agent'        => $_SERVER['HTTP_USER_AGENT'],
                            'ip_address'        => $ip,
                        ), 
                        array( 'transaction_id' => $externalTransactionId ), 
                        array( 
                            '%s',
                            '%s',
                            '%s',
                            '%s',
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

                if($provider_name == "transak"){

                    $walletAddress = $_GET['transak_wallet_address'];
                    $paymentmethod = $_GET['paymentmethod'];

                    /*Update Query for wallet address*/
                    $wpdb->update( 
                        "{$wpdb->prefix}transak_transaction", 
                        array( 
                            'wallet_address'     => $walletAddress,
                        ), 
                        array( 'transaction_id' => $externalTransactionId ), 
                        array( 
                            '%s'
                        ), 
                        array( '%s' ) 
                    );


                    $transak_payment_method_mapping = array(
                                                    'sepa'      => 'sepa_bank_transfer',
                                                    'upi'       => 'neft_bank_transfer',
                                                    'imps'      => 'neft_bank_transfer',
                                                    'fasterPay' => 'gbp_bank_transfer',
                                                    'visa'      => 'credit_debit_card',
                                                    'mastercard' => 'credit_debit_card',
                                                    'applepay'  => 'credit_debit_card'
                                                );
                    $data = array(
                        'apiKey'                    => TRANSAK_API_KEY,
                        'defaultFiatAmount'         => $fiatAmount,
                        'fiatCurrency'              => strtoupper($baseCurrencyCode),
                        'defaultCryptoAmount' 		=> $cryptoAmount,
						'countryCode' 				=> $countryValue,
						'defaultCryptoCurrency'     => strtoupper($defaultCurrencyCode),
                        'partnerOrderId'            => $externalTransactionId,
                        'partnerCustomerId'         => $externalCustomerId,
                        'walletAddress'             => $walletAddress,
                        'redirectURL'               => get_the_permalink(TRANSAK_REDIRECT_URL),
                    );

                    /*passing slug of payment method in transak*/    
                    if( $transak_payment_method_mapping[$paymentmethod] ){
                        $data['paymentMethod'] = $transak_payment_method_mapping[$paymentmethod] ;
                    }

                    wp_redirect(TRANSAK_THIRD_PARTY_PAGE.'?'.http_build_query($data) . "\n");
                    exit();
                }
        }
    }

    public function display_front_form_callback($atts) {
    	$atts_value = shortcode_atts( array(
			'redirect_to' 	=> '',
			'bar' 			=> 'something else',
		), $atts );
    	
    	ob_start();
	        $layout_path    = TRANSAK_PLUGIN_PATH . 'templates/front-form.php';
	        require_once apply_filters( 'transak_template_path', $layout_path );
        return ob_get_clean();
    }

}

$transak_front_form = new TRANSAK_Front_Form_Shortcode;