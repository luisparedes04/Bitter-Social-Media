<?php
session_start();

include_once("connect.php");  
$con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);

$username = $_POST["username"];


$strSql = "select * from users where screen_name='$username'";


if($result = mysqli_query($con, $strSql)) {
    
    if (mysqli_num_rows($result) > 0) {
        
        $_SESSION["userValidate"] = " ";
        $json_out='{"msg":"sorry username is already taken, please try again"}';   
    }
    else{
        
        $_SESSION["userValidate"] = $_POST["username"];
        $json_out='{"msg":"Good to go"}';
        
    }  
    echo $json_out;
}

?>

