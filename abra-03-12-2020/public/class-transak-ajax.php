<?php
// Preventing to direct access
defined('ABSPATH') or die('Direct access not acceptable!');

class TRANSAK_AjaxCall
{

    public function __construct()
    {
        //add_action("wp_ajax_transak_conversion_call", array( $this,"transak_conversion_call" ));
        //add_action("wp_ajax_nopriv_transak_conversion_call", array( $this,"transak_conversion_call" ));
        
        add_action("wp_ajax_transak_conversion_call", array( $this,"transak_listing_call" ));
        add_action("wp_ajax_nopriv_transak_conversion_call", array( $this,"transak_listing_call" ));
    }

  
    // define the function to be fired for logged in users
    public function transak_listing_call()
    {
        global $get_payment_method, $get_list_countries, $get_States_list, $get_payment_method_label, $payment_method_interest, $banxa_payment_method_widget_mapping;
        $html = $html = "";
        $filter_min = $min_quote = array();

       
        $result = array();
        $timestamp = time();
        $externalCustomerId = $timestamp . '.' . rand();
        $externalTransactionId = 'eti_' . $timestamp . '_aggregator';

        $currencyAmountValue = $_REQUEST['currencyAmountValue'];
        $currencyCodeValue = $_REQUEST['currencyCodeValue'];
        $cryptocurrencyCodeValue = $_REQUEST['cryptocurrencyCodeValue'];
        $countryValue = $_REQUEST['countryValue'];
        $paymentmethod = $_REQUEST['paymentmethod'];
        $stateValue = $_REQUEST['stateValue'];
        $is_delete_transient = $_REQUEST['is_delete_transient'];

        $transak_payment_supported = true;

        /*Transak Data Manipulation Start Here*/

        $get_transak_currencies_quote = $this->get_transak_currencies_quote($cryptocurrencyCodeValue, $currencyAmountValue, $currencyCodeValue);
        $quoteCurrencyAmount = $get_transak_currencies_quote->cryptoAmount;
                    $quoteId = $get_transak_currencies_quote->quoteId;
                    
        $get_transak_currencies_exchange_rate = $this->get_transak_currencies_exchange_rate($cryptocurrencyCodeValue, $currencyAmountValue, $currencyCodeValue);
        $transak_country_supported = $this->check_integration_support($get_list_countries, "transak_supported", "yes", "alpha2", $countryValue);

            /*on success*/
            $html .= "<div class='right-inner-outer'>";
            $html .= "<div class='title'>Enter your " . strtoupper($cryptocurrencyCodeValue) . " wallet address</div>";
            $html .= "<div class='description'>Our provider will send money to this address after you complete payment</div>";

            /*solution to submitting a GET form with query string params and hidden params disappear*/
            $url_components = parse_url($transak_payment_page);
            parse_str($url_components['query'], $query_params);

            if (!empty($query_params))
            {
                foreach ($query_params as $key => $value)
                {
                    $html .= "<input name='" . $key . "' type='hidden' value='" . $value . "'>";
                }
            }

            $html .= "<input name='baseCurrencyAmount' type='hidden' value='" . $currencyAmountValue . "'>";
            $html .= "<input name='quoteCurrencyAmount' type='hidden' value='" . $quoteCurrencyAmount . "'>";
            $html .= "<input name='baseCurrencyCode' type='hidden' value='" . $currencyCodeValue . "'>";
            $html .= "<input name='defaultCurrencyCode' type='hidden' value='" . $cryptocurrencyCodeValue . "'>";
            $html .= "<input name='externalCustomerId' type='hidden' value='" . $externalCustomerId . "'>";
            $html .= "<input name='externalTransactionId' type='hidden' value='" . $externalTransactionId . "'>";
            $html .= "<input name='countryValue' type='hidden' value='" . $countryValue . "'>";
            $html .= "<input name='quoteid' type='hidden' value='" . $quoteId . "'>";
            $html .= "<input name='paymentmethod' type='hidden' value='" . $paymentmethod . "'>";
            $html .= "<input name='provider_name' type='hidden' value='transak'>";

            $html .= "<input name='transak_wallet_address' class='wallet_address' placeholder='Enter your " . strtoupper($cryptocurrencyCodeValue) . " recipient address' required type='text' value=''>";

            $html .= "<span class='transak_error_message'></span>";
            $html .= '<label for="transak_acceptance" class="transak_acceptance">
                <input id="transak_acceptance" name="transak_acceptance_checkbox" required type="checkbox" >
                <span class="transak_acceptance_text">
                  <span>I agree with&nbsp;<a href="' . get_the_permalink(TRANSAK_TERMS_URL) . '" target="_blank">Terms of Use</a> and &nbsp;<a href="' . get_the_permalink(TRANSAK_PRIVACY_URL) . '" target="_blank">Privacy Policy</a></span>
                </span>
              </label>';
            $html .= "</div>";
                    
        
        /*Transak Data Manipulation End Here*/

      

        $result['html'] = "<div class='custom-row'>" . $html . "</div>";
        $result['currencies_quote'] = $get_transak_currencies_quote;
        // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            $result = json_encode($result);
            echo $result;
        }
        else
        {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        // don't forget to end your scripts with a die() function - very important
        die();
    }

