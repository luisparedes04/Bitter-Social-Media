<?php

session_start();
include_once('Includes/User.php');
$txtScreen = $_GET["to"];
$userID = $_GET["userId"];
User::GetUsers($txtScreen, $userID);


