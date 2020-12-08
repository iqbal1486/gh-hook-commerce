<?php

//include ("ZohoV2.php");
class ZOHO_Exec{

	public $zoho;
	function __construct(){
		
		$configuration=
			array(
                "client_id"=> ZOHO_CLIENT_ID,
                "client_secret"=> ZOHO_CLIENT_SECRET,
                "redirect_uri"=>"http://localhost/CarbonOnClick/",
                "currentUserEmail"=> "iqbal.brightnessgroup@gmail.com",
                "access_type"=>__DIR__."/",
                "persistence_handler_class"=>"ZohoOAuthPersistenceHandler",
                "token_persistence_path"=>__DIR__."/",
                "applicationLogFilePath"=>__DIR__."/",
                //"accounts_url" 	=> "https://accounts.zoho.com",
                "user_email_id"=>"iqbal.brightnessgroup@gmail.com"
            );
           
            $this->connect_zoho($configuration);   
          
	}
	private function connect_zoho($conf){
	    
        $this->zoho = new ZohoV2($conf);
        return true;
    }
    public function zoho_data($row=null){

    	/* Here you need to map your ZOHO fields with value more customization please contact parbat@gatetouch.com for any PHP framwork or in CMS */

    	if(empty($row))
        	$row = array(
			    'First_Name'=>'parbat',
			    'Last_Name'=>'pithiya',
			    'Email'=>'zoho@gatetouch.com',
			    'Company'=>'Gatetouch',
			    'Mobile'=>'9998873404',
			    'Mailing_Street'=>'C-235,siddharth excellence',
			    'Mailing_City'=>'Vadodara',
			    'Mailing_Zip'=>'390015',
			    'Mailing_State'=>'Gujarat',
			    'Country'=>'India',
			    'Subscription_Status'=>'Active',
			    'Lead_Source'=>'9code.info',
			    'Coupon'=>'ALL_FREE'
			);

        return $row;
    }
    private function zohoupdate($row=null,$zohoid=1234567890){


        // Get ZOHO data 
		$lead = $this->zoho_data($row);
	    
        if(!empty($zohoid) && intval($zohoid)>0) {
            $this->zoho->updateRecord( $zohoid,$lead);
               
        } else {
            //new registration
            $zohoid = $this->zoho->newRecord($lead);
			$this->set_zoho_id($row, $zohoid);
        }
    }
    private function set_zoho_id($row,$zohoid){
    	/* 
    		Here you can update your record with new zoho ID so next time you can update zoho record 
    	*/
    }
}

?>