<?php

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * WCL_Enqueue_Scripts class responsable to load all the scripts and styles.
 */
class WCL_Enqueue_Scripts {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'public_enqueue_scripts' ), 200 );
        add_action( 'wp_enqueue_scripts', array( $this, 'public_dynamic_resources'), 200 );
    }

    public function public_enqueue_scripts() {
        wp_enqueue_style( 'gh-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css', array(), WCL_PLUGIN_VER );
        wp_enqueue_style( 'gh-public-style', WCL_PLUGIN_URL . 'assets/css/gh-public-style.css', array(), WCL_PLUGIN_VER );
        
    }

    public function public_dynamic_resources() { 

        $x_axis_offset = get_option( 'gh_x_axis_offset' );
        $y_axis_offset = get_option( 'gh_y_axis_offset' );

        $dynamic_css = '';

        // Dynamic bg color
        $dynamic_css .= '.gh--bg-color {
            background-color: ' . esc_html( get_option( 'gh_layout_background_color' ) ) . ';
        }';

        // Dynamic text color
        $dynamic_css .= '.gh--text-color {
                color: ' . esc_html( get_option( 'gh_layout_text_color' ) ) . ';
        }';

        // RTL CSS
        if ( 'yes' === get_option( 'gh_rtl_status' ) ) {
            $dynamic_css .= '.gh-popup-container * { direction: rtl; }
                #gh-default-layout .gh-popup__header { 
                    display: flex;
                    flex-direction: row-reverse;
                }
                #gh-default-layout .gh-popup__input-wrapper { float: left; }';

        }
            
   

        // Display only icon CSS
        if ( '' === get_option( 'gh_trigger_button_text' ) ) {
            $dynamic_css .= '.gh-popup__open-btn {
                font-size: 30px;
                border-radius: 50%;
                display: inline-block;
                margin-top: 15px;
                cursor: pointer;
                width: 46px;
                height: 46px;
                position: relative;
            }
            .gh-popup__open-icon {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }';

        } else {
            $dynamic_css .= '.gh-popup__open-btn {
                padding: 8px 20px;
                font-size: 15px;
                border-radius: 20px;
                display: inline-block;
                margin-top: 15px;
                cursor: pointer;
            }';
        }

        // Dynamic CSS according to Mobile
        if ( wp_is_mobile() == true ) {
            
            if ( get_option( 'gh_mobile_location' ) == 'tl' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: left; }';
            }
            
            if ( get_option( 'gh_mobile_location' ) == 'tc' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .gh-popup { margin: 0 auto; }
                .gh-popup__footer { text-align: center; }';
            }
            
            if ( get_option( 'gh_mobile_location' ) == 'tr' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: right; }';
            }

            if ( get_option( 'gh_mobile_location' ) == 'bl' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px;
                }
                .gh-popup__open-btn { float: left; }';
            }
            
            if ( get_option( 'gh_mobile_location' ) == 'bc' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .gh-popup { margin: 0 auto; }
                .gh-popup__footer { text-align: center; }';
            }

            if ( get_option( 'gh_mobile_location' ) == 'br' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: right; }';
            }

            /*Bottom Stripe*/
            if ( get_option( 'gh_mobile_location' ) == 'bs' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    bottom: 0 px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .gh-popup { margin: 0 auto; }
                .gh-popup__footer { text-align: center; }';

                $dynamic_css .= '.gh-popup__open-btn { 
                    width : 100%;
                    height: ' .get_option( 'gh_bottom_stripe_height' ). 'px;
                    margin: 0px;
                    padding: 0px;
                    border-radius: 0px;
                }';

                $dynamic_css .= '.gh-popup__open-btn a.gh-product-query-btn {
                    width: 100%;
                    height: inherit;
                    margin: 0px;
                    padding: 0px;
                }';
            }
        }

        // Dynamic CSS according to Desktop
        if ( wp_is_mobile() != true ) {
            if ( get_option( 'gh_desktop_location' ) == 'tl' ) {
                 $dynamic_css .= '.gh-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: left; }
                .gh-gradient--position {
                  top: 0;
                  left: 0;
                  background: radial-gradient(ellipse at top left, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }

            if ( get_option( 'gh_desktop_location' ) == 'tc' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .gh-popup__footer { text-align: center; }
                .gh-popup { margin: 0 auto; }
                .gh-gradient--position {
                  top: 0;
                  left: 0;
                  right: 0;
                  margin-left: auto;
                  margin-right: auto;
                  background: radial-gradient(ellipse at top, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }
            if ( get_option( 'gh_desktop_location' ) == 'tr' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    top: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: right; }
                .gh-gradient--position {
                  top: 0;
                  right: 0;
                  background: radial-gradient(ellipse at top right, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }
            if ( get_option( 'gh_desktop_location' ) == 'bl' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    left: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: left; }
                .gh-gradient--position {
                  bottom: 0;
                  left: 0;
                  background: radial-gradient(ellipse at bottom left, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }
            if ( get_option( 'gh_desktop_location' ) == 'bc' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                    left: 0; 
                    right: 0; 
                    margin-left: auto; 
                    margin-right: auto; 
                }
                .gh-popup__footer { text-align: center; }
                .gh-popup { margin: 0 auto; }
                .gh-gradient--position {
                  bottom: 0;
                  left: 0;
                  right: 0;
                  margin-left: auto;
                  margin-right: auto;
                  background: radial-gradient(ellipse at bottom, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }
            if ( get_option( 'gh_desktop_location' ) == 'br' ) {
                $dynamic_css .= '.gh-popup-container--position { 
                    right: ' . intval( $x_axis_offset ) . 'px; 
                    bottom: ' . intval( $y_axis_offset ) . 'px; 
                }
                .gh-popup__open-btn { float: right; }
                .gh-gradient--position {
                  bottom: 0;
                  right: 0;
                  background: radial-gradient(ellipse at bottom right, rgba(29, 39, 54, 0.2) 0, rgba(29, 39, 54, 0) 72%);
                }';
            }
        }
     
        $dynamic_css .= wp_kses_post( get_option( 'gh_custom_css' ) );

        wp_add_inline_style( 'gh-public-style', $dynamic_css );
    }
    
} // end of class WCL_Enqueue_Scripts

$gh_enqueue_scripts = new WCL_Enqueue_Scripts;