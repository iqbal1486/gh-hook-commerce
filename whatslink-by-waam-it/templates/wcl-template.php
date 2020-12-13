<div id="wcl-default-layout" class="wcl-popup-container wcl-popup-container--position">

    <!-- .Popup footer -->
    <div class="wcl-popup__footer">

        <!-- Popup open button -->
        <div class="wcl-popup__open-btn wcl-popup-group-invitation__button wcl-shadow wcl--text-color wcl--bg-color">
            <?php
                $wcl_whatsapp_number_prefix_code   = get_option('wcl_whatsapp_number_prefix_code');
                $wcl_whatsapp_number               = get_option('wcl_whatsapp_number');
                $wcl_whatsapp_text                 = get_option('wcl_whatsapp_text');
                $wcl_bitly_enable                  = get_option('wcl_bitly_enable');
                $wcl_bitly_whatsapp_desktop        = get_option('wcl_bitly_whatsapp_desktop');
                $wcl_bitly_whatsapp_mobile         = get_option('wcl_bitly_whatsapp_mobile');
                $wcl_icon                          = get_option('wcl_icon');
                $wcl_icon_size                     = get_option('wcl_icon_size');
                $wcl_text_size                     = get_option('wcl_text_size');


            	if ( wp_is_mobile() ) {
                    //$link             =  "https://api.whatsapp.com/send?phone={$a['number']}&text={$a['message']}";
                    //$whatsapp_link    =  apply_filters( 'wcl_product_query_mobile_link', $link, $a['number'], $a['message'] ); 
                    $whatsapp_link = $wcl_bitly_whatsapp_mobile;
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
                    //$link             = "https://web.whatsapp.com/send?phone={$a['number']}&text={$a['message']}";
                    //$whatsapp_link    = apply_filters( 'wcl_product_query_desktop_link', $link, $a['number'], $a['message'] );
                    $whatsapp_link = $wcl_bitly_whatsapp_desktop;
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

            <?php /*
            if(get_option( 'wcl_trigger_button_text' ) != ""){ ?>
                <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" onclick="window.open('<?php echo esc_url( $whatsapp_link ) ?>','newwindow','width=750,height=600'); return false;" style="font-size: <?php echo $wcl_text_size.'px'; ?>;">
                                		
                    <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i> <span><?php echo esc_html( apply_filters( 'wcl_trigger_button_text', get_option( 'wcl_trigger_button_text' ) ) ) ?></span>
                </a>    
            <?php }else{ ?>
                <a class="wcl-product-query-btn wcl--text-color" href="<?php echo esc_url( $whatsapp_link ) ?>" target="_blank" style="font-size: <?php echo $wcl_text_size.'px'; ?>; width: inherit; height: inherit; margin: auto;">
                    <i class="<?php echo $wcl_icon; ?> wcl-popup__open-icon" style="font-size: <?php echo $wcl_icon_size.'px'; ?>;"  aria-hidden="true"></i>    
                </a>    
            <?php } */?>
            
        </div>
        <div class="wcl-clearfix"></div>
        <!-- .Popup open button -->

    </div>
    <!-- Popup footer -->

</div>
