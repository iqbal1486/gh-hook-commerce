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
        global $get_list_countries;
        $html                       = "";
        $result                     = array();
        $timestamp                  = time();
        $externalCustomerId         = $timestamp . '.' . rand();
        $currencyAmountValue        = $_REQUEST['currencyAmountValue'];
        $currencyCodeValue          = $_REQUEST['currencyCodeValue'];
        $cryptocurrencyCodeValue    = $_REQUEST['cryptocurrencyCodeValue'];
        $countryValue               = $_REQUEST['countryValue'];
        $paymentmethod              = "visa";//$_REQUEST['paymentmethod'];
        
        $transak_payment_supported = true;

        /*Transak Data Manipulation Start Here*/
        $get_transak_currencies_quote = $this->get_transak_currencies_quote($cryptocurrencyCodeValue, $currencyAmountValue, $currencyCodeValue);
        $get_transak_currencies_quote = $get_transak_currencies_quote->response;
        $cryptoAmount = $get_transak_currencies_quote->cryptoAmount;
        $quoteId = $get_transak_currencies_quote->quoteId;
       
        $transak_country_supported = $this->check_integration_support($get_list_countries, "transak_supported", "yes", "alpha2", $countryValue);

            /*on success*/
            $html .= "<div class='trnsak-response-html'>";
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

            $html .= "<input name='fiatAmount' type='hidden' value='" . $currencyAmountValue . "'>";
            $html .= "<input name='cryptoAmount' type='hidden' value='" . $cryptoAmount . "'>";
            $html .= "<input name='baseCurrencyCode' type='hidden' value='" . $currencyCodeValue . "'>";
            $html .= "<input name='defaultCurrencyCode' type='hidden' value='" . $cryptocurrencyCodeValue . "'>";
            $html .= "<input name='externalCustomerId' type='hidden' value='" . $externalCustomerId . "'>";
            $html .= "<input name='externalTransactionId' type='hidden' value='" . $quoteId . "'>";
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

    
    public function get_transak_currencies_quote($cryptocurrencyCode, $fiatAmount, $baseCurrencyCode)
    {

        $apiUrl = TRANSAK_CURRENCY_API . '?fiatCurrency=' . strtoupper($baseCurrencyCode) . '&cryptoCurrency=' . strtoupper($cryptocurrencyCode) . '&isBuyOrSell=BUY&fiatAmount=' . $fiatAmount;
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

    public function get_transak_currencies_exchange_rate($cryptocurrencyCode, $fiatAmount, $baseCurrencyCode)
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