<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

final class TRANSAK_Init {

    public function init() {
        $this->init_hooks();
        $this->includes();
    }

    public function init_hooks() {
        // Plugin page setting link on "Install plugin page"
        add_filter( 'plugin_action_links_'.plugin_basename( TRANSAK_PLUGIN_FILE ), array( $this, 'plugin_page_settings_link' ) );
    }

    /**
    * Includes plugin files.
    */
    public function includes() {
             // Admin classes
        if ( is_admin() ) {
            require_once TRANSAK_PLUGIN_PATH . 'admin/class-transak-admin-settings-api.php';
            require_once TRANSAK_PLUGIN_PATH . 'admin/class-transak-admin-init.php';
            require_once TRANSAK_PLUGIN_PATH . 'admin/class-transak-transaction-table.php';
        }

        require_once TRANSAK_PLUGIN_PATH . 'public/class-transak-enqueue-scripts.php';
        require_once TRANSAK_PLUGIN_PATH . 'public/class-transak-ajax.php';
        require_once TRANSAK_PLUGIN_PATH . 'public/class-transak-form.php';
        require_once TRANSAK_PLUGIN_PATH . 'class-transak-webhook-init.php';
     }
    
    /**
     * Adding a Settings link to plugin
     */
    public function plugin_page_settings_link( $links ) {
        $links[] = '<a href="' .
            admin_url( 'admin.php?page=transak-settings' ) .
            '">' . esc_html__( 'Settings' ) . '</a>';
        return $links;
    }
}