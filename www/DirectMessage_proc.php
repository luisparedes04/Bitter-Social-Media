<?php
    include_once('Includes/User.php');
    $user= $_POST["userId"];
    $toUserID = $_POST["to"];
    $text = $_POST["message"];
    
    
    User::AddMessage($user, $toUserID, $text);

