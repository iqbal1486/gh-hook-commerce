<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

final class ABRAC_Init {

    /**
     * Initialize. 
     */
    public function init() {
        /**
         * Hook: abrac_before_init.
         */
        do_action( 'abrac_before_init' );

        // Set up localisation.
        $this->init_hooks();
        $this->includes();

        /**
         * Hook: abrac_after_init.
         */
        do_action( 'abrac_after_init' );
    }

    public function init_hooks() {
        // Plugin page setting link on "Install plugin page"
        add_filter( 'plugin_action_links_'.plugin_basename( ABRAC_PLUGIN_FILE ), array( $this, 'plugin_page_settings_link' ) );
    }

    /**
    * Includes plugin files.
    */
    public function includes() {
             // Admin classes
        if ( is_admin() ) {
            require_once ABRAC_PLUGIN_PATH . 'admin/class-abrac-admin-settings-api.php';
            require_once ABRAC_PLUGIN_PATH . 'admin/class-abrac-admin-init.php';
            require_once ABRAC_PLUGIN_PATH . 'admin/class-abrac-transaction-table.php';
        }

        require_once ABRAC_PLUGIN_PATH . 'public/class-abrac-enqueue-scripts.php';
        require_once ABRAC_PLUGIN_PATH . 'public/class-abrac-ajax.php';
        require_once ABRAC_PLUGIN_PATH . 'public/class-abrac-form.php';

     }
    
    /**
     * Adding a Settings link to plugin
     */
    public function plugin_page_settings_link( $links ) {
        $links[] = '<a href="' .
            admin_url( 'admin.php?page=abrac-settings' ) .
            '">' . esc_html__( 'Settings' ) . '</a>';
        return $links;
    }
}