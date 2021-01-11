<?php
use com\zoho\api\authenticator\OAuthToken;
use com\zoho\api\authenticator\TokenType;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\crm\api\Initializer;
use com\zoho\crm\api\UserSignature;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\crm\api\dc\EUDataCenter;
use com\zoho\crm\api\dc\INDataCenter;
use com\zoho\crm\api\dc\CNDataCenter;
use com\zoho\crm\api\dc\AUDataCenter;
use com\zoho\api\logger\Logger;
use com\zoho\api\logger\Levels;
use com\zoho\crm\api\SDKConfigBuilder;

$authorize_link = "https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL&client_id=".GH_WC_ZOHO_CLIENT_ID."&response_type=code&access_type=offline&redirect_uri=".GH_WC_ZOHO_REDIRECT_URL;

echo "<a href='$authorize_link'> Authorise First Time </a>";

class Initialize
{
	public function initialize()
    {
         $GH_WC_ZOHO_GRANT_TOKEN = $_REQUEST['code'];   
        /*
		 * Create an instance of Logger Class that takes two parameters
		 * 1 -> Level of the log messages to be logged. Can be configured by typing Levels "." and choose any level from the list displayed.
		 * 2 -> Absolute file path, where messages need to be logged.
		 */
        $logger = Logger::getInstance( Levels::ALL, GH_WC_ZOHO_ABSPATH.'includes/logs/zoho_sdk.log' );

        //Create an UserSignature instance that takes user Email as parameter
        $user = new UserSignature(GH_WC_ZOHO_CURRENT_USER_EMAIL);

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
        $token = new OAuthToken(GH_WC_ZOHO_CLIENT_ID, GH_WC_ZOHO_CLIENT_SECRET, $GH_WC_ZOHO_GRANT_TOKEN, TokenType::GRANT, GH_WC_ZOHO_REDIRECT_URL);
        
        echo "<pre>";
        echo "Token";
       	print_r($token);
        echo "</pre>";

        $tokenstore = new FileStore(GH_WC_ZOHO_ABSPATH.'includes/zcrm_oauthtokens.txt');
        
		$autoRefreshFields = false;

		$pickListValidation = false;
		
        // Create an instance of SDKConfig
		$builderInstance = new SDKConfigBuilder();

		$sdkConfig = $builderInstance->setPickListValidation($pickListValidation)->setAutoRefreshFields($autoRefreshFields)->build();

		echo "<pre>";
        echo "SDK Config";
       	print_r($sdkConfig);
        echo "</pre>";
        $resourcePath = GH_WC_ZOHO_ABSPATH;

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

    }
}


//if(isset($_REQUEST['code'])){
//$_REQUEST['code'] = "1000.870971d0ae3894e9b98c830e3f326464.43191b9785a66e741f0bc61ef9e6807d";
//$data  = new Initialize($_REQUEST['code']);

//}

?>