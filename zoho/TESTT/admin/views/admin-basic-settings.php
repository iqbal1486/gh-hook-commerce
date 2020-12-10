<?php
return apply_filters( 'transak_widget_text_settings', array(
    array(
        'title'     => __( 'Transak API Key', 'wc-transak' ),
        'id'        => 'transak_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Transak API Secret', 'wc-transak' ),
        'id'        => 'transak_api_secret',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),

) );
?>