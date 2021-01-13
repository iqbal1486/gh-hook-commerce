<?php
return apply_filters( 'wpgp_appearance_settings', array(

    'wpgp_widget_status' => array(
        'title'    => __( 'Enable', 'wpgp' ),
        'desc'     => __( 'Enable/ Disable', 'wpgp' ),
        'desc_tip' => __( 'Enable/ Disable plugin feature on your website.', 'wpgp' ),
        'id'       => 'wpgp_widget_status',
        'default'  => 'yes',
        'type'     => 'checkbox',
    ),


    'wpgp_recommend_review' => array(
        'title'    => __( 'Enable Recommend Reviews', 'wpgp' ),
        'desc'     => __( 'Enable/ Disable', 'wpgp' ),
        'desc_tip' => __( 'Enable/ Disable Recommend Reviews above review listing.', 'wpgp' ),
        'id'       => 'wpgp_recommend_review',
        'default'  => 'yes',
        'type'     => 'checkbox',
    ),

    'wpgp_review_style' => array(
        'title'    => __( 'Review style', 'wpgp' ),
        'desc_tip' => __( 'Select the style of the review. Masonary or Carousel', 'wpgp' ),
        'id'       => 'wpgp_review_style',
        'default'  => 'yes',
        'type'     => 'select',
        'options'  => array(
            'masonary'  => __( 'Masonary', 'wpgp' ),
            'carousel'  => __( 'Carousel', 'wpgp' ),
        ),
    ),

    'wpgp_name_color'  => array(
        'title'    => __( 'Name Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change color of Name text.', 'wpgp' ),
        'id'       => 'wpgp_name_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_rating_color'  => array(
        'title'    => __( 'Rating Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change the color of rating view.', 'wpgp' ),
        'id'       => 'wpgp_rating_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_description_color'  => array(
        'title'    => __( 'Description Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change the color of Description text.', 'wpgp' ),
        'id'       => 'wpgp_description_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_city_color'  => array(
        'title'    => __( 'City Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change the color of City text.', 'wpgp' ),
        'id'       => 'wpgp_city_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_date_color'  => array(
        'title'    => __( 'Date Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change the color of Date text.', 'wpgp' ),
        'id'       => 'wpgp_date_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_background_color'  => array(
        'title'    => __( 'Background Color', 'wpgp' ),
        'desc_tip' => __( 'Select color to change the background color of single article.', 'wpgp' ),
        'id'       => 'wpgp_background_color',
        'default'  => '#22c15e',
        'type'     => 'color',
    ),

    'wpgp_custom_css' => array(
        'title'    => __( 'Custom CSS', 'wpgp' ),
        'desc_tip' => __( 'Enter your custom CSS.', 'wpgp' ),
        'id'       => 'wpgp_custom_css',
        'type'     => 'textarea',
        'class'    => 'regular-text',
        'css'      => 'height:200px;background:#263238;color:#fff;font-size:13px;width:520px;max-width:100%;',
    ),
) );