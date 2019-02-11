<?php

// will get the session id or start a new session

session_start();

$_SESSION["username"] = "Jimmy";

if(isset($_SESSION["username"])){
	echo $_SESSION["username"]."<br>";
}

//echo session_encode();

//echo session_decode();

echo session_id();

//session_unset(); // removes all session variables

//session_destroy(); // kills the session completely

?>
