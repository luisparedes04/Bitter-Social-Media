<?php
session_start();
require_once('fedex-common.php');

$postalCode = $_POST["postalCode"];


$newline = "<br />";
//Please include and reference in $path_to_wsdl variable.
$path_to_wsdl = "CountryService_v5.wsdl";

ini_set("soap.wsdl_cache_enabled", "0");
 
$client = new SoapClient($path_to_wsdl, array('trace' => 1)); // Refer to http://us3.php.net/manual/en/ref.soap.php for more information

$request['WebAuthenticationDetail'] = array(
	'ParentCredential' => array(
		'Key' => getProperty('parentkey'), 
		'Password' => getProperty('parentpassword')
	),
	'UserCredential' => array(
		'Key' => getProperty('key'), 
		'Password' => getProperty('password')
	)
);

$request['ClientDetail'] = array(
	'AccountNumber' => getProperty('shipaccount'), 
	'MeterNumber' => getProperty('meter')
);
$request['TransactionDetail'] = array('CustomerTransactionId' => ' *** Validate Postal Code Request using PHP ***');
$request['Version'] = array(
	'ServiceId' => 'cnty', 
	'Major' => '5', 
	'Intermediate' => '0', 
	'Minor' => '1'
);

$request['Address'] = array(
	'PostalCode' => $postalCode,
	'CountryCode' => 'CA'
);

$request['CarrierCode'] = 'FDXE';


try {
	if(setEndpoint('changeEndpoint')){
		$newLocation = $client->__setLocation(setEndpoint('endpoint'));
	}
	
	$response = $client -> validatePostal($request);
        
    if ($response -> HighestSeverity != 'FAILURE' && $response -> HighestSeverity != 'ERROR'){  	
    	//printSuccess($client, $response);
        
        $_SESSION["pcValidate"] = $_POST["postalCode"];
        echo $response -> PostalDetail -> StateOrProvinceCode;


	}else{
            
            $_SESSION["pcValidate"] = " ";
            echo 'null';

    } 
    
    writeToLog($client);    // Write to log file   
} catch (SoapFault $exception) {
   printFault($exception, $client);        
}

function printString($spacer, $key, $value){
	if(is_bool($value)){
		if($value)$value='true';
		else $value='false';
	}
	echo '<tr><td>'.$spacer. $key .'</td><td>'.$value.'</td></tr>';
}

function printPostalDetails($details, $spacer){
	foreach($details as $key => $value){
            if($key == "StateOrProvince"){ 

            }    
		if(is_array($value) || is_object($value)){            
        	$newSpacer = $spacer. '&nbsp;&nbsp;&nbsp;&nbsp;';
    		echo '<tr><td>'. $spacer . $key.'</td><td>&nbsp;</td></tr>';
    		printPostalDetails($value, $newSpacer);
    	}elseif(empty($value)){
			printString($spacer, $key, $value);
    	}else{
    		printString($spacer, $key, $value);
    	}
    }
}

?>