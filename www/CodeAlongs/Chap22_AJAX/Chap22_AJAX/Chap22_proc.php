<?php
$userName = $_GET['txtUsername'];

// Connect to database - CHANGE THIS TO YOUR DB SCHEMA NAME
$db = mysqli_connect("localhost", "root", "","bitter-luisparedes")
		or die(mysql_error());
$strSql = "select * from users where screen_name='$userName'";

if($result = mysqli_query($db, $strSql)) {
    if (mysqli_num_rows($result) > 0) {
       // echo "sorry username is already taken, please try again<BR>";
        $json_out='{"msg":"sorry username is already taken, please try again"}';
        
    }
    else{
        //echo "good to go<BR>";
        $json_out='{"msg":"Good to go"}';
    }                
}
echo $json_out;

//perform any server-side validation that may be needed
//if it's all good, go ahead and insert into the database or whatever
?>