<?php
return apply_filters( '', array(
    
    'wcl_x_axis_offset'             => array(
        'title'             => __( 'X-axis Offset', 'wc-wcl' ),
        'desc'              => __( 'In px ( pixels ) only. Default 12px.', 'wc-wcl' ),
        'desc_tip'          => __( 'Enter the value of x-axis ( horizontal ) widget spacing.', 'wc-wcl' ),
        'id'                => 'wcl_x_axis_offset',
        'default'           => '12',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),
    
    'wcl_y_axis_offset'             => array(
        'title'             => __( 'Y-axis Offset', 'wc-wcl' ),
        'desc'              => __( 'In px ( pixels ) only. Default 12px.', 'wc-wcl' ),
        'desc_tip'          => __( 'Enter the value of y-axis ( vertical ) widget spacing.', 'wc-wcl' ),
        'id'                => 'wcl_y_axis_offset',
        'default'           => '12',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),
    
    'wcl_display_on_desktop'        => array(
        'title'    => __( 'Display On Desktop', 'wc-wcl' ),
        'desc_tip' => __( 'Display on desktop/laptop', 'wc-wcl' ),
        'id'       => 'wcl_display_on_desktop',
        'default'  => 'yes',
        'type'     => 'select',
        'options'  => array(
            'yes' => __( 'Yes', 'wc-wcl' ),
            'no'  => __( 'No', 'wc-wcl' ),
        ),
    ),
    
    'wcl_desktop_location'          => array(
        'desc'    => __( 'Select the location of the widget on desktop.', 'wc-wcl' ),
        'id'      => 'wcl_desktop_location',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'tl' => __( 'Top Left', 'wc-wcl' ),
            'tc' => __( 'Top Center', 'wc-wcl' ),
            'tr' => __( 'Top Right', 'wc-wcl' ),
            'bl' => __( 'Bottom Left', 'wc-wcl' ),
            'bc' => __( 'Bottom Center', 'wc-wcl' ),
            'br' => __( 'Bottom Right', 'wc-wcl' ),
        ),
    ),
    
    'wcl_display_on_mobile'         => array(
        'title'    => __( 'Display On Mobile', 'wc-wcl' ),
        'desc_tip' => __( 'Display on mobile devices', 'wc-wcl' ),
        'id'       => 'wcl_display_on_mobile',
        'default'  => 'yes',
        'type'     => 'select',
        'options'  => array(
            'yes' => __( 'Yes', 'wc-wcl' ),
            'no'  => __( 'No', 'wc-wcl' ),
        ),
    ),
    
    'wcl_mobile_location'           => array(
        'desc'    => __( 'Select the location of the widget on mobile.', 'wc-wcl' ),
        'id'      => 'wcl_mobile_location',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'tl' => __( 'Top Left', 'wc-wcl' ),
            'tc' => __( 'Top Center', 'wc-wcl' ),
            'tr' => __( 'Top Right', 'wc-wcl' ),
            'bl' => __( 'Bottom Left', 'wc-wcl' ),
            'bc' => __( 'Bottom Center', 'wc-wcl' ),
            'br' => __( 'Bottom Right', 'wc-wcl' ),
            'bs' => __( 'Bottom Stripe', 'wc-wcl' ),
        ),
    ),

    'wcl_bottom_stripe_height'             => array(
        'title'             => __( 'Height of Stripe for Mobile', 'wc-wcl' ),
        'desc'              => __( 'In px ( pixels ) only. Default 50px.', 'wc-wcl' ),
        'id'                => 'wcl_bottom_stripe_height',
        'default'           => '50',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '500',
        ),
    ),


    'wcl_icon'           => array(
        'title'    => __( 'Select Icon', 'wc-wcl' ),
        //'desc'      => __( 'Select the location of the widget on mobile.', 'wc-wcl' ),
        'id'        => 'wcl_icon',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'fa fa-whatsapp'   => __( 'WhatsApp', 'wc-wcl' ),
            'fa fa-star'       => __( 'Star', 'wc-wcl' ),
            'fa fa-heart'      => __( 'Heart', 'wc-wcl' ),
            'fa fa-envelope-o' => __( 'Envelop', 'wc-wcl' ),
            'fa fa-plane'      => __( 'Plane', 'wc-wcl' ),
            'fa fa-trophy'     => __( 'Trophy', 'wc-wcl' ),
            'fa fa-bell-o'     => __( 'Bell', 'wc-wcl' ),
            'fa fa-diamond'    => __( 'Diamond', 'wc-wcl' ),
            'fa fa-hand-paper-o'   => __( 'Hand Paper', 'wc-wcl' ),
            'fa fa-hand-peace-o'   => __( 'Hand Peace', 'wc-wcl' ),
            'fa fa-commenting'     => __( 'Commenting', 'wc-wcl' ),
            'fa fa-check'          => __( 'Check', 'wc-wcl' ),
            'fa fa-check-circle'   => __( 'Check Circle', 'wc-wcl' ),
            'fa fa-comment'        => __( 'Comment', 'wc-wcl' ),
            'fa fa-comments'       => __( 'Comments', 'wc-wcl' ),
            'fa fa-heart-o'        => __( 'Heart', 'wc-wcl' ),
        ),
    ),


    'wcl_icon_size'             => array(
        'title'             => __( 'Font Size of Icon', 'wc-wcl' ),
        'desc'              => __( 'In px ( pixels ) only. Default 15px.', 'wc-wcl' ),
        'id'                => 'wcl_icon_size',
        'default'           => '15',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),

    'wcl_text_size'             => array(
        'title'             => __( 'Font Size of Text', 'wc-wcl' ),
        'desc'              => __( 'In px ( pixels ) only. Default 15px.', 'wc-wcl' ),
        'id'                => 'wcl_text_size',
        'default'           => '15',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),

    'wcl_layout_background_color'  => array(
        'title'    => __( 'Layout Background Color', 'wc-wcl' ),
        'desc_tip' => __( 'Set popup layout background color.', 'wc-wcl' ),
        'id'       => 'wcl_layout_background_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),
    'wcl_layout_text_color'        => array(
        'title'    => __( 'Layout Text Color', 'wc-wcl' ),
        'desc_tip' => __( 'Set popup layout text color.', 'wc-wcl' ),
        'id'       => 'wcl_layout_text_color',
        'default'  => '#ffffff',
        'type'     => 'color',
    ),

    
    'wcl_rtl_status'                => array(
        'title'             => __( 'Enable RTL', 'wc-wcl' ),
        'desc'              => __( 'Enable/ Disable', 'wc-wcl' ),
        'desc_tip'          => __( 'You can enable RTL ( Right to Left ) if your website has language like Arabic, Persian and Hebrew.', 'wc-wcl' ),
        'id'                => 'wcl_rtl_status',
        'default'           => 'no',
        'type'              => 'checkbox',
    ),
    
    'wcl_custom_css'                => array(
        'title'    => __( 'Custom CSS', 'wc-wcl' ),
        'desc_tip' => __( 'Enter your custom CSS.', 'wc-wcl' ),
        'id'       => 'wcl_custom_css',
        'type'     => 'textarea',
        'class'    => 'regular-text',
        'css'      => 'height:200px;background:#263238;color:#fff;font-size:13px;width:520px;max-width:100%;',
    ),
) );