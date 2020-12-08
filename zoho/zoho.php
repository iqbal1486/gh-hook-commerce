<?php
    /*
    Plugin Name: ZOHO
    Plugin URI: https://www.brightness-group.com/en
    Description: Description for Carboclick Climate Friendly Cart Plugin
    Author: Brightness Group
    Version: 1.0.0
    Author URI: https://www.brightness-group.com/en
    */

    /*
    https://github.com/zoho/zcrm-php-sdk
    */

    /*
        Client ID
        1000.EW8AXMLC4Y52QCO5SE2EDIW2BJVDQM

        Client Secret
        e4d827dd5e50b0c148f8a1cb84fdd87942d7620a40
    */

    // Preventing to direct access
    defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

    
    define('ZOHO_REDIRECT_URI', 'http://localhost/CarbonOnClick/');
    define('ZOHO_CURRENT_USER_EMAIL', 'iqbal.brightnessgroup@gmail.com');


    //define('ZOHO_CLIENT_ID', '1000.EW8AXMLC4Y52QCO5SE2EDIW2BJVDQM'); // Brightness Test
    define('ZOHO_CLIENT_ID', '1000.4DTJJC5XF07HNZ0G5NTIFHMI5NXMYM'); // B2
    
    //define('ZOHO_CLIENT_SECRET', 'e4d827dd5e50b0c148f8a1cb84fdd87942d7620a40'); //GENERAL Brightness Test
    //define('ZOHO_CLIENT_SECRET', '359ba796f3a6ef73280da9b5da4d97cb2565d73353'); //EU
    //define('ZOHO_CLIENT_SECRET', 'e1e374c4922c57eac6a9bae21e7d040e8cdcde5aba'); //AU
    //define('ZOHO_CLIENT_SECRET', '93cf13e7353be5fab59b16a2cd2c29b2557a27a460'); //IN

    define('ZOHO_CLIENT_SECRET', '871a969ab19f5ff3201ed400cd797542d9df834d95'); //GENERAL B2

    /*
    require 'ZohoV2.php';
    require 'zoho_execute.php';
    require 'zoho_redirect.php';
    */
    

    //require 'auth-link.php';
    //require_once 'vendor/zohocrm/php-sdk-archive/samplecodes/module.php';
    //require_once 'vendor/zohocrm/php-sdk-archive/samplecodes/record.php';
    //require_once 'vendor/zohocrm/php-sdk-archive/samplecodes/record.php';
    //require_once 'vendor/zohocrm/php-sdk-archive/samplecodes/record.php';