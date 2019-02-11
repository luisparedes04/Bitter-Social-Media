<?php
try{
    if (!mysqli_connect("BD", "bad_user", "bad_pass", "myschema")){

        throw new Exception("Error connecting to database");

    }
} catch(Exception $ex){
    
    error_log("error in File " . $ex->getFile(). " on line #" . $ex.getLine() . " details: " . $ex->getMessage(), 0);
    //error_log("error conecting to database", 100, "luissao_20@hotmail.com");
    echo "cannot connect to the db";
}
?>

