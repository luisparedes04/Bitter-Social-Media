<?php

$url = "http://localhost/CodeAlongs/Temp_WS.php";
$format="xml";

$url = $url."?format=".$format."&temp=37";

// cURL is versatile set of libraries that allow php to send/receive data
// via https. Amazon (AWS) uses RESTful webservices

$cobj = curl_init();
curl_setopt($cobj, CURLOPT_URL, $url);
curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($cobj);

curl_close($cobj);

//echo $data;

if($format == "json"){
    $object = json_decode($data); // this converts json to array
    //print_r($object);
    echo $object ->temp. "<br>";
}else{
    $xmlObject=simplexml_load_string($data);
    
    echo $xmlObject->temp; // dereferencing the xml object
}

