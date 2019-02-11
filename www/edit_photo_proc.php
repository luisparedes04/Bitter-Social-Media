<?php
include("connect.php");
include_once('Includes/User.php');
session_start();


    if ($_FILES['pic']['size'] > 1024*1024)
    {
        echo "Error - file must be under 1MB";
        unlink($_FILES['pic']['tmp_name']);
    }
    else
    {
   
        $file = $_SESSION["SESS_MEMBER_ID"] . '.' . pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
        if (!move_uploaded_file($_FILES['pic']['tmp_name'], "images/profilepics/".$file))
        {
            echo "error: handling uploaded file";
        }
        else
        {  
            $userID = $_SESSION["SESS_MEMBER_ID"];
            User::updateProfilePic($file, $userID);
        }
    }
?>