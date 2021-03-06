<?php
use com\zoho\crm\api\record\RecordOperations;
use com\zoho\crm\api\HeaderMap;
use com\zoho\crm\api\ParameterMap;
use com\zoho\crm\api\record\GetRecordsHeader;
use com\zoho\crm\api\record\GetRecordsParam;
use com\zoho\crm\api\record\ResponseWrapper;

/**
 * INIT Class
 */
class GH_Init_Public
{
	
	 function __construct()
    {
        $_REQUEST['code'] = "1000.870971d0ae3894e9b98c830e3f326464.43191b9785a66e741f0bc61ef9e6807d";
        $data  = new Initialize($_REQUEST['code']);

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

//new GH_Init_Public();