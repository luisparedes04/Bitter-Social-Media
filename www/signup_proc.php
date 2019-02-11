<?php 
session_start();
include("Includes/User.php");

if (isset($_POST["firstname"])) {
       
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $province = $_POST["province"];
    $postalCode = $_POST["postalCode"];
    $url = $_POST["url"];
    $desc = $_POST["desc"];
    $location = $_POST["location"];
    
    
    if($_SESSION["userValidate"] == $_POST["username"] && $_SESSION["pcValidate"] == $_POST["postalCode"]){
    
        User::registerNewUser($fname, $lname, $email, $username, $password, $phone, $address, $province, $postalCode, 
            $url, $desc, $location);
    
    }else{
     $msg = "screen name is already taken or invalid postal code";
     header("location:Signup.php?msg=$msg");
    }
}

?>