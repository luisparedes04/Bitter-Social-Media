<?php

$valid = checkdate(10, 30, 2018);

if($valid){
    echo "It's a valid date <br>";
}else{
    echo "It's invalid date <br>";
}

// set the time zone to Atlantic

date_default_timezone_set("America/Halifax");

// set the local to english Canada
setlocale(LC_ALL, "en-CA");

echo "the time is " . date("h:i:sa")."<br>";

echo "the date is HERE". date("F d, Y")."<br>";

$dateArray = getDate();

print_r($dateArray);

echo "<br>";

echo strftime("%A %d %B, %Y")."<br>";

// last modified
echo "Page last Modified on " . date("F d, Y h:i:sa", getlastmod())."<br>";

// New stuff in php 5.1 and higher

$dateTweeted = "2018-10-01";
$tweetTime = new DateTime($dateTweeted);
$now = new DateTime(); // default to the current timestamp

$interval = $tweetTime -> diff($now);

echo "interval between tweeted and now " .$interval->format("%d")."<br>";

if($interval->y > 1){ echo $interval->format("%y years ago"); }
else if($interval ->y > 0){ echo $interval->format("%y year ago"); }
elseif($interval ->m > 1){ echo $interval -> format("%m months ago");} 
elseif($interval->m > 0){ echo $interval ->format("%m month ago"); }
elseif($interval ->d > 1){ echo $interval -> format("%d days ago"); } 
elseif($interval->d > 0) {echo $interval ->format("%m day ago"); }
?>

