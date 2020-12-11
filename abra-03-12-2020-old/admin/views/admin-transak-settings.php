<?php
return apply_filters( 'abrac_transak_text_settings', array(
    
	array(
        'title'     => __( 'Transak Test API Key', 'wc-abrac' ),
        'id'        => 'abrac_transak_test_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Live API Key', 'wc-abrac' ),
        'id'        => 'abrac_transak_live_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Test API Secret', 'wc-abrac' ),
        'id'        => 'abrac_transak_test_api_secret',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Live API Secret', 'wc-abrac' ),
        'id'        => 'abrac_transak_live_api_secret',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),
) );
?>