    // define the function to be fired for logged in users
    public function transak_conversion_call()
    {
        global $get_list_countries, $get_fiat_currencies, $get_crypto_currencies;
        $filter_min = $min_quote = array();

        $currencyAmountValue = $_REQUEST['currencyAmountValue'];
        $currencyCodeValue = $_REQUEST['currencyCodeValue'];
        $cryptocurrencyCodeValue = $_REQUEST['cryptocurrencyCodeValue'];
        $countryValue = $_REQUEST['countryValue'];

 
        /*Trasak handling start here*/

        $transak_fiat_supported = $this->check_integration_support($get_fiat_currencies, "transak_supported", "yes", "iso_code", $currencyCodeValue);
        $transak_crypto_supported = $this->check_integration_support($get_crypto_currencies, "transak_supported", "yes", "ticker_symbol", $cryptocurrencyCodeValue);

        if ($transak_fiat_supported && $transak_crypto_supported)
        {

            $get_transak_currencies_quote = $this->get_transak_currencies_quote($cryptocurrencyCodeValue, $currencyAmountValue, $currencyCodeValue);
            if ($get_transak_currencies_quote->response)
            {
                $get_transak_currencies_quote = $get_transak_currencies_quote->response;
                if (!empty($get_transak_currencies_quote->cryptoAmount))
                {
                    $filter_min['transak'] = $get_transak_currencies_quote->cryptoAmount;
                }
            }
        }

        /*Transak handling end here*/

 
        $min_quote = array_keys($filter_min, max($filter_min));

        // Check if action was fired via Ajax call. If yes, JS code will be triggered, else the user is redirected to the post page
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
        {
            
            $get_transak_currencies_quote->integration_type = 'transak';
            $result = json_encode($get_transak_currencies_quote);

            echo $result;
        }
        else
        {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
        // don't forget to end your scripts with a die() function - very important
        die();
    }


    public function get_transak_currencies_quote($cryptocurrencyCode, $baseCurrencyAmount, $baseCurrencyCode)
    {

        $apiUrl = TRANSAK_CURRENCY_API . '?fiatCurrency=' . strtoupper($baseCurrencyCode) . '&cryptoCurrency=' . strtoupper($cryptocurrencyCode) . '&isBuyOrSell=BUY&fiatAmount=' . $baseCurrencyAmount;
        $response = wp_remote_get($apiUrl);
        $responseBody = wp_remote_retrieve_body($response);
        $result = json_decode($responseBody);
        if ($result && !is_wp_error($result))
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

    public function get_transak_currencies_exchange_rate($cryptocurrencyCode, $baseCurrencyAmount, $baseCurrencyCode)
    {

        $apiUrl = TRANSAK_CURRENCY_API . '?fiatCurrency=' . strtoupper($baseCurrencyCode) . '&cryptoCurrency=' . strtoupper($cryptocurrencyCode) . '&isBuyOrSell=BUY&cryptoAmount=1';
        $response = wp_remote_get($apiUrl);
        $responseBody = wp_remote_retrieve_body($response);
        $result = json_decode($responseBody);
        if ($result && !is_wp_error($result))
        {
            return $result;
        }
        else
        {
            return false;
        }
    }

  

    public function check_integration_support($arraylist, $field, $value, $field2, $value2)
    {
        foreach ($arraylist as $key => $data)
        {
            if ($data[$field] == $value && $data[$field2] == $value2)
            {
                return true;
            }
        }
        return false;
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED'])) $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED'])) $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR'])) $ipaddress = $_SERVER['REMOTE_ADDR'];
        else $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

}

$transak_ajax_call = new TRANSAK_AjaxCall;