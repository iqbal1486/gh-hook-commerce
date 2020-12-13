<?php
/*
define('BITLY_API_URL','https://api-ssl.bitly.com/v3/shorten');
define('BITLY_LOGIN','o_480gl7r12b');
define('BITLY_API_KEY','R_a1f3eac13921419d8fe5216550060d24');
*/

return apply_filters( 'wcl_bitly_settings', array(
    array(
        'title'     => __( 'Enable Bitly', 'wc-wcl' ),
        'id'        => 'wcl_bitly_enable',
        'type'      => 'checkbox',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Bitly Login Username', 'wc-wcl' ),
        'id'        => 'wcl_bitly_login',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

   array(
        'title'     => __( 'Bitly API Key', 'wc-wcl' ),
        'id'        => 'wcl_bitly_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),
   /*
   array(
        'title'     => __( 'WhatsApp Bitly Compressed URL for Desktop', 'wc-wcl' ),
        'id'        => 'wcl_bitly_whatsapp_desktop',
        'type'      => 'text',
        'class'     => 'regular-text',
        'desc_tip' 	=> __( 'Copy and paste your direct link on Facebook, LinkedIn, Twitter, blog and online ads in order to receive enquiries via WhatsApp', 'wc-wcl' ),
        'desc' 		=> __( 'Please make sure that you have updated the Phonenummber and Text Message.', 'wc-wcl' ),
        'custom_attributes' => array(
        							'readonly' => 'readonly = "readonly'
        						),
    ),

   array(
        'title'     => __( 'WhatsApp Bitly Compressed URL for Mobile', 'wc-wcl' ),
        'id'        => 'wcl_bitly_whatsapp_mobile',
        'type'      => 'text',
        'class'     => 'regular-text',
        'desc_tip' 	=> __( 'Copy and paste your direct link on Facebook, LinkedIn, Twitter, blog and online ads in order to receive enquiries via WhatsApp', 'wc-wcl' ),
        'desc' 		=> __( 'Please make sure that you have updated the Phonenummber and Text Message.', 'wc-wcl' ),
        'custom_attributes' => array(
        							'readonly' => 'readonly = "readonly'
        						),
    ),
    */
) );