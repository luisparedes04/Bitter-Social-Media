<?php 
//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php
session_start();
include("Includes/User.php");

if(isset($_POST["username"])){
    
        $user = $_POST["username"];
        $pass = $_POST["password"];
        $row = User::logInUser($user, $pass);
        
    if($row != false){
        
            $_SESSION["SESS_FIRST_NAME"] = $row["first_name"];
            $_SESSION["SESS_LAST_NAME"] = $row["last_name"];
            $_SESSION["SESS_MEMBER_ID"] = $row["user_id"];
            header("location: index.php");

    }
    else{
            $msg ="Please enter a valid username and password";
            header("location: Login.php?msg=$msg");        
    }
    
}

?>
