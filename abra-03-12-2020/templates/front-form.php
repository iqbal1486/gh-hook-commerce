<?php
    global $get_fiat_currencies, $get_crypto_currencies, $get_list_countries;

    /*IP Based country detection start here*/
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

      $TRANSAK_DEFAULT_COUNTRY = TRANSAK_DEFAULT_COUNTRY;
 
    
    $error_form_class = "";
    wp_enqueue_script( 'transak-front-form-script' );
    if(!$get_crypto_currencies || !$get_list_countries || !$get_fiat_currencies ){
        if ( !isset( $_SESSION['transak_count'] ) ) 
            $_SESSION['transak_count'] = 1; 
        else 
            $_SESSION['transak_count']++;

        if($_SESSION['transak_count'] <= 3){
            wp_redirect(get_the_permalink());
            exit();   
        }
        $error_form_class = 'blur';
    }
    
    $cryptoOptions = $fiatOptions = $countries = "";
    
    /*Fiat Currencies*/
    if($get_fiat_currencies){
        foreach ($get_fiat_currencies as $key => $value) {
            $selected = "";
            $code = $value['iso_code'];
            $name = $value['currency'];
            
            $fiatOptions .= '<option '.selected( TRANSAK_DEFAULT_CURRENCY , $code, false).' data-name="'.$name.'" value="'.$code.'">'.strtoupper($code).'</option>';
            
        }
    }

    /*Crypto Currencies*/
    if($get_crypto_currencies){
        foreach ($get_crypto_currencies as $key => $value) {
            $selected = "";
            $code = $value['ticker_symbol'];
            $name = $value['currency'];
            
            $cryptoOptions .= '<option '.selected( TRANSAK_DEFAULT_CRYPTO_CURRENCY , $code, false).' data-name="'.$name.'" value="'.$code.'">'. strtoupper($code).'</option>';
            
        }
    }

    /*List of Countries*/
    if($get_list_countries){
        
        function compareByName($a, $b) {
          return strcmp($a["alpha2"], $b["alpha2"]);
        }
        usort($get_list_countries, 'compareByName');

        foreach ($get_list_countries as $key => $value) {
            $alpha2     = $value['alpha2'];
            $name       = $value['country_name'];
            $currency_code = $value['currency_code'];
            
                $countries .= '<option '.selected( $TRANSAK_DEFAULT_COUNTRY, $alpha2, false).' data-currency="'.strtolower($currency_code).'" class="flag flag-'.$alpha2.'" value="'.$alpha2.'"><span>'. strtoupper($alpha2).'</span></option>';

            
        }
    }
?>

<?php if($error_form_class) {?>
    <div class="reload_page"><a href="<?php echo get_the_permalink() ?>" class="buy-now-button">Reload Page</a></div>
<?php }?>

<form class="transak-conversion-form <?php echo $error_form_class ?>" method="GET" action="<?php echo get_the_permalink($atts_value['redirect_to']); ?>">
        <div class="transak-title-wrapper" id="buy-now-header-text-change">Buy Bitcoin ( BTC )</div>
        <input type="hidden" name="redirectURL" value="<?php echo get_the_permalink(); ?>">
        <div class="transak-conversion-form-inner">
                
                <div class="transak-group transak-full right-side">
                    <label for="country-value">Country</label>
                    <select name="country-value" id="country-value" class="select2 country-value t-conversion">
                        <?php echo $countries; ?>
                    </select>
                </div>

                <div class="transak-group transak-full">
                    <label for="fiatAmount">You Spend</label>
                    <input type="number" name="fiatAmount" required value="150" id="fiatAmount" class="fiatAmount" />
                    <select name="fiatCurrency" id="fiatCurrency" class="select2 fiatCurrency t-conversion">
                        <?php echo $fiatOptions; ?>
                    </select>
                    <div id="cryptocurrency-error"></div>
                </div>
    
                <div class="transak-group transak-full transak-clear-both">
                    <label for="cryptoAmount">You Receive</label>
                    <input type="text" readonly name="cryptoAmount" id="cryptoAmount" class="cryptoAmount" />
                    <select name="cryptoCurrency" id="cryptoCurrency"  class="select2 cryptoCurrency t-conversion">
                        <?php echo $cryptoOptions; ?>
                    </select>
                </div>
                
                <div id="transak_response"></div>
                <input name='transak_buy_now' type='hidden' value='<?php echo wp_create_nonce('transak-buy-now'); ?>'>
                <div class="transak-group transak-full transak-center">
                    <button type="submit" class="buy-now-button" id="buy-now-text-change">Buy Now</button>
                </div>
        </div>
        <?php if(get_option('transak_footer_text')){ ?>
        <div class="transak-footer">
            <?php echo get_option('transak_footer_text'); ?>
        </div>
    <?php } ?>
</form>