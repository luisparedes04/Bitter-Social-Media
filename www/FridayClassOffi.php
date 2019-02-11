<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// INSERT STATEMENTS
$prodID = 6;
$category = 'sportwear';
$description = 'hockey stick';
$price = 19.99;
$sql = "insert into `productsdemo`.`products` (`id`,`category`,`description`,`image`,`price`) " .
        "values($prodID,'$category','$description',$price)";
        //. "values (5,'sportwear','hockey stick', 1, 19.99)";
echo $sql."<br>";
mysqli_query($con,$sql);

echo mysqli_affected_rows($con)."<br>";
if (mysqli_affected_rows($con) == 1){
    echo "inserted";
    }
    else{
        echo "error";
    }
// DELETE STATEMENT
    //$sql="delete from products where id=$prodID";
   // mysqli_query($con,$sql);
    
 //if (mysqli_affected_rows($con) > 0){
    //echo "deleted";
    //}
    //else{
      //  echo "error";
    //}
    
 // UPDATE STATEMENT
    $desc = "baseball bat";
    $sql="update products set description = '$desc' where id = $prodID";
    
    if (mysqli_affected_rows($con) > 0){
    echo "updated";
    }
    else{
        echo "error";
    }
    header('location:chap30-mysql.php');
   
?>