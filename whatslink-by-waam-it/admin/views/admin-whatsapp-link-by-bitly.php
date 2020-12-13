<?php
return apply_filters( 'wcl_bitly_whatsapp_link', array(
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
) );