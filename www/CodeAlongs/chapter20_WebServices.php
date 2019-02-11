<?php

    $url = 'api.openweathermap.org/data/2.5/weather?q=Fredericton&units=metric&APPID=45bfb762ed60106a45fd68fdcc0848fa';
    
    $client = curl_init($url);
    
    curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
    
    $data = curl_exec($client);
    
    $http = curl_getinfo($client, CURLINFO_HTTP_CODE);
    echo $http. "<br>";
    
    curl_close($client);
    
    echo $data . "<br><br><br>";
    
    // true means Associative array
    $myArray = json_decode($data, true);
    print_r($myArray);
    
    echo"<br><br>";
    
    echo $myArray["coord"]["lon"]."<br>";
    
    echo $myArray["weather"][0]["main"]."<br>";
    
    echo $myArray["main"]["temp"]."<br>";
    
    echo $myArray["wind"]["speed"]."<br>";
    
    foreach($myArray as $x){
        echo print_r($x)."<br>";
    }
?>

