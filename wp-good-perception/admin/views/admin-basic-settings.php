<?php ob_start(); ?>
    <a href="#TB_inline?&width=400&height=350&inlineId=wpgp_scrap_data" class="reward-btn thickbox">Scrap Data Manually</a>
    <?php add_thickbox(); ?>

    <div id="wpgp_scrap_data" style="display:none;">
        <div id="thickbox_content">
            <h3>Would you like to scrap data manually</h3>
            <p>Click below button to start scrapping....</p>
              
            <div class="scrap-popup-request-button">
                <button type="button" name="wpgp_scrap_data_manually_btn" class="button" value="wpgp_scrap_data_manually_btn_value">Click to Scrap Data</button>
            </div>

            <div class="notice-success" id="scrap-response">
                
            </div>
        </div>
    </div>
<?php $wpgp_scrap_html_field = ob_get_clean(); 

return apply_filters( '', array(

    'wpgp_show_reviews_greater_then' => array(
        'title'             => __( 'Show Reviews', 'wpgp' ),
        'desc'              => __( 'This will be useful to filter reviews. Default 5', 'wpgp' ),
        'desc_tip'          => __( 'This option will be useful to show the reviews greater than entered number', 'wpgp' ),
        'id'                => 'wpgp_show_reviews_greater_then',
        'default'           => '5',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '10',
        ),
    ),

    'wpgp_review_to_show'    => array(
        'title'             => __( 'Display Reviews', 'wpgp' ),
        'desc'              => __( 'This will be used to display number of reviews as per entered number. Default is 6', 'wpgp' ),
        'id'                => 'wpgp_review_to_show',
        'default'           => '6',
        'type'              => 'number',
        'class'             => 'small-text',
        'custom_attributes' => array(
            'step' => '1',
            'min'  => '0',
            'max'  => '200',
        ),
    ),

    'wpgp_scrapping_interval' => array(
        'title'    => __( 'Scrap Interval', 'wpgp' ),
        'desc_tip' => __( 'When would you like to trigger scrapping? Every Month or every week?', 'wpgp' ),
        'id'       => 'wpgp_scrapping_interval',
        'default'  => 'weekly',
        'type'     => 'select',
        'options'  => array(
            'weekly'    => __( 'Weekly', 'wpgp' ),
            'monthly'   => __( 'Monthly', 'wpgp' ),
        ),
    ),

    'wpgp_company_slug' => array(
        'title'    => __( 'Company Slug', 'wpgp' ),
        'desc_tip' => __( 'What is the company slug in a feedback company url? Whose review you would like to fetch?', 'wpgp' ),
        'id'       => 'wpgp_company_slug',
        'type'     => 'text',
    ),

    'wpgp_scrap_data_manually'   => array(
        'title'    => __( 'Scrap Data', 'wc-wws' ),
        'desc_tip' => __( 'Option to manually scrap data.', 'wc-wws' ),
        'id'       => 'wpgp_scrap_data_manually',
        'default'  => 1,
        'type'     => 'custom',
        'custom'   => $wpgp_scrap_html_field,
    ),
) );
