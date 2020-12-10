<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Add plugin menus
 * @author WeCreativez
 * @since 1.2
 */
class ABRAC_Admin_Init {

    public function __construct() {
        $this->settings_api = new ABRAC_Admin_Settings_API;
        
        add_action('admin_head', array( $this, 'abra_admin_css' ) );

        add_action( 'admin_init', array( $this, 'init_settings' ), 20 );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    public function abra_admin_css() {
      echo '<style>
            a.toplevel_page_abrac-settings div.dashicons-before{margin:4px !important; height:25px !important;}
            a.toplevel_page_abrac-settings img{width: inherit; padding:0px 0px 0px 0px !important; height: 100% !important}
            .toplevel_page_abrac-settings a .wp-menu-image img { width: auto; filter: saturate(0) invert(1); }
      </style>';
    }

    public function init_settings() {

        $sections_label = array();

        
        $sections_label[] =     array(
                                    'id'    => 'abrac_basic_settings',
                                    'title' => __( 'Basic Settings', 'wc-abrac' ),
                                );


        $sections_label[] =     array(
                                    'id'    => 'abrac_transak_settings',
                                    'title' => __( 'Transak Settings', 'wc-abrac' ),
                                );
        
        $sections_label[] =     array(
                                    'id'    => 'abrac_how_to',
                                    'title' => __( 'How to Use', 'wc-abrac' ),
                                    'custom_page' => ABRAC_PLUGIN_PATH . 'admin/views/how-to-use.php',
                                );

        
        $sections = apply_filters( 'abrac_admin_setting_sections', $sections_label );

        $fields = apply_filters( 'abrac_admin_setting_fields', array(
            'abrac_basic_settings'        => include_once ABRAC_PLUGIN_PATH . 'admin/views/admin-basic-settings.php',
            'abrac_transak_settings'        => include_once ABRAC_PLUGIN_PATH . 'admin/views/admin-transak-settings.php',

        ) );

        $this->settings_api->set_sections( $sections );
        $this->settings_api->set_fields( $fields );
        $this->settings_api->admin_init();
    }

    /**
     * Add plugin setting menu on WordPress admin menu
     */
    public function add_admin_menu() {
        add_menu_page(
            esc_html__( 'Abra', 'wc-abrac' ),
            esc_html__( 'Abra', 'wc-abrac' ),
            'manage_options',
            'abrac-settings',
            array( $this, 'admin_setting_page' ),
            //'dashicons-money-alt',
            ABRAC_PLUGIN_URL.'assets/images/abra-logo-white.ico',
            NULL
        );

    }

    // Admin general setting page.
    public function admin_setting_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'Abra Settings', 'wc-abrac' ) . '</h1>';
        settings_errors();
        do_action( 'abrac_admin_notifications' );
        echo '<hr>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }

} // End of ABRAC_Admin_Init class

// Init the class
$abrac_admin_init = new ABRAC_Admin_Init;