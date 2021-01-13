<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );


class WPGP_Widget {

    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'shortcode_script_style_callback' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'wpgp_public_dynamic_resources_callback' ) );
        add_shortcode( 'wpgpwidget', array($this, 'wpgp_shortcode_callback') );
    }

    /**
    * Custom css and js
    * @since 1.0
    */
    public function shortcode_script_style_callback() {

        wp_register_style( 'wpgp-owlcarousel-style', WPGP_PLUGIN_URL . 'assets/owlcarousel/assets/owl.carousel.min.css', array(), WPGP_PLUGIN_VER );
        
        wp_register_style( 'wpgp-owl-theme-default-style', WPGP_PLUGIN_URL . 'assets/owlcarousel/assets/owl.theme.default.min.css', array(), WPGP_PLUGIN_VER );
        
        wp_register_style( 'wpgp-jquery-ui', WPGP_PLUGIN_URL . 'assets/css/jquery-ui.css', array(), WPGP_PLUGIN_VER );
        
        wp_register_style( 'wpgp-accrue-css', WPGP_PLUGIN_URL . 'assets/css/accrue.css', array(), WPGP_PLUGIN_VER );
        
        wp_register_style( 'wpgp-scientificcalculator-css', WPGP_PLUGIN_URL . 'assets/css/scientificCalculator.css', array(), WPGP_PLUGIN_VER );

        wp_enqueue_style( 'wpgp-public-style', WPGP_PLUGIN_URL . 'assets/css/wpgp-public-style.css', array(), WPGP_PLUGIN_VER );

        




        wp_register_script( 'wpgp-owlcarousel-script', WPGP_PLUGIN_URL . 'assets/owlcarousel/owl.carousel.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        wp_register_script( 'wpgp-isotope-script', WPGP_PLUGIN_URL . 'assets/masonary/isotope.pkgd.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );


        wp_register_script( 'wpgp-age-comparision', WPGP_PLUGIN_URL . 'assets/js/calculators/age-comparision.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );

        wp_register_script( 'wpgp-marks-percentage', WPGP_PLUGIN_URL . 'assets/js/calculators/marks-percentage.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        
        wp_register_script( 'wpgp-accrue-js', WPGP_PLUGIN_URL . 'assets/js/calculators/jquery.accrue.min.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        wp_register_script( 'wpgp-loan-amortization-js', WPGP_PLUGIN_URL . 'assets/js/calculators/loan-amortization.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );

        wp_register_script( 'wpgp-csv-to-json', WPGP_PLUGIN_URL . 'assets/js/csv-to-json.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        
        wp_register_script( 'wpgp-xml-to-json', WPGP_PLUGIN_URL . 'assets/js/xml-to-json.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        
        wp_register_script( 'wpgp-scientificcalculator-js', WPGP_PLUGIN_URL . 'assets/js/calculators/scientificCalculator.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );

        wp_enqueue_script( 'wpgp-public-script', WPGP_PLUGIN_URL . 'assets/js/wpgp-public-script.js', array( 'jquery' ), WPGP_PLUGIN_VER, true );
        wp_localize_script( 'wpgp-public-script', 'wpgpObj', array(
            'current_page_id'       => get_the_ID(),
            'current_page_url'      => get_permalink(),
            'admin_url'             => admin_url( 'admin-ajax.php?ver=' . uniqid() ),
            'version'               => WPGP_PLUGIN_VER,
        ) );
    }


    public function wpgp_public_dynamic_resources_callback() { 

        $dynamic_css = '';

        // Dynamic bg color
        $dynamic_css .= '.wpgp-masonary h3.wpgp_review_name, .wpgp-rating-display {
            color: ' . esc_html( get_option( 'wpgp_name_color' ) ) . ';
        }';

        $dynamic_css .= '.wpgp_review_rating, .wpgp-rating-upper {
            color: ' . esc_html( get_option( 'wpgp_rating_color' ) ) . ';
        }';

        $dynamic_css .= '.review_timeline .wpgp_review_timeline_time {
            color: ' . esc_html( get_option( 'wpgp_date_color' ) ) . ';
        }';

        $dynamic_css .= '.review__content h3.wpgp_description{
            color: ' . esc_html( get_option( 'wpgp_description_color' ) ) . ';
        }';

        $dynamic_css .= '.wpgp_city {
            color: ' . esc_html( get_option( 'wpgp_city_color' ) ) . ';
        }';

        $dynamic_css .= '.wpgp-background {
            background-color: ' . esc_html( get_option( 'wpgp_background_color' ) ) . ';
        }';

        $dynamic_css .= wp_kses_post( get_option( 'wpgp_custom_css' ) );

        wp_add_inline_style( 'wpgp-public-style', $dynamic_css );
    }    
    /**
    * Plugin shortcode main function
    */
    function wpgp_shortcode_callback($atts) {
        $a = shortcode_atts( array(
            'category'      => 'calculators',
            'module'        => 'age-comparision',
            'language'      => 'GUJARATI',
        ), $atts );

    
    ob_start(); 
        require_once WPGP_PLUGIN_PATH . 'templates/wpgp-widget.php';
    return ob_get_clean();
    }


} // end of WPGP_Widget

$wpgp_widget = new WPGP_Widget;
