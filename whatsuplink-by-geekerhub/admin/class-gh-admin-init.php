<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

/**
 * Add plugin menus
 * @author WeCreativez
 * @since 1.2
 */
class WCL_Admin_Init {

    public function __construct() {
        $this->settings_api = new WCL_Admin_Settings_API;
        add_action( 'admin_init', array( $this, 'init_settings' ), 20 );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }


    public function init_settings() {

        $sections_label = array();

        

        $sections_label[] =     array(
                                    'id'    => 'gh_basic_settings',
                                    'title' => __( 'Basic Settings', 'wc-gh' ),
                                );

        $sections_label[] =     array(
                                    'id'    => 'gh_widget_text_settings',
                                    'title' => __( 'Widget Text Settings', 'wc-gh' ),
                                );
        
        
        $sections = apply_filters( 'gh_admin_setting_sections', $sections_label );

        $fields = apply_filters( 'gh_admin_setting_fields', array(
            'gh_basic_settings'        => include_once WCL_PLUGIN_PATH . 'admin/views/admin-basic-settings.php',
            'gh_widget_text_settings'  => include_once WCL_PLUGIN_PATH . 'admin/views/admin-widget-text-settings.php',
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
            esc_html__( 'WhatsLink', 'wc-gh' ),
            esc_html__( 'WhatsLink', 'wc-gh' ),
            'manage_options',
            'gh-whatsapp-contact-link',
            array( $this, 'admin_setting_page' ),
            'dashicons-format-chat',
            NULL
        );
    }

    // Admin general setting page.
    public function admin_setting_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'WAAM-it WhatsLink', 'wc-gh' ) . '</h1>';
        settings_errors();
        do_action( 'gh_admin_notifications' );
        echo '<hr>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }

} // End of WCL_Admin_Init class

// Init the class
$gh_admin_init = new WCL_Admin_Init;