<div id="wcl-default-layout" class="wcl-popup-container wcl-popup-container--position">

    <!-- .Popup footer -->
    <div class="wcl-popup__footer">

        <!-- Popup open button -->
        <div class="wcl-popup__open-btn wcl-popup-group-invitation__button wcl-shadow wcl--text-color wcl--bg-color">
            <?php
                $wcl_whatsapp_number_prefix_code   = get_option('wcl_whatsapp_number_prefix_code');
                $wcl_whatsapp_number               = get_option('wcl_whatsapp_number');
                $wcl_whatsapp_text                 = get_option('wcl_whatsapp_text');
                $wcl_bitly_whatsapp_desktop        = get_option('wcl_bitly_whatsapp_desktop');
                $wcl_bitly_whatsapp_mobile         = get_option('wcl_bitly_whatsapp_mobile');
                $wcl_icon                          = get_option('wcl_icon');
                $wcl_icon_size                     = get_option('wcl_icon_size');
                $wcl_text_size                     = get_option('wcl_text_size');

                // Remove the + from the country code
                $code = str_replace("+","",$wcl_whatsapp_number_prefix_code);
                
                // Remove the country name from the country code
                preg_match("/^[\d]+/",$code,$codes);
                $code = $codes[0];
                
                // Remove the first zero
                if($wcl_whatsapp_number[0] == '0')
                    $wcl_whatsapp_number[0] = '';
                
                $wcl_whatsapp_number = preg_replace('/[^0-9]/','',$wcl_whatsapp_number);
                $phone = $code.$wcl_whatsapp_number;

            	if ( wp_is_mobile() ) {
                    
                    // Create the basic URL
                    $whatsapp_link = sprintf("https://api.whatsapp.com/send?phone=%s",$phone);
                    // Append the text messsage
                    if(isset($wcl_whatsapp_text) && !empty($wcl_whatsapp_text))
                        $whatsapp_link = sprintf("%s&text=%s",$whatsapp_link,rawurlencode($wcl_whatsapp_text));

                    if(get_option( 'wcl_trigger_button_text' ) != ""){ ?>
                        <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>"  style="font-size: <?php echo $wcl_text_size.'px'; ?>;">
                                                
                            <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i> <span><?php echo esc_html( apply_filters( 'wcl_trigger_button_text', get_option( 'wcl_trigger_button_text' ) ) ) ?></span>
                        </a>    
                    <?php }else{ ?>
                        <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" target="_blank" style="font-size: <?php echo $wcl_text_size.'px'; ?>; width: inherit; height: inherit; margin: auto;">
                            <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i>    
                        </a>    
                    <?php }     
                } else {
             
                    $whatsapp_link = sprintf("https://web.whatsapp.com/send?phone=%s",$phone);
                    // Append the text messsage
                    if(isset($wcl_whatsapp_text) && !empty($wcl_whatsapp_text))
                        $whatsapp_link = sprintf("%s&text=%s",$whatsapp_link,rawurlencode($wcl_whatsapp_text));

                    if(get_option( 'wcl_trigger_button_text' ) != ""){ ?>
                        <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" onclick="window.open('<?php echo esc_url( $whatsapp_link ) ?>','newwindow','width=750,height=600'); return false;" style="font-size: <?php echo $wcl_text_size.'px'; ?>;">
                                                
                            <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i> <span><?php echo esc_html( apply_filters( 'wcl_trigger_button_text', get_option( 'wcl_trigger_button_text' ) ) ) ?></span>
                        </a>    
                    <?php }else{ ?>
                        <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" onclick="window.open('<?php echo esc_url( $whatsapp_link ) ?>','newwindow','width=750,height=600'); return false;" style="font-size: <?php echo $wcl_text_size.'px'; ?>; width: inherit; height: inherit; margin: auto;">
                            <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i>    
                        </a>    
                    <?php }
                }
            ?>
        </div>
        <div class="wcl-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->

</div>
