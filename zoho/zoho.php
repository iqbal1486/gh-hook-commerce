<?php
    /*
    Plugin Name: ZOHO
    Plugin URI: https://www.brightness-group.com/en
    Description: Description for Carboclick Climate Friendly Cart Plugin
    Author: Brightness Group
    Version: 1.0.0
    Author URI: https://www.brightness-group.com/en
    */
    use zcrmsdk\oauth\ZohoOAuth;

    use zcrmsdk\crm\crud\ZCRMInventoryLineItem;
    use zcrmsdk\crm\crud\ZCRMJunctionRecord;
    use zcrmsdk\crm\crud\ZCRMNote;
    use zcrmsdk\crm\crud\ZCRMRecord;
    use zcrmsdk\crm\crud\ZCRMModule;
    use zcrmsdk\crm\crud\ZCRMTax;
    use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
    use zcrmsdk\crm\setup\users\ZCRMUser;

    use zcrmsdk\crm\crud\ZCRMCustomView;
    use zcrmsdk\crm\crud\ZCRMTag;
    use zcrmsdk\crm\exception\ZCRMException;
    /*
    https://github.com/zoho/zcrm-php-sdk
    https://cullenwebservices.com/using-zohos-crm-version-2-php-sdk-api-with-oauth/
    https://cullenwebservices.com/using-zohos-crm-version-2-php-sdk-api-with-oauth/


    https://help.zoho.com/portal/en/community/topic/problem-reading-all-responses-from-api-unknown-zcrmsdk-crm-exception-zcrmexception
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
    //define('ZOHO_CLIENT_ID', '1000.TV4930GN38592N4NWCGSSMQGMJ4IGT'); // token persistant


    
    //define('ZOHO_CLIENT_SECRET', 'e4d827dd5e50b0c148f8a1cb84fdd87942d7620a40'); //GENERAL Brightness Test
    //define('ZOHO_CLIENT_SECRET', '359ba796f3a6ef73280da9b5da4d97cb2565d73353'); //EU
    //define('ZOHO_CLIENT_SECRET', 'e1e374c4922c57eac6a9bae21e7d040e8cdcde5aba'); //AU
    //define('ZOHO_CLIENT_SECRET', '93cf13e7353be5fab59b16a2cd2c29b2557a27a460'); //IN

    define('ZOHO_CLIENT_SECRET', '871a969ab19f5ff3201ed400cd797542d9df834d95'); //GENERAL B2

    //define('ZOHO_CLIENT_SECRET', '3702fbbed21e1f4c30308385a5d363265e48575b97'); //token persistant
    //define('ZOHO_CLIENT_SECRET', 'cc7b6ad6fc7db63495b3e35c7ee87d13f2be95ab96'); //EU token persistant


    if ( ! defined( 'ZOHO_PLUGIN_FILE' ) ) {
        define( 'ZOHO_PLUGIN_FILE', __FILE__ );
    }

    if ( ! defined( 'ZOHO_PLUGIN_PATH' ) ) {
        define( 'ZOHO_PLUGIN_PATH', plugin_dir_path( ZOHO_PLUGIN_FILE ) );
    }

    if ( ! defined( 'ZOHO_PLUGIN_URL' ) ) {
        define( 'ZOHO_PLUGIN_URL', plugin_dir_url( ZOHO_PLUGIN_FILE ) );
    }

    if ( ! defined( 'ZOHO_PLUGIN_VER' ) ) {
        define( 'ZOHO_PLUGIN_VER', '1.0.0' );
    }

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
