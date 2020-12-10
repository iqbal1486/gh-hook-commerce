<?php

// Preventing to direct access
defined( 'ABSPATH' ) OR die( 'Direct access not acceptable!' );

class TRANSAK_API {

    private $logDirectory = TRANSAK_PLUGIN_PATH."/logs/";

    public function __construct() {
    }

    /*
    * Generate Log data for transak api call
    */
    public function transak_log_data($requestdata = array(), $type='Response', $filepostfix=null) {

        $filename = date("Y-m-d").'-'.''.$filepostfix.'.log';
        if($filepostfix == null){
            $filename = date("Y-m-d").'-'.'api.log';
        }

        $logs = $this->logDirectory;
        
        if(file_exists($logs.$filename)){
            $logcon = fopen($logs.$filename, "a");
        }else{
            $logcon = fopen($logs.$filename, "w");
        }

        $requestlog = print_r( $requestdata,true );
        
        $start      = "\n\n--".date('m/d/Y h:i:s a', time())." ".$type." starts--\n";
        fwrite( $logcon, $start );
        fwrite( $logcon, $requestlog );
        $end        = "\n--".$type." ends--";

        fwrite( $logcon, $end );
        fclose( $logcon );
    }

    /*
    * Final call to API
    */
    public function transak_api_call($xml_data = ""){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => TRANSAK_API_URL,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS =>$xml_data,
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/xml"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;    
    }
}

$abrac_front_form = new TRANSAK_API;


