<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

final class WPGP_Init {

    /**
     * Initialize. 
     */
    public function init() {
        /**
         * Hook: wpgp_before_init.
         */
        do_action( 'wpgp_before_init' );

        $this->init_hooks();
        $this->wpgp_includes();

        /**
         * Hook: wpgp_after_init.
         */
        do_action( 'wpgp_after_init' );
    }

    public function init_hooks() {
        // Plugin page setting link on "Install plugin page"
        add_filter( 'plugin_action_links_'.plugin_basename( WPGP_PLUGIN_FILE ), array( $this, 'wpgp_plugin_page_settings_link' ) );
    }


    /**
    * Includes plugin files.
    */
    public function wpgp_includes() {

            // Admin classes
            if ( is_admin() ) {
                //require_once WPGP_PLUGIN_PATH . 'admin/class-wpgp-cpt-init.php';
                require_once WPGP_PLUGIN_PATH . 'admin/class-wpgp-admin-settings-api.php';
                require_once WPGP_PLUGIN_PATH . 'admin/class-wpgp-admin-init.php';
            }
        
                
            //require_once WPGP_PLUGIN_PATH . 'api/simple_html_dom.php';
            //require_once WPGP_PLUGIN_PATH . 'api/class-scrapper-api.php';
            require_once WPGP_PLUGIN_PATH . 'public/class-wpgp-widget.php';    
           
    }


    /**
     * Adding a Settings link to plugin
     */
    public function wpgp_plugin_page_settings_link( $links ) {
        $links[] = '<a href="' .
            admin_url( 'admin.php?page=wpgp-review-settings' ) .
            '">' . esc_html__( 'Settings' ) . '</a>';
        return $links;
    }

}