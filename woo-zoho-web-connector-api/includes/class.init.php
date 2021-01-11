<?php
/**
 * INIT Class
 */
// use com\zoho\crm\api\record\RecordOperations;

// use com\zoho\crm\api\HeaderMap;

// use com\zoho\crm\api\ParameterMap;

// use com\zoho\crm\api\record\GetRecordsHeader;

// use com\zoho\crm\api\record\GetRecordsParam;

// use com\zoho\crm\api\record\ResponseWrapper;

class GH_Init
{
	
	function __construct(	$grant_token = ""	)
	{
		//if(is_admin()){
			$this->load_admin_view();
		//}

		$this->load_public_view();
	}

	public function load_admin_view(){
		require_once GH_WC_ZOHO_ABSPATH.'admin/class.init.php';
	}

	public function load_public_view(){
		require_once GH_WC_ZOHO_ABSPATH.'public/class.init.php';
	}
}


new GH_Init();