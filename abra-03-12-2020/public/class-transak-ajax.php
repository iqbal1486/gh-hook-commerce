<?php
// Preventing to direct access
defined('ABSPATH') or die('Direct access not acceptable!');

class TRANSAK_AjaxCall
{

    public function __construct()
    {
        add_action("wp_ajax_transak_conversion_call", array(
            $this,
            "transak_conversion_call"
        ));
        add_action("wp_ajax_nopriv_transak_conversion_call", array(
            $this,
            "transak_conversion_call"
        ));

        add_action("wp_ajax_transak_listing_call", array(
            $this,
            "transak_listing_call"
        ));
        add_action("wp_ajax_nopriv_transak_listing_call", array(
            $this,
            "transak_listing_call"
        ));

    }

  
    // define the function to be fired for logged in users
    public function transak_listing_call()
    {
        global $get_payment_method, $get_list_countries, $get_States_list, $countries_to_payment_methods_mapping, $get_payment_method_label, $payment_method_interest, $banxa_payment_method_widget_mapping;
        $html = $moonpay_html = $simplex_html = $transak_html = $banxa_html = "";
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

        /*Delete All API Transient to have fresh data*/
        if ($is_delete_transient == "delete_transient")
        {
            delete_transient('get_currencies_quote');
            delete_transient('get_currencies_exchange_rate');
            delete_transient('get_simplex_currencies_quote');
            delete_transient('get_simplex_currencies_exchange_rate');

            delete_transient('get_transak_currencies_quote');
            delete_transient('get_banxa_currencies_quote');
        }

        
        $moonpay_payment_supported = $simplex_payment_supported = $transak_payment_supported = $banxa_payment_supported = false;


        if (in_array($paymentmethod, $countries_to_payment_methods_mapping[$countryValue]['transak']))
        {
            $transak_payment_supported = true;
        }



        /*Transak Data Manipulation Start Here*/
        if ($transak_payment_supported)
        {
            $currencyAmountValueAfterDeduction = $currencyAmountValue;

           
            $get_transak_currencies_quote = $this->get_transak_currencies_quote($cryptocurrencyCodeValue, $currencyAmountValueAfterDeduction, $currencyCodeValue);

            $get_transak_currencies_exchange_rate = $this->get_transak_currencies_exchange_rate($cryptocurrencyCodeValue, $currencyAmountValueAfterDeduction, $currencyCodeValue);
            $transak_country_supported = $this->check_integration_support($get_list_countries, "transak_supported", "yes", "alpha2", $countryValue);

            $transak_state_supported = true;
            if (!empty($stateValue))
            {
                $transak_state_supported = $this->check_integration_support($get_States_list, "transak_supported", "yes", "alpha2", $stateValue);
            }

            $countries_payment_method_supported = false;
            if (in_array($paymentmethod, $countries_to_payment_methods_mapping[$countryValue]['transak']))
            {
                $countries_payment_method_supported = true;
            }
            else if (!$countries_to_payment_methods_mapping[$countryValue])
            {
                $countries_payment_method_supported = true;
            }

            $show_transak = true;
            if ( $get_transak_currencies_quote->error && preg_match('(Minimum|less than)', $get_transak_currencies_quote->error->message ) === 1 ){
                $show_transak = true;
            }else if ($get_transak_currencies_quote->error || !$transak_country_supported || !$transak_state_supported || !$countries_payment_method_supported){
                $show_transak = false;
            }

            if( $show_transak ){

                if ($get_transak_currencies_quote->error || !$transak_country_supported || !$transak_state_supported || !$countries_payment_method_supported)
                {
                    /*on error*/
                    $transak_html .= "<div class='listing-single-block'>";

                    $transak_html .= "<div class='right-half-left'>";
                    $transak_html .= "<div class='provider'><img src='" . TRANSAK_PLUGIN_URL . "/assets/images/transak.png' /></div>";
                    $transak_html .= "</div>";

                    $transak_html .= "<div class='right-half-center'>";
                    if (!$transak_country_supported || !$transak_state_supported || !$countries_payment_method_supported)
                    {
                        if (!$transak_state_supported)
                        {
                            $transak_html .= "<div class='response-error-message'> State not supported</div>";
                        }
                        elseif (!$countries_payment_method_supported)
                        {
                            $transak_html .= "<div class='response-error-message'>" . $get_payment_method_label[$paymentmethod] . " Payment Method not supported for this country</div>";
                        }
                        else
                        {
                            $transak_html .= "<div class='response-error-message'> Country not supported</div>";
                        }
                    }
                    else
                    {
                        $word = "excluding fees";
                        // Test if string contains the word
                        if (strpos($get_transak_currencies_quote
                            ->error->message, $word) !== false)
                        {
                            $transak_error_message = explode(',', $get_transak_currencies_quote
                                ->error
                                ->message);
                            $transak_html .= "<div class='response-error-message'>" . $transak_error_message[0] . "</div>";
                        }
                        else
                        {
                            $transak_html .= "<div class='response-error-message'>" . $get_transak_currencies_quote
                                ->error->message . "</div>";
                        }
                    }

                    $transak_html .= "</div>";

                    $transak_html .= "<div class='right-half-right'>";
                    $transak_html .= "<div class='payment-method-images'>";
                    foreach ($get_payment_method as $key => $value)
                    {
                        if ($value['transak_supported'] == "yes")
                        {
                            $transak_html .= "<img src='" . TRANSAK_PLUGIN_URL . "/assets/images/" . $value['payment_method'] . ".svg' />";
                        }
                    }
                    $transak_html .= "</div>";
                    $transak_html .= "</div>";

                    $transak_html .= "</div>";
                }
                else
                {
                    /*on success*/
                    $get_transak_currencies_quote = $get_transak_currencies_quote->response;

                    $quoteCurrencyAmount = $get_transak_currencies_quote->cryptoAmount;
                    $quoteId = $get_transak_currencies_quote->quoteId;
                    $totalAmount = $get_transak_currencies_quote->totalAmount;

                    if (!empty($get_transak_currencies_quote->cryptoAmount))
                    {
                        $filter_min['transak'] = $get_transak_currencies_quote->cryptoAmount;
                    }
                    else
                    {
                        $filter_min['transak'] = 0;
                    }

                    $crypto = strtoupper($cryptocurrencyCodeValue);
                    $currency = strtoupper($currencyCodeValue);

                    //$currencies_exchange_rate = $get_currencies_exchange_rate[$crypto][$currency];
                    if ($get_transak_currencies_exchange_rate
                        ->response
                        ->fiatAmount) $currencies_exchange_rate = $get_transak_currencies_exchange_rate
                        ->response->fiatAmount;

                    $transak_html .= "<div class='listing-single-block transak-block TRANSAK_OFF_PRICE'>";

                    $transak_html .= "<div class='right-half-left'>";
                    $transak_html .= "<div class='provider'><img src='" . TRANSAK_PLUGIN_URL . "/assets/images/transak.png' /></div>";
                    $transak_html .= "</div>";

                    $transak_html .= "<div class='right-half-center'>";
                    $transak_html .= "<div class='amount-block'><span> " . $quoteCurrencyAmount . "</span>  <span>" . $crypto . "</span></div>";
                    $transak_html .= "<div class='estimate-block'> <span> 1 " . $crypto . " ~ " . $currencies_exchange_rate . "</span>  <span> " . $currency . "</span></div>";
                    $transak_html .= "</div>";

                    $transak_payment_page = get_the_permalink(get_option('transak_payment_page'));
                    $transak_payment_page = MOONPAY_THIRD_PARTY_PAGE;

                    $transak_html .= "<div class='right-half-right'>";
                 
                    $transak_html .= "<form method='get' action='" . get_the_permalink() . "'>";

                    $transak_html .= "<button type='button' class='transak-buy-now-button'>Buy Now</button>";
                    $transak_html .= "<div class='payment-method-images'>";
                    foreach ($get_payment_method as $key => $value)
                    {
                        if ($value['transak_supported'] == "yes")
                        {
                            $transak_html .= "<img src='" . TRANSAK_PLUGIN_URL . "/assets/images/" . $value['payment_method'] . ".svg' />";
                        }
                    }
                    $transak_html .= "</div>";
                    $transak_html .= "</form>";

                    /*inner form start here*/
                    $transak_html .= "<div class='transak-crypto-form' style='display:none'>";

                    $transak_html .= "<div class='transak_final_input_form'>";

                    $transak_html .= "<div class='transak-mini-output smo left-inner-wrap'>";
                    //$transak_html .= "<div class='spent'>You spend 150 usd to receive</div>";
                    $transak_html .= "<div class='amount-block'><strong> " . $quoteCurrencyAmount . "  " . $crypto . "</strong></div>";

                    if ($currencies_exchange_rate)
                    {
                        $transak_html .= "<div class='estimate-block'> 1 " . $crypto . " ~ " . round($currencies_exchange_rate) . " " . $currency . "</div>";
                    }

                    $transak_html .= "<div class='provider'><img src='" . TRANSAK_PLUGIN_URL . "/assets/images/transak.png' /></div>";

                    $transak_html .= "<div class='payment-method-images'>";
                    foreach ($get_payment_method as $key => $value)
                    {
                        if ($value['transak_supported'] == "yes")
                        {
                            $transak_html .= "<img src='" . TRANSAK_PLUGIN_URL . "/assets/images/" . $value['payment_method'] . ".svg' />";
                        }
                    }
                    $transak_html .= "</div>";
                    $transak_html .= "</div>";

                    $transak_html .= "<div class='right-inner-wrap'>";
                    $transak_html .= "<form method='get' action='" . get_the_permalink() . "'>";

                    $transak_html .= "<span class='back-refresh-span'><a href='#' class='back-refresh'>Back</a></span>";

                    $transak_html .= "<div class='right-inner-outer'>";
                    $transak_html .= "<div class='title'>Enter your " . strtoupper($cryptocurrencyCodeValue) . " wallet address</div>";
                    $transak_html .= "<div class='description'>Our provider will send money to this address after you complete payment</div>";

                    /*solution to submitting a GET form with query string params and hidden params disappear*/
                    $url_components = parse_url($transak_payment_page);
                    parse_str($url_components['query'], $query_params);

                    if (!empty($query_params))
                    {
                        foreach ($query_params as $key => $value)
                        {
                            $transak_html .= "<input name='" . $key . "' type='hidden' value='" . $value . "'>";
                        }
                    }

                    $transak_html .= "<input name='baseCurrencyAmount' type='hidden' value='" . $currencyAmountValueAfterDeduction . "'>";
                    $transak_html .= "<input name='quoteCurrencyAmount' type='hidden' value='" . $quoteCurrencyAmount . "'>";
                    $transak_html .= "<input name='baseCurrencyCode' type='hidden' value='" . $currencyCodeValue . "'>";
                    $transak_html .= "<input name='defaultCurrencyCode' type='hidden' value='" . $cryptocurrencyCodeValue . "'>";
                    $transak_html .= "<input name='externalCustomerId' type='hidden' value='" . $externalCustomerId . "'>";
                    $transak_html .= "<input name='externalTransactionId' type='hidden' value='" . $externalTransactionId . "'>";
                    $transak_html .= "<input name='countryValue' type='hidden' value='" . $countryValue . "'>";
                    $transak_html .= "<input name='quoteid' type='hidden' value='" . $quoteId . "'>";
                    $transak_html .= "<input name='paymentmethod' type='hidden' value='" . $paymentmethod . "'>";
                    $transak_html .= "<input name='provider_name' type='hidden' value='transak'>";

                    $transak_html .= "<input name='transak_wallet_address' class='wallet_address' placeholder='Enter your " . strtoupper($cryptocurrencyCodeValue) . " recipient address' required type='text' value=''>";

                    $transak_html .= "<span class='transak_error_message'></span>";
                    $transak_html .= '<label for="transak_acceptance" class="transak_acceptance">
                        <input id="transak_acceptance" name="transak_acceptance_checkbox" required type="checkbox" >
                        <span class="transak_acceptance_text">
                          <span>I agree with&nbsp;<a href="' . get_the_permalink(TRANSAK_TERMS_URL) . '" target="_blank">Terms of Use</a> and &nbsp;<a href="' . get_the_permalink(TRANSAK_PRIVACY_URL) . '" target="_blank">Privacy Policy</a></span>
                        </span>
                      </label>';

                    $transak_html .= "<input name='transak_buy_now' type='hidden' value='" . wp_create_nonce('transak-buy-now') . "'>";

                    //$transak_html .= "<span class='back-refresh-span'><a href='#' class='back-refresh'>Back</a></span>";
                    $transak_html .= "<span class='final-button-span'><button type='submit' disabled class='transak_buy_now'>Buy Now</button></span>";
                    $transak_html .= "</div>";
                    $transak_html .= "</form>";
                    $transak_html .= "</div>";
                    $transak_html .= "</div>";

                    $transak_html .= "</div>";
                    /*inner form end here*/

                    $transak_html .= "</div>";

                    $transak_html .= "</div>";
                }

            }
        }
        /*Transak Data Manipulation End Here*/

      

        $result['html'] = "<div class='custom-row'>" . $transak_html . "</div>";
        $result['min_quote_amount'] = $min_quote_amount;
        $result['currencies_quote'] = $get_currencies_quote;
        $result['currencies_exchange_rate'] = $get_currencies_exchange_rate;

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