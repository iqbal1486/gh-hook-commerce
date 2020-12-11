<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class TRANSAK_Front_Form_Shortcode {

    public function __construct() {
       
       /*This is disable now*/
        add_action( 'init', array( $this, 'moonpay_insert_update_callback_from_listing_page' ) );
       // add_action( 'init', array( $this, 'moonpay_insert_update_redirect_callback_from_main_form' ) );
        add_shortcode( 'transak_conversion_form', array( $this, 'display_front_form_callback' ) );
    }

    public function moonpay_insert_update_redirect_callback_from_main_form(){
        if(isset($_POST['currency-amount-value']) && !empty($_POST['currency-amount-value'])) {
                global $table_prefix, $wpdb;

                $timestamp               = time();  
                $externalCustomerId      = $timestamp.'.'.rand();
                $externalTransactionId   = 'eti_'.$timestamp.'_aggregator';

                $baseCurrencyAmount     = $_POST['currency-amount-value'];
                $quoteCurrencyAmount    = $_POST['cryptocurrency-amount-value'];

                $baseCurrencyCode       = $_POST['currency-code-value'];
                $defaultCurrencyCode    = $_POST['cryptocurrency-code-value'];
                $countryValue           = $_POST['country-value'];

                $extraFeeAmount         = $_POST['extraFeeAmount'];
                $feeAmount              = $_POST['feeAmount'];
                
                $provider_name          = 'moonpay';
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
                        'amount'            => $baseCurrencyAmount,
                        'crypto_currency_amount' => $quoteCurrencyAmount,
                        'provider_name'     => $provider_name,
                        'raw_data'          => maybe_serialize($_POST),
                        'user_agent'        => $_SERVER['HTTP_USER_AGENT'],
                        'ip_address'        => $ip,
                    ));
                    
                }else{
                    

                    /*Update Query*/
                    $wpdb->update( 
                        "{$wpdb->prefix}transak_transaction", 
                        array( 
                            'currency'          => $baseCurrencyCode,
                            'crypto_currency'   => $defaultCurrencyCode,
                            'country_code'      => $countryValue,    
                            'amount'            => $baseCurrencyAmount,
                            'crypto_currency_amount' => $quoteCurrencyAmount,
                            'provider_name'     => $provider_name,
                            'raw_data'          => maybe_serialize($_POST),
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
                            '%s'
                        ), 
                        array( '%s' ) 
                    );    

                }

                $data = array(
                    'baseCurrencyAmount'    => $baseCurrencyAmount,
                    'baseCurrencyCode'      => $baseCurrencyCode,
                    'defaultCurrencyCode'   => $defaultCurrencyCode,
                    'externalCustomerId'    => $externalCustomerId,
                    'externalTransactionId' => $externalTransactionId,
                    'extraFeeAmount'        => $extraFeeAmount,
                    'feeAmount'             => $feeAmount,
                    'redirectURL'           => $_POST['redirectURL'],
                    'apiKey'                => TRANSAK_API_KEY
                );

                wp_redirect(MOONPAY_THIRD_PARTY_PAGE.'?'.http_build_query($data) . "\n");
                exit();
        }    
    }

    public function moonpay_insert_update_callback_from_listing_page(){
        if(isset($_GET['externalTransactionId']) && wp_verify_nonce($_GET['transak_buy_now'], 'transak-buy-now')) {
               global $table_prefix, $wpdb;

                $externalTransactionId  = $_GET['externalTransactionId'];
                $externalCustomerId     = $_GET['externalCustomerId'];
                $baseCurrencyAmount     = $_GET['baseCurrencyAmount'];
                $quoteCurrencyAmount    = $_GET['quoteCurrencyAmount'];

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
                        'amount'            => $baseCurrencyAmount,
                        'crypto_currency_amount' => $quoteCurrencyAmount,
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
                            'amount'            => $baseCurrencyAmount,
                            'crypto_currency_amount' => $quoteCurrencyAmount,
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
                                                    'applepay' => 'credit_debit_card'

                                                );    
                    $data = array(
                        'apiKey'                    => TRANSAK_API_KEY,
                        //'defaultFiatAmount'         => $baseCurrencyAmount,
                        //'fiatCurrency'              => strtoupper($baseCurrencyCode),
                        'defaultCryptoAmount' 		=> $quoteCurrencyAmount,
						'countryCode' 				=> $countryValue,
						'defaultCryptoCurrency'     => strtoupper($defaultCurrencyCode),
                        'partnerOrderId'            => $externalTransactionId,
                        'partnerCustomerId'         => $externalCustomerId,
                        'walletAddress'             => $walletAddress,
                        'redirectURL'               => get_the_permalink(TRANSAK_REDIRECT_URL),
                        //'hostURL'                   => get_the_permalink(TRANSAK_REDIRECT_URL)
                    );

                    /*passing slug of payment method in transak*/    
                    if( $transak_payment_method_mapping[$paymentmethod] ){
                        $data['paymentMethod'] = $transak_payment_method_mapping[$paymentmethod] ;
                    }

                    wp_redirect(TRANSAK_THIRD_PARTY_PAGE.'?'.http_build_query($data) . "\n");
                    exit();
                    /*
                    https://staging-global.transak.com/?apiKey=ae882203-9b59-4206-a48f-1bedcc22c753&hostURL=http://transak.demansol.tech/&defaultCryptoCurrency=ETH&defaultFiatAmount=500&fiatCurrency=USD
                    */

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