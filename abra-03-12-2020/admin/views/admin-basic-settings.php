<?php
$mypages = get_pages();
$pages_array = array();

foreach( $mypages as $page ) {      
    $pages_array[$page->ID] = $page->post_title;
}   

return apply_filters( 'transak_widget_text_settings', array(
    array(
        'title'     => __( 'Live ?', 'wp-crypto' ),
        'id'        => 'transak_live',
        'type'      => 'checkbox',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Redirect URL', 'wp-crypto' ),
        'id'        => 'transak_redirect_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Terms URL', 'wp-crypto' ),
        'id'        => 'transak_terms_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),


    array(
        'title'     => __( 'Privacy URL', 'wp-crypto' ),
        'id'        => 'transak_privacy_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'KYC URL', 'wp-crypto' ),
        'id'        => 'transak_kyc_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

) );
?>