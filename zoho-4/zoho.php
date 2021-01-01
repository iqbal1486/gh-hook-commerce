<?php
define('ZOHO_CURRENT_USER_EMAIL', 'iqbal.brightnessgroup@gmail.com');
define('ZOHO_GRANT_TOKEN', '1000.7bc3988993b614ba08bc65a5fd5af205.d053b5c70fce5ce34c4131edf1dd91b9');
define('ZOHO_CLIENT_ID', '1000.TV4930GN38592N4NWCGSSMQGMJ4IGT');
define('ZOHO_CLIENT_SECRET', '3702fbbed21e1f4c30308385a5d363265e48575b97');
define('ZOHO_REDIRECT_URL', 'http://localhost/zoho-4/zoho.php');

/*
http://localhost/zoho-4/zoho.php?code=1000.19f9e102e98617217ea8e937ad4897bf.54c03d960027d49237bf504ab247e7b3
*/
use com\zoho\api\authenticator\OAuthToken;
use com\zoho\api\authenticator\TokenType;
use com\zoho\api\authenticator\store\DBStore;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\crm\api\Initializer;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\api\logger\Logger;
use com\zoho\api\logger\Levels;
use com\zoho\crm\api\SDKConfigBuilder;


use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\GetRecordsHeader;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\ResponseWrapper;

require_once 'vendor/autoload.php';

$authorize_link = "https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL&client_id=".ZOHO_CLIENT_ID."&response_type=code&access_type=offline&redirect_uri=".ZOHO_REDIRECT_URL;

echo "<a href='$authorize_link'> Authorise First Time </a>";
echo "<pre>";
print_r($_REQUEST);
echo "</pre>";

class Initialize
{
	public $ZOHO_GRANT_TOKEN;

	

