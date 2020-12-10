<?php
    global $get_fiat_currencies, $get_crypto_currencies, $get_list_countries, $delist_countries;

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

      $ABRAC_DEFAULT_COUNTRY = ABRAC_DEFAULT_COUNTRY;
      if(isset($record->country->isoCode) && !empty($record->country->isoCode)){
        $ABRAC_DEFAULT_COUNTRY   = $record->country->isoCode;
      }
    
    $error_form_class = "";
    wp_enqueue_script( 'abrac-front-form-script' );
    
    if(!$get_crypto_currencies || !$get_list_countries || !$get_fiat_currencies ){
        if ( !isset( $_SESSION['abra_count'] ) ) 
            $_SESSION['abra_count'] = 1; 
        else 
            $_SESSION['abra_count']++;

        if($_SESSION['abra_count'] <= 3){
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
            
            $fiatOptions .= '<option '.selected( ABRAC_DEFAULT_CURRENCY , $code, false).' data-name="'.$name.'" value="'.$code.'">'.strtoupper($code).'</option>';
            
        }
    }

    /*Crypto Currencies*/
    if($get_crypto_currencies){
        foreach ($get_crypto_currencies as $key => $value) {
            $selected = "";
            $code = $value['ticker_symbol'];
            $name = $value['currency'];
            
            $cryptoOptions .= '<option '.selected( ABRAC_DEFAULT_CRYPTO_CURRENCY , $code, false).' data-name="'.$name.'" value="'.$code.'">'. strtoupper($code).'</option>';
            
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
            
                $countries .= '<option '.selected( $ABRAC_DEFAULT_COUNTRY, $alpha2, false).' data-currency="'.strtolower($currency_code).'" class="flag flag-'.$alpha2.'" value="'.$alpha2.'"><span>'. strtoupper($alpha2).'</span></option>';

            
        }
    }
?>

<?php if($error_form_class) {?>
    <div class="reload_page"><a href="<?php echo get_the_permalink() ?>" class="buy-now-button">Reload Page</a></div>
<?php }?>

<form class="abrac-conversion-form <?php echo $error_form_class ?>" method="POST" action="<?php echo get_the_permalink($atts_value['redirect_to']); ?>">
        <div class="abra-title-wrapper" id="buy-now-header-text-change">Buy Bitcoin ( BTC )</div>
        <input type="hidden" name="redirectURL" value="<?php echo get_the_permalink(); ?>">
        <div class="abrac-conversion-form-inner">
                
                <div class="abrac-group abrac-full right-side">
                    <label for="country-value">Country</label>
                    <select name="country-value" id="country-value" class="select2 country-value t-conversion">
                        <?php echo $countries; ?>
                    </select>
                </div>

                <div class="abrac-group abrac-full">
                    <label for="currency-amount-value">You Spend</label>
                    <input type="number" name="currency-amount-value" required value="150" id="currency-amount-value" class="currency-amount-value" />
                    <select name="currency-code-value" id="currency-code-value" class="select2 currency-code-value t-conversion">
                        <?php echo $fiatOptions; ?>
                    </select>
                    <div id="cryptocurrency-error"></div>
                </div>
    
                <div class="abrac-group abrac-full abrac-clear-both">
                    <label for="cryptocurrency-amount-value">You Receive</label>
                    <input type="text" readonly name="cryptocurrency-amount-value" id="cryptocurrency-amount-value" class="cryptocurrency-amount-value" />
                    <select name="cryptocurrency-code-value" id="cryptocurrency-code-value"  class="select2 cryptocurrency-code-value t-conversion">
                        <?php echo $cryptoOptions; ?>
                    </select>
                </div>
    
                <div class="abrac-group abrac-full abrac-center">
                    <button type="submit" class="buy-now-button" id="buy-now-text-change">Buy Now</button>
                </div>
        </div>
        <?php if(get_option('abrac_footer_text')){ ?>
        <div class="abrac-footer">
            <?php echo get_option('abrac_footer_text'); ?>
        </div>
    <?php } ?>
</form>