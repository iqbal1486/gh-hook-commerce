<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Add plugin menus
 * @author WeCreativez
 * @since 1.2
 */
class TRANSAK_Admin_Init {

    public function __construct() {
        $this->settings_api = new TRANSAK_Admin_Settings_API;
        
        add_action('admin_head', array( $this, 'transak_admin_css' ) );

        add_action( 'admin_init', array( $this, 'init_settings' ), 20 );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    public function transak_admin_css() {
      echo '<style>
            a.toplevel_page_transak-settings div.dashicons-before{margin:4px !important; height:25px !important;}
            a.toplevel_page_transak-settings img{width: inherit; padding:0px 0px 0px 0px !important; height: 100% !important}
            .toplevel_page_transak-settings a .wp-menu-image img { width: auto; filter: saturate(0) invert(1); }
      </style>';
    }

    public function init_settings() {

        $sections_label = array();

        
        $sections_label[] =     array(
                                    'id'    => 'transak_basic_settings',
                                    'title' => __( 'Basic Settings', 'wp-crypto' ),
                                );


        $sections_label[] =     array(
                                    'id'    => 'transak_settings',
                                    'title' => __( 'Transak Settings', 'wp-crypto' ),
                                );
        
        $sections_label[] =     array(
                                    'id'    => 'transak_how_to',
                                    'title' => __( 'How to Use', 'wp-crypto' ),
                                    'custom_page' => TRANSAK_PLUGIN_PATH . 'admin/views/how-to-use.php',
                                );

        
        $sections = apply_filters( 'transak_admin_setting_sections', $sections_label );

        $fields = apply_filters( 'transak_admin_setting_fields', array(
            'transak_basic_settings'        => include_once TRANSAK_PLUGIN_PATH . 'admin/views/admin-basic-settings.php',
            'transak_settings'        => include_once TRANSAK_PLUGIN_PATH . 'admin/views/admin-transak-settings.php',

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
            esc_html__( 'Transak', 'wp-crypto' ),
            esc_html__( 'Transak', 'wp-crypto' ),
            'manage_options',
            'transak-settings',
            array( $this, 'admin_setting_page' ),
            'dashicons-money-alt',
            NULL
        );

    }

    // Admin general setting page.
    public function admin_setting_page() {
        echo '<div class="wrap">';
            echo '<h1>' . esc_html__( 'Transak Settings', 'wp-crypto' ) . '</h1>';
                settings_errors();
                do_action( 'transak_admin_notifications' );
            echo '<hr>';
                $this->settings_api->show_navigation();
                $this->settings_api->show_forms();
        echo '</div>';
    }

} // End of TRANSAK_Admin_Init class

// Init the class
$transak_admin_init = new TRANSAK_Admin_Init;