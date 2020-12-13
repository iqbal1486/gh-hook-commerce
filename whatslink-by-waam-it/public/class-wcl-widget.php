<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class WCL_Widget {

    public function __construct() {
        add_action( 'wp_footer', array( $this, 'display_whatsapp_button' ) );
    }

    public function display_whatsapp_button() {
        if ( true !== apply_filters( 'wcl_display_widget_on_current_page', $this->disable_whatsapp_button() ) ) {
            return;
        }

        $layout_path    = WCL_PLUGIN_PATH . 'templates/wcl-template.php';
        require_once apply_filters( 'wcl_template_path', $layout_path );
    }

    public function disable_whatsapp_button() {
        if ( true === wp_is_mobile() && 'yes' !== get_option( 'wcl_display_on_mobile' ) ) {
            return false;
        }
        if ( ! wp_is_mobile() && 'yes' !== get_option( 'wcl_display_on_desktop' ) ) {
            return false;
        }
        
        return true;
    }
}

$wss_widget = new WCL_Widget;