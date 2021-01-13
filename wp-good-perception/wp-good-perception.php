<?php
    /*
    Plugin Name: WP Good Perception
    Plugin URI: https://www.demo.com/en
    Description: WordPress Good Perception
    Author: Demo
    Version: 1.0.0
    */
    /*
        AMHARIC
        ARABIC
        BENGALI
        CHINESE
        GREEK
        GUJARATI
        HINDI
        KANNADA
        MALAYALAM
        MARATHI
        NEPALI
        ORIYA
        PERSIAN
        PUNJABI
        RUSSIAN
        SANSKRIT
        SERBIAN
        SINHALESE
        TAMIL
        TELUGU
        TIGRINYA
        URDU
    Gujarati Type Writter :  [wpgpwidget category="transliterate" module="transliterate" language="GUJARATI"]



    Age Comparision : [wpgpwidget  module="age-comparision"]


    Character counter : [wpgpwidget  module="character-counter"]


    CSV to json : [wpgpwidget  module="csv-to-json"]


    HD Capacity : [wpgpwidget  module="hd-capacity"]


    Interest saving : [wpgpwidget  module="interest-saving"]

    json formatter : [wpgpwidget  module="json-formatter"]

    Loan Amortization : [wpgpwidget  module="loan-amortization"]


    Loan calculator : [wpgpwidget  module="loan-calculation"]

    Marks percentage : [wpgpwidget  module="marks-percentage"] Pending

    Scientific Calculator : [wpgpwidget  module="scientificcalculator"]

    xml to json : [wpgpwidget  module="xml-to-json"]

    */
    
    // Preventing to direct access
    defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

    if ( ! defined( 'WPGP_PLUGIN_FILE' ) ) {
        define( 'WPGP_PLUGIN_FILE', __FILE__ );
    }

    if ( ! defined( 'WPGP_PLUGIN_PATH' ) ) {
        define( 'WPGP_PLUGIN_PATH', plugin_dir_path( WPGP_PLUGIN_FILE ) );
    }

    if ( ! defined( 'WPGP_PLUGIN_URL' ) ) {
        define( 'WPGP_PLUGIN_URL', plugin_dir_url( WPGP_PLUGIN_FILE ) );
    }

    if ( ! defined( 'WPGP_PLUGIN_VER' ) ) {
        define( 'WPGP_PLUGIN_VER', '1.0.0'.rand() );
    }

    // Load plugin with plugins_load
    function wpgp_init() {
        require_once WPGP_PLUGIN_PATH . 'class-wpgp-init.php';
        $wpgp_init = new WPGP_Init;
        $wpgp_init->init();
    }
    add_action( 'plugins_loaded', 'wpgp_init', 20 );



    /*
    *Registration deactivation hook
    */  
    register_deactivation_hook( __FILE__, 'wpgp_deactivate_callback' ); 
 
    function wpgp_deactivate_callback() {
       
    }

    /*
    *Registration deactivation hook
    */  
    register_activation_hook( __FILE__, 'wpgp_activate_callback' ); 
 
    function wpgp_activate_callback() {
    }
?>
