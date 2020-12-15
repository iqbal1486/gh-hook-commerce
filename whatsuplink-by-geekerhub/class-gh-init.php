<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

final class WCL_Init {

    /**
     * Initialize. 
     */
    public function init() {
        /**
         * Hook: gh_before_init.
         */
        do_action( 'gh_before_init' );

        $this->init_hooks();
        $this->includes();

        /**
         * Hook: gh_after_init.
         */
        do_action( 'gh_after_init' );
    }

    public function init_hooks() {
        // Plugin page setting link on "Install plugin page"
        add_filter( 'plugin_action_links_'.plugin_basename( WCL_PLUGIN_FILE ), array( $this, 'plugin_page_settings_link' ) );
    }

    /**
    * Includes plugin files.
    */
    public function includes() {
             // Admin classes
        if ( is_admin() ) {
            require_once WCL_PLUGIN_PATH . 'admin/class-gh-admin-settings-api.php';
            require_once WCL_PLUGIN_PATH . 'admin/class-gh-admin-init.php';
        }

        require_once WCL_PLUGIN_PATH . 'public/class-gh-widget.php';
        require_once WCL_PLUGIN_PATH . 'public/class-gh-enqueue-scripts.php';

     }


    /**
     * Adding a Settings link to plugin
     */
    public function plugin_page_settings_link( $links ) {
        $links[] = '<a href="' .
            admin_url( 'admin.php?page=wc-whatsapp-support' ) .
            '">' . esc_html__( 'Settings' ) . '</a>';
        return $links;
    }
}