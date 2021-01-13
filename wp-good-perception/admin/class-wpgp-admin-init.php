<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );


class WPGP_Admin_Init {

    public function __construct() {
        $this->settings_api = new WPGP_Admin_Settings_API;

        add_action( 'admin_init', array( $this, 'wpgp_init_settings_callback' ), 20 );
        add_action( 'admin_menu', array( $this, 'wpgp_add_admin_menu_callback' ) );
        add_action( 'admin_footer', array( $this, 'wpgp_admin_add_js_callback' ) , 100);
        add_action("wp_ajax_wpgp_scrap_data_manually", array( $this, 'wpgp_scrap_data_manually_callback' ) );
        add_action("wp_ajax_nopriv_wpgp_scrap_data_manually", array( $this, 'wpgp_scrap_data_manually_callback' ) );

    }


    /*
    * ajax callback function to run scrapping function
    */
    public function wpgp_scrap_data_manually_callback() {

        $data = (new WPGP_Scrapper_Init)->scrapper_init();
        
        $result['html'] = "<p><strong>Data scrapped successfully.</strong></p>";

        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
           $result = json_encode($result);
           echo $result;
        }
        else {
           header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
        die();
    }


    public function wpgp_admin_add_js_callback($data) {
        ?>
        <script type="text/javascript">
            jQuery("button[name=wpgp_scrap_data_manually_btn]").on('click', function(e) {
                e.preventDefault();
                jQuery.ajax({
                    type : "post",
                    dataType : "json",
                    url : "<?php echo admin_url( 'admin-ajax.php?ver=' . uniqid() ); ?>",
                    data : {
                            action: "wpgp_scrap_data_manually",                           
                        },
                    success: function(response) {
                        jQuery('#scrap-response').html(response.html);
                    }
                })
            });
        </script>
        <?php
    }

    public function wpgp_init_settings_callback() {
        $sections = apply_filters( 'wpgp_admin_setting_sections', array(
            array(
                'id'    => 'wpgp_appearance_settings',
                'title' => __( 'Appearance', 'wpgp' ),
            ),
            array(
                'id'    => 'wpgp_basic_settings',
                'title' => __( 'Basic Settings', 'wpgp' ),
            ),
        ) );

        $fields = apply_filters( 'wpgp_admin_setting_fields', array(
            'wpgp_appearance_settings' => include_once WPGP_PLUGIN_PATH . 'admin/views/admin-appearance-settings.php',
            'wpgp_basic_settings'      => include_once WPGP_PLUGIN_PATH . 'admin/views/admin-basic-settings.php',
        ) );

        $this->settings_api->set_sections( $sections );
        $this->settings_api->set_fields( $fields );
        $this->settings_api->admin_init();
    }

    /**
     * Add plugin setting menu on WordPress admin menu
     * @since 1.0
     */
    public function wpgp_add_admin_menu_callback() {
        /*
        add_submenu_page(
            'edit.php?post_type=wpgp_review',
            esc_html__( 'WPGP Reviews Settings', 'wpgp' ),
            esc_html__( 'WPGP Reviews Settings', 'wpgp' ),
            'manage_options',
            'wpgp-review-settings',
            array( $this, 'admin_setting_page' ),
            'dashicons-format-chat',
            NULL
        );
        */

        add_menu_page(
            esc_html__( 'WPGP Settings', 'wpgp' ),
            esc_html__( 'WPGP Settings', 'wpgp' ),
            'manage_options',
            'wpgp-review-settings',
            array( $this, 'admin_setting_page' ),
            'dashicons-format-chat',
            NULL
        );
    }

    // Admin general setting page.
    public function admin_setting_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'WPGP Reviews', 'wpgp' ) . '</h1>';
        settings_errors();
        do_action( 'wpgp_admin_notifications' );
        echo '<hr>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }
   
} // End of WPGP_Admin_Init class

// Init the class
$wpgp_admin_init = new WPGP_Admin_Init;