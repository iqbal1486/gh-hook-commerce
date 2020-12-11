<?php
return apply_filters( 'transak_text_settings', array(
    
	array(
        'title'     => __( 'Transak Test API Key', 'wp-crypto' ),
        'id'        => 'transak_test_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Live API Key', 'wp-crypto' ),
        'id'        => 'transak_live_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Test API Secret', 'wp-crypto' ),
        'id'        => 'transak_test_api_secret',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak Live API Secret', 'wp-crypto' ),
        'id'        => 'transak_live_api_secret',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),
) );
?>