    public function initialize($ZOHO_GRANT_TOKEN)
    {
        /*
		 * Create an instance of Logger Class that takes two parameters
		 * 1 -> Level of the log messages to be logged. Can be configured by typing Levels "." and choose any level from the list displayed.
		 * 2 -> Absolute file path, where messages need to be logged.
		 */
        $logger = Logger::getInstance(Levels::ALL, __DIR__."/php_sdk_log.log");

        //Create an UserSignature instance that takes user Email as parameter
        $user = new UserSignature(ZOHO_CURRENT_USER_EMAIL);

        /*
		 * Configure the environment
		 * which is of the pattern Domain.Environment
		 * Available Domains: USDataCenter, EUDataCenter, INDataCenter, CNDataCenter, AUDataCenter
		 * Available Environments: PRODUCTION, DEVELOPER, SANDBOX
		 */
        $environment = USDataCenter::PRODUCTION();
       
        /*
            * Create a Token instance
            * 1 -> OAuth client id.
            * 2 -> OAuth client secret.
            * 3 -> OAuth redirect URL.
            * 4 -> REFRESH/GRANT token.
            * 5 -> Token type(REFRESH/GRANT).
        */
        $token = new OAuthToken(ZOHO_CLIENT_ID, ZOHO_CLIENT_SECRET, $ZOHO_GRANT_TOKEN, TokenType::GRANT, ZOHO_REDIRECT_URL);
        echo "<pre>";
       	print_r($token);
        echo "</pre>";

        /*
        * Create an instance of DBStore.
        * 1 -> DataBase host name. Default value "localhost"
        * 2 -> DataBase name. Default  value "zohooauth"
        * 3 -> DataBase user name. Default value "root"
        * 4 -> DataBase password. Default value ""
        * 5 -> DataBase port number. Default value "3306"
        */
        //$tokenstore = new DBStore();
        //$tokenstore = new  DBStore("localhost", "yith", "root", "", "3306");
        $tokenstore = new FileStore(__DIR__.'/zcrm_oauthtokens.txt');
        
		$autoRefreshFields = false;

		$pickListValidation = false;
		
        // Create an instance of SDKConfig
		$builderInstance = new SDKConfigBuilder();

		$sdkConfig = $builderInstance->setPickListValidation($pickListValidation)->setAutoRefreshFields($autoRefreshFields)->build();

		echo "<pre>";
       	print_r($sdkConfig);
        echo "</pre>";
        $resourcePath = __DIR__;

       /*
		* Call static initialize method of Initializer class that takes the arguments
		* 1 -> UserSignature instance
		* 2 -> Environment instance
		* 3 -> Token instance
		* 4 -> TokenStore instance
		* 5 -> autoRefreshFields 
		* 6 -> The path containing the absolute directory path to store user specific JSON files containing module fields information.
		* 7 -> Logger instance
		*/
		$response = Initializer::initialize($user, $environment, $token, $tokenstore, $sdkConfig, $resourcePath, $logger);

        echo "<pre>";
        print_r($tokenstore->getTokens());
        echo "</pre>";
		
		//$tokenstore->deleteTokens();

		try
        {
            $recordOperations = new RecordOperations();

            $paramInstance = new ParameterMap();

            $paramInstance->add(GetRecordsParam::approved(), "both");

            $headerInstance = new HeaderMap();

            $ifmodifiedsince = date_create("2020-06-02T11:03:06+05:30")->setTimezone(new \DateTimeZone(date_default_timezone_get()));

            $headerInstance->add(GetRecordsHeader::IfModifiedSince(), $ifmodifiedsince);

            $moduleAPIName = "Leads";

            //Call getRecord method that takes paramInstance, moduleAPIName as parameter
            $response = $recordOperations->getRecords($moduleAPIName,$paramInstance, $headerInstance);

            if($response != null)
            {
                //Get the status code from response
                echo("Status Code: " . $response->getStatusCode() . "\n");

                //Get object from response
                $responseHandler = $response->getObject();

                if($responseHandler instanceof ResponseWrapper)
                {
                    //Get the received ResponseWrapper instance
                    $responseWrapper = $responseHandler;

                    //Get the list of obtained Record instances
                    $records = $responseWrapper->getData();
                    
                    echo "<pre>";
                    print_r($records);
                    echo "</pre>";

                    if($records != null)
                    {
                        $recordClass = 'com\zoho\crm\api\record\Record';

                        foreach($records as $record)
                        {
                            //Get the ID of each Record
                            echo("Record ID: " . $record->getId() . "\n");

                            //Get the createdBy User instance of each Record
                            $createdBy = $record->getCreatedBy();

                            //Check if createdBy is not null
                            if($createdBy != null)
                            {
                                //Get the ID of the createdBy User
                                echo("Record Created By User-ID: " . $createdBy->getId() . "\n");

                                //Get the name of the createdBy User
                                echo("Record Created By User-Name: " . $createdBy->getName() . "\n");

                                //Get the Email of the createdBy User
                                echo("Record Created By User-Email: " . $createdBy->getEmail() . "\n");
                            }

                            //Get the CreatedTime of each Record
                            echo("Record CreatedTime: ");

                            print_r($record->getCreatedTime());

                            echo("\n");

                            //Get the modifiedBy User instance of each Record
                            $modifiedBy = $record->getModifiedBy();

                            //Check if modifiedBy is not null
                            if($modifiedBy != null)
                            {
                                //Get the ID of the modifiedBy User
                                echo("Record Modified By User-ID: " . $modifiedBy->getId() . "\n");

                                //Get the name of the modifiedBy User
                                echo("Record Modified By User-Name: " . $modifiedBy->getName() . "\n");

                                //Get the Email of the modifiedBy User
                                echo("Record Modified By User-Email: " . $modifiedBy->getEmail() . "\n");
                            }

                            //Get the ModifiedTime of each Record
                            echo("Record ModifiedTime: ");

                            print_r($record->getModifiedTime());

                            print_r("\n");

                            //Get the list of Tag instance each Record
                            $tags = $record->getTag();

                            //Check if tags is not null
                            if($tags != null)
                            {
                                foreach($tags as $tag)
                                {
                                    //Get the Name of each Tag
                                    echo("Record Tag Name: " . $tag->getName() . "\n");

                                    //Get the Id of each Tag
                                    echo("Record Tag ID: " . $tag->getId() . "\n");
                                }
                            }

                            //To get particular field value
                            echo("Record Field Value: " . $record->getKeyValue("Last_Name") . "\n");// FieldApiName

                            echo("Record KeyValues : \n" );
                            //Get the KeyValue map
                            foreach($record->getKeyValues() as $keyName => $value)
                            {
                                echo("Field APIName" . $keyName . " \tValue : ");

                                print_r($value);

                                echo("\n");
                            }
                        }
                    }
                }
            }
        }
        catch (\Exception $e)
        {
        	echo "<pre>";
        	print_r($e);
        	echo "</pre>";


        }
    }
}
if(isset($_REQUEST['code'])){

	$data  = new Initialize($_REQUEST['code']);
	
}
?>