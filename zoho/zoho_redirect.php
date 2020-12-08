<?php
//require 'vendor/autoload.php';
//ZOHO V2 custom class for manage function 

//require 'zoho_execute.php';

if(!empty($_REQUEST['code'])){
   
	$zoho=new ZOHO_Exec();
	
	$zoho->zoho->generateToken($_REQUEST['code']);
	//You can get code using Application as well without creating link and authorise.
}
?>