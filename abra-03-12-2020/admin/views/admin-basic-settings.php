<?php
$mypages = get_pages();
$pages_array = array();

foreach( $mypages as $page ) {      
    $pages_array[$page->ID] = $page->post_title;
}   

return apply_filters( 'abrac_widget_text_settings', array(
    array(
        'title'     => __( 'Live ?', 'wc-abrac' ),
        'id'        => 'abrac_live',
        'type'      => 'checkbox',
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Redirect URL', 'wc-abrac' ),
        'id'        => 'abrac_redirect_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Terms URL', 'wc-abrac' ),
        'id'        => 'abrac_terms_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),


    array(
        'title'     => __( 'Privacy URL', 'wc-abrac' ),
        'id'        => 'abrac_privacy_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'KYC URL', 'wc-abrac' ),
        'id'        => 'abrac_kyc_url',
        'type'     => 'select',
        'options'  => $pages_array,
        'class'     => 'regular-text',
    ),

    array(
        'title'     => __( 'Geo Location API Key', 'wc-abrac' ),
        'id'        => 'abrac_geolocation_api_key',
        'type'      => 'text',
        'class'     => 'regular-text',
    ),
    
    array(
        'title'     => __( 'Footer Text', 'wc-abrac' ),
        'id'        => 'abrac_footer_text',
        'type'      => 'wp_editor',
        'class'     => 'regular-text',
        'custom_attributes' => array(
                                    'rows' => 10,
                                ),
    ),

    array(
        'title'     => __( 'Listing Sidebar', 'wc-abrac' ),
        'id'        => 'abrac_listing_sidebar',
        'type'      => 'wp_editor',
        'class'     => 'regular-text',
        'custom_attributes' => array(
                                    'rows' => 10,
                                ),
    ),
) );
?>