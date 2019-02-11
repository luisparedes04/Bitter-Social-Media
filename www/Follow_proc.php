<?php
//this page will be used when the user clicks on the "follow" button for a particular user
//process the transaction and insert a record into the database, then redirect the user back
// to index.php
session_start();
include_once('Includes/User.php');

if(isset($_GET["user_id"])){
   $user = $_GET["user_id"];
   $from = $_SESSION["SESS_MEMBER_ID"];
   $fullName = $_GET["fullname"];
   User::follow($user, $from, $fullName);
  
}


?>