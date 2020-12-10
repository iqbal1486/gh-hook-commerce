<?php


require 'vendor/autoload.php';
$authorize_link = "https://accounts.zoho.com/oauth/v2/auth?scope=ZohoCRM.modules.all&client_id=".ZOHO_CLIENT_ID."&response_type=code&access_type=offline&redirect_uri=http://localhost/CarbonOnClick/";

echo "<a href='$authorize_link'> Authorise First Time </a>";


if(!empty($_REQUEST['code'])){

/*
Access Token from grant token:
The following code snippet should be executed from your main class to get access token. Please paste the copied grant token in the string literal mentioned below. This is a one-time process.
*/

$configuration =	array(
							"client_id"=>ZOHO_CLIENT_ID,
							"client_secret"=>ZOHO_CLIENT_SECRET,
							"redirect_uri"=>ZOHO_REDIRECT_URI,
							//"db_name" => 'CarbonOnClick',
							"currentUserEmail"=>ZOHO_CURRENT_USER_EMAIL
						); 
ZCRMRestClient::initialize($configuration); 
$oAuthClient = ZohoOAuth::getClientInstance(); 
$grantToken = $_REQUEST['code']; 
$oAuthTokens = $oAuthClient->generateAccessToken($grantToken);   

echo "<pre>";
print_r($oAuthTokens);
echo "</pre>";

/*
Access Token from refresh token:
The following code snippet should be executed from your main class to get access token. Please paste the copied refresh token in the string literal mentioned below. This is a one-time process.
*/


ZCRMRestClient::initialize($configuration); 
$oAuthClient = ZohoOAuth::getClientInstance(); 

echo $refreshToken = "1000.ff4bbc3305ce7d394a6bfcb3c74171e8.64422075fc630a65ee314e070f989bf3";
$userIdentifier = ZOHO_CURRENT_USER_EMAIL; 
$oAuthTokens = $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken,$userIdentifier);
echo "<pre>";
print_r($oAuthTokens);
echo "</pre>";
}
?>