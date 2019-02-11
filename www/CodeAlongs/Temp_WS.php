<?php

// convert C to F
$format = $_GET["format"]; // XML or JSON

if(isset($_GET["temp"]) && intval($_GET["temp"])){
    $temp = $_GET["temp"];
    $returnVal = ($temp * 1.8) + 32;
    
    if($format == "json"){
        header("content-type: application/json");
        echo json_encode(array("temp"=>$returnVal));
    }else{
        header("content-type: application/xml");
        echo "<?xml version =\"1.0\"?>";
        echo "<root>";
        echo "<temp>$returnVal</temp>";
        echo "</root>";
    }
}
