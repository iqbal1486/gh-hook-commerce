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
        
        add_filter( 'update_option_wcl_whatsapp_number_prefix_code', array( $this, 'update_bitly_link'), 10, 2 );
        add_filter( 'update_option_wcl_whatsapp_number', array( $this, 'update_bitly_link'), 10, 2 );
        add_filter( 'update_option_wcl_whatsapp_text', array( $this, 'update_bitly_link'), 10, 2 );
        add_filter( 'update_option_wcl_bitly_enable', array( $this, 'update_bitly_link'), 10, 2 );
        add_filter( 'update_option_wcl_bitly_login', array( $this, 'update_bitly_link'), 10, 2 );
        add_filter( 'update_option_wcl_bitly_api_key', array( $this, 'update_bitly_link'), 10, 2 );
        
        add_action( 'admin_init', array( $this, 'init_settings' ), 20 );
        add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
    }

    function update_bitly_link( $new_value, $old_value ) {
        if ( $new_value !== $old_value && ! empty( $new_value ) ) {
            echo "ssdf";
            exit();
            //update_option( 'some_option_changed', $new_value );
            $code = $wcl_whatsapp_number_prefix_code    = get_option('wcl_whatsapp_number_prefix_code');
            $phone = $wcl_whatsapp_number               = get_option('wcl_whatsapp_number');
            $wcl_whatsapp_text                          = get_option('wcl_whatsapp_text');
            $wcl_bitly_enable                           = get_option('wcl_bitly_enable');
            $BITLY_LOGIN = $wcl_bitly_login             = get_option('wcl_bitly_login');
            $BITLY_API_KEY = $wcl_bitly_api_key         = get_option('wcl_bitly_api_key');
            
            if($wcl_bitly_enable == "yes"){
                $BITLY_LOGIN = $wcl_bitly_login             = get_option('wcl_bitly_login');
                $BITLY_API_KEY = $wcl_bitly_api_key         = get_option('wcl_bitly_api_key');    
            }else{
                $BITLY_LOGIN = $wcl_bitly_login             = 'o_480gl7r12b';
                $BITLY_API_KEY = $wcl_bitly_api_key         = 'R_a1f3eac13921419d8fe5216550060d24';
            }

            // Remove the + from the country code
            $code = str_replace("+","",$wcl_whatsapp_number_prefix_code);
            
            // Remove the country name from the country code
            preg_match("/^[\d]+/",$code,$codes);
            $code = $codes[0];
            
            // Remove the first zero
            if($phone[0] == '0')
                $phone[0] = '';
            
            $phone = preg_replace('/[^0-9]/','',$phone);
            $phone = $code.$phone;
            

            /*BITLY URL GENERATION FOR MOBILE*/
            // Create the basic URL
            $MOBILE_URL = sprintf("https://api.whatsapp.com/send?phone=%s",$phone);
            // Append the text messsage
            if(isset($wcl_whatsapp_text) && !empty($wcl_whatsapp_text))
                $MOBILE_URL = sprintf("%s&text=%s",$MOBILE_URL,rawurlencode($wcl_whatsapp_text));

            $CURL_URL = sprintf("%s?login=%s&apiKey=%s&longUrl=%s",BITLY_API_URL, $BITLY_LOGIN, $BITLY_API_KEY, rawurlencode($MOBILE_URL));
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$CURL_URL);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

            // Get the JSON
            $res = json_decode(curl_exec($ch),true);
            
            // Close cURL
            curl_close($ch);
            $MOBILE_URL_BITLY = $res['data']['url'];
            /*BITLY URL GENERATION FOR MOBILE END*/


            /*BITLY URL GENERATION FOR DESKTOP*/
            // Create the basic URL
            $DESKTOP_URL = sprintf("https://web.whatsapp.com/send?phone=%s",$phone);
            // Append the text messsage
            if(isset($wcl_whatsapp_text) && !empty($wcl_whatsapp_text))
                $DESKTOP_URL = sprintf("%s&text=%s",$DESKTOP_URL,rawurlencode($wcl_whatsapp_text));

            $CURL_URL = sprintf("%s?login=%s&apiKey=%s&longUrl=%s",BITLY_API_URL, $BITLY_LOGIN, $BITLY_API_KEY, rawurlencode($DESKTOP_URL));
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,$CURL_URL);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

            // Get the JSON
            $res = json_decode(curl_exec($ch),true);
            
            // Close cURL
            curl_close($ch);
            $DESKTOP_URL_BITLY = $res['data']['url'];
            /*BITLY URL GENERATION FOR DESKTOP END*/

            update_option( 'wcl_bitly_whatsapp_desktop', $DESKTOP_URL_BITLY );
            update_option( 'wcl_bitly_whatsapp_mobile', $MOBILE_URL_BITLY );
        }

        return $new_value;
    }

    public function init_settings() {

        $sections_label = array();

        /*
        $sections_label[] = array(
                                    'id'          => 'wcl_whatslink_activation',
                                    'title'       => __( 'WhatsLink Activation', 'wc-wcl' ),
                                    'custom_page' => WCL_PLUGIN_PATH . 'admin/views/admin-whatslink-activation.php',
                                );
        */
        if ( 'yes' == get_option( 'wcl_whatslink_active' ) ) {
        
            $sections_label[] = array(
                                        'id'    => 'wcl_bitly_settings',
                                        'title' => __( 'Bitly Settings', 'wc-wcl' ),
                                    );

            $sections_label[] =     array(
                                        'id'    => 'wcl_basic_settings',
                                        'title' => __( 'Basic Settings', 'wc-wcl' ),
                                    );

            $sections_label[] =     array(
                                        'id'    => 'wcl_widget_text_settings',
                                        'title' => __( 'Widget Text Settings', 'wc-wcl' ),
                                    );

            $sections_label[] =     array(
                                        'id'    => 'wcl_whatsapp_link_by_bitly',
                                        'title' => __( 'WhatsApp Link', 'wc-wcl' ),
                                    );
        }
        
        $sections = apply_filters( 'wcl_admin_setting_sections', $sections_label );

        $fields = apply_filters( 'wcl_admin_setting_fields', array(
            'wcl_bitly_settings'        => include_once WCL_PLUGIN_PATH . 'admin/views/admin-bitly-settings.php',
            'wcl_basic_settings'        => include_once WCL_PLUGIN_PATH . 'admin/views/admin-basic-settings.php',
            'wcl_widget_text_settings'  => include_once WCL_PLUGIN_PATH . 'admin/views/admin-widget-text-settings.php',
            'wcl_whatsapp_link_by_bitly'  => include_once WCL_PLUGIN_PATH . 'admin/views/admin-whatsapp-link-by-bitly.php',

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
            esc_html__( 'WhatsLink', 'wc-wcl' ),
            esc_html__( 'WhatsLink', 'wc-wcl' ),
            'manage_options',
            'wcl-whatsapp-contact-link',
            array( $this, 'admin_setting_page' ),
            'dashicons-format-chat',
            NULL
        );
        /*
        add_submenu_page(
            'wcl-whatsapp-contact-link',
            esc_html__( 'FB & GA Analytics', 'wc-wcl' ),
            esc_html__( 'FB & GA Analytics', 'wc-wcl' ),
            'manage_options',
            'wcl-whatsapp-contact-link-fb-ga-analytics',
            array( $this, 'admin_fb_ga_analytics_page' )
        );
        */
    }

    // Admin general setting page.
    public function admin_setting_page() {
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__( 'WAAM-it WhatsLink', 'wc-wcl' ) . '</h1>';
        settings_errors();
        do_action( 'wcl_admin_notifications' );
        echo '<hr>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
    }

} // End of WCL_Admin_Init class

// Init the class
$wcl_admin_init = new WCL_Admin_Init;