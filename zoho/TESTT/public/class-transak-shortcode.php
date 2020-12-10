<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class TRANSAK_Shortcode {

    public function __construct() {
       
        /*This is disable now*/
        add_shortcode( 'transak_widget', array( $this, 'display_transak_widget_callback' ) );
        add_shortcode( 'transak_conversion_form', array( $this, 'display_transak_conversion_form_callback' ) );
    }


    public function display_transak_widget_callback($atts) {
    	$atts_value = shortcode_atts( array(
			'redirect_to' 	=> '',
			'bar' 			=> 'something else',
		), $atts );
    	
    	ob_start();
	        $layout_path    = TRANSAK_PLUGIN_PATH . 'templates/transak-widget.php';
	        require_once apply_filters( 'transak_template_path', $layout_path );
        return ob_get_clean();
    }


    public function display_transak_conversion_form_callback($atts) {
        $atts_value = shortcode_atts( array(
            'redirect_to'   => '',
            'bar'           => 'something else',
        ), $atts );
        
        ob_start();
            $layout_path    = TRANSAK_PLUGIN_PATH . 'templates/transak-conversion-form.php';
            require_once apply_filters( 'transak_template_path', $layout_path );
        return ob_get_clean();
    }

}

$transak_front_form = new TRANSAK_Shortcode;