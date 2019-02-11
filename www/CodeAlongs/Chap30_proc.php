<?php
if (isset($_POST["txtName"])) {
    //won't get here the first time you visit the page
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    echo $name . "<BR>$email<BR>";
 
    //these are defined as constants
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'productsdemo');

    global $con;
    $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
    if (!$con)
    {   //errors are hard :(
      die('Could not connect: ' . mysql_error());
    }
    $sql = "select * from products";
    if ($result = mysqli_query($con, $sql)) {
        //echo mysqli_num_rows($result);
        $product = "";
        //while ($row = $result->fetch_object()) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['id'] . " " . $row['description'] . "<BR>";
            //echo $row->id . " " . $row->description . "<BR>";
        }
        
    }
    
    //insert statement
    $prodId = 6;
    $category = "sportswear";
    $description = "hockey stick";
    $price =  99.99;
    
    $sql = "INSERT INTO `productsdemo`.`products`(`id`,`category`,`description`,`image`,`price`)
        VALUES($prodId, '$category', '$description', 1, $price);";
    echo $sql . "<BR>";
    mysqli_query($con, $sql);
    //echo mysqli_affected_rows($con) . "<BR>";
    if (mysqli_affected_rows($con) ==1) {
        echo "inserted successfully<BR>";
    }
    else {
        echo "an error occurred<BR>";
    }
    
    //delete statement
    /*$sql = "delete from products where id = $prodId";
    mysqli_query($con, $sql);
    if (mysqli_affected_rows($con) >0) {
        echo "deleted successfully<BR>";
    }
    else {
        echo "an error occurred<BR>";
    }*/
    
    //update statement
    $desc = "baseball bat";    
    $sql = "update products set description='$desc' where id = $prodId";
    echo $sql . "<BR>";
    
    mysqli_query($con, $sql);
    if (mysqli_affected_rows($con) >0) {
        $msg ="updated successfully<BR>";
        //echo "<script>alert('Success');</script>";
        
    }
    else {
        $msg= "an error occurred<BR>";
        //echo "<script>alert('Success');</script>";
    }
    
    
    header("location:chap30-mysql.php?msg=$msg");
    
}
?>

