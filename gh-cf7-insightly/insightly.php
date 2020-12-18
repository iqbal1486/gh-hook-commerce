<?php
	$api_key = "c3d49cd9-1e36-429b-b94a-bfdb58e582f1";
	$api_url = "https://api.insightly.com/v3.1/";

    /*
    $email      = empty( $data["email"] ) ? "" : adfoin_get_parsed_values( $data["email"], $posted_data );
    $first_name = empty( $data["firstName"] ) ? "" : adfoin_get_parsed_values( $data["firstName"], $posted_data );
    $last_name  = empty( $data["lastName"] ) ? "" : adfoin_get_parsed_values( $data["lastName"], $posted_data );
	*/
    $CONTACT_ID 				= 0;
    $SALUTATION 				= "Mr"; //string
    $FIRST_NAME 				= "Mominbhai"; //string
    $LAST_NAME 					= "IqbalAhmed"; //string
    $IMAGE_URL 					= "https://cybersafett.com/wp-content/uploads/2020/08/profile-photo.jpeg"; //Image URL
    $BACKGROUND 				= "This is my description"; //string
    $OWNER_USER_ID 				= 0; //Lookup
    $DATE_CREATED_UTC 			= "2020-12-17T03:25:44.239Z"; //Date
    $DATE_UPDATED_UTC 			= "2020-12-17T03:25:44.239Z"; //Date
    $SOCIAL_LINKEDIN 			= "http://www.linkedin.com/@f.com"; //valid linkedin.com URL
    $SOCIAL_FACEBOOK 			= "http://www.facebook.com/iahme@f.com"; //valid facebook.com URL
    $SOCIAL_TWITTER 			= "http://www.twitter.com/iahme@f.com"; //valid twitter.com URL
    $DATE_OF_BIRTH 				= "2020-12-17T03:25:44.239Z";
    $PHONE 						= "+91 9887987986"; //string
    $PHONE_HOME 				= "+91 9887987987"; //string
    $PHONE_MOBILE 				= "+91 9887987988"; //string
    $PHONE_OTHER 				= "+91 9887987989"; //string
    $PHONE_ASSISTANT 			= "+91 9887987985"; //string
    $PHONE_FAX 					= "123456"; //string
    $EMAIL_ADDRESS 				= "Iqbal.Brightnessgroup@gmail.com"; //string
    $ASSISTANT_NAME 			= "Brightnessgroup"; //string
    $ADDRESS_MAIL_STREET 		= "Telav"; //string
    $ADDRESS_MAIL_CITY 			= "Ahmedabad"; //string
    $ADDRESS_MAIL_STATE 		= "Gujarat"; //string
    $ADDRESS_MAIL_POSTCODE 		= "382110"; //string
    $ADDRESS_MAIL_COUNTRY 		= "India"; //string
    $ADDRESS_OTHER_STREET 		= "Shela"; //string
    $ADDRESS_OTHER_CITY 		= "Ahmedabad"; //string
    $ADDRESS_OTHER_STATE 		= "Gujarat"; //string
    $ADDRESS_OTHER_POSTCODE 	= "3825110"; //string
    $ADDRESS_OTHER_COUNTRY 		= "United States"; //string
    $CREATED_USER_ID 			= 0;
    $ORGANISATION_ID 			= 0;
    $TITLE 						= "Mr Majnu"; //string
    $EMAIL_OPTED_OUT 			= true;

    $headers = array(
        "Authorization" => "Basic " . base64_encode( $api_key . ':' . "" ),
        "Content-Type"  => "application/json",
        "Accept"        => "application/json",
        "Accept-Encoding"  => "gzip"
    );

    $body = array(
        "CONTACT_ID" 			=> $CONTACT_ID,
		"SALUTATION"			=> $SALUTATION,
		"FIRST_NAME"			=> $FIRST_NAME,
		"LAST_NAME"				=> $LAST_NAME,
		"IMAGE_URL"				=> $IMAGE_URL,
		"BACKGROUND"			=> $BACKGROUND,
		"OWNER_USER_ID"			=> 0,
		"DATE_CREATED_UTC"		=> $DATE_CREATED_UTC,
		"DATE_UPDATED_UTC"		=> $DATE_UPDATED_UTC,
		"SOCIAL_LINKEDIN"		=> $SOCIAL_LINKEDIN,
		"SOCIAL_FACEBOOK"		=> $SOCIAL_FACEBOOK,
		"SOCIAL_TWITTER"		=> $SOCIAL_TWITTER,
		"DATE_OF_BIRTH"			=> $DATE_OF_BIRTH,
		"PHONE"					=> $PHONE,
		"PHONE_HOME"			=> $PHONE_HOME,
		"PHONE_MOBILE"			=> $PHONE_MOBILE,
		"PHONE_OTHER"			=> $PHONE_OTHER,
		"PHONE_ASSISTANT"		=> $PHONE_ASSISTANT,
		"PHONE_FAX"				=> $PHONE_FAX,
		"EMAIL_ADDRESS"			=> $EMAIL_ADDRESS,
		"ASSISTANT_NAME"		=> $ASSISTANT_NAME,
		"ADDRESS_MAIL_STREET" 	=> $ADDRESS_MAIL_STREET,
		"ADDRESS_MAIL_CITY" 	=> $ADDRESS_MAIL_CITY,
		"ADDRESS_MAIL_STATE" 	=> $ADDRESS_MAIL_STATE,
		"ADDRESS_MAIL_POSTCODE"	=> $ADDRESS_MAIL_POSTCODE,
		"ADDRESS_MAIL_COUNTRY" 	=> $ADDRESS_MAIL_COUNTRY,
		"ADDRESS_OTHER_STREET" 	=> $ADDRESS_OTHER_STREET,
		"ADDRESS_OTHER_CITY"	=> $ADDRESS_OTHER_CITY,
		"ADDRESS_OTHER_STATE"	=> $ADDRESS_OTHER_STATE,
		"ADDRESS_OTHER_POSTCODE"=> $ADDRESS_OTHER_POSTCODE,
		"ADDRESS_OTHER_COUNTRY"	=> $ADDRESS_OTHER_COUNTRY,
		"CREATED_USER_ID"		=> 0,
		//"ORGANISATION_ID"		=> 0,
		"TITLE"					=> $TITLE,
		"EMAIL_OPTED_OUT"		=> true,

    );



    $args = array(
        "headers" => $headers,
        "body" => json_encode( $body )
    );

    $response = wp_remote_post( $api_url."Contacts", $args );

    echo "<pre>";
    print_r( $response );
    echo "</pre>";

    //add_to_log_table( $response, $url, $args, $record );
    
?>