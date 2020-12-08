<?php


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
require 'vendor/autoload.php';
class ZohoV2 {
    
    private $oAuthClient=null;
    private $configuration=null;
    public function __construct($conf=null) {
       
       if($conf!=null)
       $this->configuration=$conf;
        //Initialize Core SDK library   
        ZCRMRestClient::initialize($this->configuration);
        $this->oAuthClient = ZohoOAuth::getClientInstance();
    
    }
    //For set all configurations
    public function setConfiguration($config){
        $this->configuration=$config;
    }

    // When after authorization you redirect you will get this grantToken and using that you will get access token
    public function generateToken($grantToken){
       //Below is sample grant token
       // $grantToken = "1000.11355e7151087bf58933e82c3876a5e9.609bbf22b49c1d43b36fbe3708b2399c";
        return $oAuthTokens = $this->oAuthClient->generateAccessToken($grantToken);
    }
    //This function if access token expire then using refresh token you can generate new Access token
    public function refreshToken($refreshToken,$userIdentifier){
       //below is sample refresh token you found and that automatically updated once generate 

    
       return $oAuthTokens = $this->oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier);
    }

    //Update existing record
    public function updateRecord($zohoid,$data,$module="Contacts"){
       
  
      
       try{

          $zcrmRecordIns = ZCRMRecord::getInstance($module, $zohoid);
       
          foreach($data as $d=>$v){
            $zcrmRecordIns->setFieldValue($d, $v);
          }
        
          $entityResponse=$zcrmRecordIns->update();

            if("success"==$entityResponse->getStatus()){
                
                $createdRecordInstance=$entityResponse->getData();
        
                return $createdRecordInstance->getEntityId();
                echo "Status:".$entityResponse->getStatus();
                echo "Message:".$entityResponse->getMessage();
                echo "Code:".$entityResponse->getCode();
                
                echo "EntityID:".$createdRecordInstance->getEntityId();
                echo "moduleAPIName:".$createdRecordInstance->getModuleAPIName();
           
            }
            return "";
       }catch(Exception $e){
           	$file_names = __DIR__."/zoho_ERROR_UPDATE_log.txt";
				    file_put_contents($file_names, $e.PHP_EOL , FILE_APPEND | LOCK_EX);	
            return "";
       }
        
    }
    //Create a new contact record
    public function newRecord($data,$module="Contacts") {
      
    
        //if(count($data)<=0)return "";
        $records = [];
        try{
       
            $record = ZCRMRecord::getInstance( 'Contacts', null );
            foreach($data as $d=>$v)
                $record->setFieldValue($d, $v);
           

            $records[] = $record;
            
            $zcrmModuleIns = ZCRMModule::getInstance($module);
            $bulkAPIResponse=$zcrmModuleIns->createRecords($records); // $recordsArray - array of ZCRMRecord instances filled with required data for creation.
            $entityResponses = $bulkAPIResponse->getEntityResponses();
       
            foreach($entityResponses as $entityResponse){
                if("success"==$entityResponse->getStatus()){
                   $createdRecordInstance=$entityResponse->getData();
                   return $createdRecordInstance->getEntityId();
                   
                }
                else{
                    $file_names = __DIR__."/zoho_ERROR_ADDNEW_log.txt";
    				        file_put_contents($file_names, (json_encode($entityResponses)).PHP_EOL , FILE_APPEND | LOCK_EX);	
    				        return "-1";
                }
            }
       
        
        }catch(Exception $e){
          $file_names = __DIR__."/zoho_ERROR_ADDNEW_log.txt";
				  file_put_contents($file_names, $e.PHP_EOL , FILE_APPEND | LOCK_EX);	
          return "";
       }
        
        
    }
    // GEt specific record by using id
    public function getRecordById($id=1000266000007206013,$module="Contacts"){
        $zcrmModuleIns = ZCRMModule::getInstance($module)->getRecord($id);
        return $recordsArray = $zcrmModuleIns->getData();
    }
}
?>