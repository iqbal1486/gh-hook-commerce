<div id="gh-default-layout" class="gh-popup-container gh-popup-container--position">

    <!-- .Popup footer -->
    <div class="gh-popup__footer">

        <!-- Popup open button -->
        <div class="gh-popup__open-btn gh-popup-group-invitation__button gh-shadow gh--text-color gh--bg-color">
            <?php
                $gh_whatsapp_number_prefix_code   = get_option('gh_whatsapp_number_prefix_code');
                $gh_whatsapp_number               = get_option('gh_whatsapp_number');
                $gh_whatsapp_text                 = get_option('gh_whatsapp_text');
                $gh_bitly_whatsapp_desktop        = get_option('gh_bitly_whatsapp_desktop');
                $gh_bitly_whatsapp_mobile         = get_option('gh_bitly_whatsapp_mobile');
                $gh_icon                          = get_option('gh_icon');
                $gh_icon_size                     = get_option('gh_icon_size');
                $gh_text_size                     = get_option('gh_text_size');

                // Remove the + from the country code
                $code = str_replace("+","",$gh_whatsapp_number_prefix_code);
                
                // Remove the country name from the country code
                preg_match("/^[\d]+/",$code,$codes);
                $code = $codes[0];
                
                // Remove the first zero
                if($gh_whatsapp_number[0] == '0')
                    $gh_whatsapp_number[0] = '';
                
                $gh_whatsapp_number = preg_replace('/[^0-9]/','',$gh_whatsapp_number);
                $phone = $code.$gh_whatsapp_number;

            	if ( wp_is_mobile() ) {
                    
                    // Create the basic URL
                    $whatsapp_link = sprintf("https://api.whatsapp.com/send?phone=%s",$phone);
                    // Append the text messsage
                    if(isset($gh_whatsapp_text) && !empty($gh_whatsapp_text))
                        $whatsapp_link = sprintf("%s&text=%s",$whatsapp_link,rawurlencode($gh_whatsapp_text));

                    if(get_option( 'gh_trigger_button_text' ) != ""){ ?>
                        <a class="gh-product-query-btn gh--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>"  style="font-size: <?php echo $gh_text_size.'px'; ?>;">
                                                
                            <i class="<?php echo $gh_icon; ?> gh-popup__open-icon" style="font-size: <?php echo $gh_icon_size.'px'; ?>;"  aria-hidden="true"></i> <span><?php echo esc_html( apply_filters( 'gh_trigger_button_text', get_option( 'gh_trigger_button_text' ) ) ) ?></span>
                        </a>    
                    <?php }else{ ?>
                        <a class="gh-product-query-btn gh--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" target="_blank" style="font-size: <?php echo $gh_text_size.'px'; ?>; width: inherit; height: inherit; margin: auto;">
                            <i class="<?php echo $gh_icon; ?> gh-popup__open-icon" style="font-size: <?php echo $gh_icon_size.'px'; ?>;"  aria-hidden="true"></i>    
                        </a>    
                    <?php }     
                } else {
             
                    $whatsapp_link = sprintf("https://web.whatsapp.com/send?phone=%s",$phone);
                    // Append the text messsage
                    if(isset($gh_whatsapp_text) && !empty($gh_whatsapp_text))
                        $whatsapp_link = sprintf("%s&text=%s",$whatsapp_link,rawurlencode($gh_whatsapp_text));

                    if(get_option( 'gh_trigger_button_text' ) != ""){ ?>
                        <a class="gh-product-query-btn gh--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" onclick="window.open('<?php echo esc_url( $whatsapp_link ) ?>','newwindow','width=750,height=600'); return false;" style="font-size: <?php echo $gh_text_size.'px'; ?>;">
                                                
                            <i class="<?php echo $gh_icon; ?> gh-popup__open-icon" style="font-size: <?php echo $gh_icon_size.'px'; ?>;"  aria-hidden="true"></i> <span><?php echo esc_html( apply_filters( 'gh_trigger_button_text', get_option( 'gh_trigger_button_text' ) ) ) ?></span>
                        </a>    
                    <?php }else{ ?>
                        <a class="gh-product-query-btn gh--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" onclick="window.open('<?php echo esc_url( $whatsapp_link ) ?>','newwindow','width=750,height=600'); return false;" style="font-size: <?php echo $gh_text_size.'px'; ?>; width: inherit; height: inherit; margin: auto;">
                            <i class="<?php echo $gh_icon; ?> gh-popup__open-icon" style="font-size: <?php echo $gh_icon_size.'px'; ?>;"  aria-hidden="true"></i>    
                        </a>    
                    <?php }
                }
            ?>
        </div>
        <div class="gh-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->

</div>
