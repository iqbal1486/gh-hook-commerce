<?php
return apply_filters( '', array(
    
    'gh_x_axis_offset'             => array(
        'title'             => __( 'X-axis Offset', 'wc-gh' ),
        'desc'              => __( 'In px ( pixels ) only. Default 12px.', 'wc-gh' ),
        'desc_tip'          => __( 'Enter the value of x-axis ( horizontal ) widget spacing.', 'wc-gh' ),
        'id'                => 'gh_x_axis_offset',
        'default'           => '12',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),
    
    'gh_y_axis_offset'             => array(
        'title'             => __( 'Y-axis Offset', 'wc-gh' ),
        'desc'              => __( 'In px ( pixels ) only. Default 12px.', 'wc-gh' ),
        'desc_tip'          => __( 'Enter the value of y-axis ( vertical ) widget spacing.', 'wc-gh' ),
        'id'                => 'gh_y_axis_offset',
        'default'           => '12',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),
    
    'gh_display_on_desktop'        => array(
        'title'    => __( 'Display On Desktop', 'wc-gh' ),
        'desc_tip' => __( 'Display on desktop/laptop', 'wc-gh' ),
        'id'       => 'gh_display_on_desktop',
        'default'  => 'yes',
        'type'     => 'select',
        'options'  => array(
            'yes' => __( 'Yes', 'wc-gh' ),
            'no'  => __( 'No', 'wc-gh' ),
        ),
    ),
    
    'gh_desktop_location'          => array(
        'desc'    => __( 'Select the location of the widget on desktop.', 'wc-gh' ),
        'id'      => 'gh_desktop_location',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'tl' => __( 'Top Left', 'wc-gh' ),
            'tc' => __( 'Top Center', 'wc-gh' ),
            'tr' => __( 'Top Right', 'wc-gh' ),
            'bl' => __( 'Bottom Left', 'wc-gh' ),
            'bc' => __( 'Bottom Center', 'wc-gh' ),
            'br' => __( 'Bottom Right', 'wc-gh' ),
        ),
    ),
    
    'gh_display_on_mobile'         => array(
        'title'    => __( 'Display On Mobile', 'wc-gh' ),
        'desc_tip' => __( 'Display on mobile devices', 'wc-gh' ),
        'id'       => 'gh_display_on_mobile',
        'default'  => 'yes',
        'type'     => 'select',
        'options'  => array(
            'yes' => __( 'Yes', 'wc-gh' ),
            'no'  => __( 'No', 'wc-gh' ),
        ),
    ),
    
    'gh_mobile_location'           => array(
        'desc'    => __( 'Select the location of the widget on mobile.', 'wc-gh' ),
        'id'      => 'gh_mobile_location',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'tl' => __( 'Top Left', 'wc-gh' ),
            'tc' => __( 'Top Center', 'wc-gh' ),
            'tr' => __( 'Top Right', 'wc-gh' ),
            'bl' => __( 'Bottom Left', 'wc-gh' ),
            'bc' => __( 'Bottom Center', 'wc-gh' ),
            'br' => __( 'Bottom Right', 'wc-gh' ),
            'bs' => __( 'Bottom Stripe', 'wc-gh' ),
        ),
    ),

    'gh_bottom_stripe_height'             => array(
        'title'             => __( 'Height of Stripe for Mobile', 'wc-gh' ),
        'desc'              => __( 'In px ( pixels ) only. Default 50px.', 'wc-gh' ),
        'id'                => 'gh_bottom_stripe_height',
        'default'           => '50',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '500',
        ),
    ),


    'gh_icon'           => array(
        'title'    => __( 'Select Icon', 'wc-gh' ),
        //'desc'      => __( 'Select the location of the widget on mobile.', 'wc-gh' ),
        'id'        => 'gh_icon',
        'default' => 'br',
        'type'    => 'select',
        'options' => array(
            'fa fa-whatsapp'   => __( 'WhatsApp', 'wc-gh' ),
            'fa fa-star'       => __( 'Star', 'wc-gh' ),
            'fa fa-heart'      => __( 'Heart', 'wc-gh' ),
            'fa fa-envelope-o' => __( 'Envelop', 'wc-gh' ),
            'fa fa-plane'      => __( 'Plane', 'wc-gh' ),
            'fa fa-trophy'     => __( 'Trophy', 'wc-gh' ),
            'fa fa-bell-o'     => __( 'Bell', 'wc-gh' ),
            'fa fa-diamond'    => __( 'Diamond', 'wc-gh' ),
            'fa fa-hand-paper-o'   => __( 'Hand Paper', 'wc-gh' ),
            'fa fa-hand-peace-o'   => __( 'Hand Peace', 'wc-gh' ),
            'fa fa-commenting'     => __( 'Commenting', 'wc-gh' ),
            'fa fa-check'          => __( 'Check', 'wc-gh' ),
            'fa fa-check-circle'   => __( 'Check Circle', 'wc-gh' ),
            'fa fa-comment'        => __( 'Comment', 'wc-gh' ),
            'fa fa-comments'       => __( 'Comments', 'wc-gh' ),
            'fa fa-heart-o'        => __( 'Heart', 'wc-gh' ),
        ),
    ),


    'gh_icon_size'             => array(
        'title'             => __( 'Font Size of Icon', 'wc-gh' ),
        'desc'              => __( 'In px ( pixels ) only. Default 15px.', 'wc-gh' ),
        'id'                => 'gh_icon_size',
        'default'           => '15',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),

    'gh_text_size'             => array(
        'title'             => __( 'Font Size of Text', 'wc-gh' ),
        'desc'              => __( 'In px ( pixels ) only. Default 15px.', 'wc-gh' ),
        'id'                => 'gh_text_size',
        'default'           => '15',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),

    'gh_layout_background_color'  => array(
        'title'    => __( 'Layout Background Color', 'wc-gh' ),
        'desc_tip' => __( 'Set popup layout background color.', 'wc-gh' ),
        'id'       => 'gh_layout_background_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),
    'gh_layout_text_color'        => array(
        'title'    => __( 'Layout Text Color', 'wc-gh' ),
        'desc_tip' => __( 'Set popup layout text color.', 'wc-gh' ),
        'id'       => 'gh_layout_text_color',
        'default'  => '#ffffff',
        'type'     => 'color',
    ),

    
    'gh_rtl_status'                => array(
        'title'             => __( 'Enable RTL', 'wc-gh' ),
        'desc'              => __( 'Enable/ Disable', 'wc-gh' ),
        'desc_tip'          => __( 'You can enable RTL ( Right to Left ) if your website has language like Arabic, Persian and Hebrew.', 'wc-gh' ),
        'id'                => 'gh_rtl_status',
        'default'           => 'no',
        'type'              => 'checkbox',
    ),
    
    'gh_custom_css'                => array(
        'title'    => __( 'Custom CSS', 'wc-gh' ),
        'desc_tip' => __( 'Enter your custom CSS.', 'wc-gh' ),
        'id'       => 'gh_custom_css',
        'type'     => 'textarea',
        'class'    => 'regular-text',
        'css'      => 'height:200px;background:#263238;color:#fff;font-size:13px;width:520px;max-width:100%;',
    ),
) );