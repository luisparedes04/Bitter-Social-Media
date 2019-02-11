<?php

if(isset($_GET["msg"])){
    echo $_GET["msg"];
    echo "<script>alert('".GET["msg"]."');</script>";
}
//only gets here on a "submit"
//if (isset($_POST["txtName"])) {
if (isset($_POST["txtName"])) {
    //won't get here the first time you visit the page
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    echo $name . "<BR>$email<BR>";
    
}
?>

<html>
    <head></head>
    
    <body>
        <!--method="get" is the default -->
        <form method="post" action="Chap30_proc.php">
            <label>Name:</label><input type="text" name="txtName"><br>
            <label>Email: </label><input type="email" name="txtEmail"><br>
            <input type="submit">
            <button type="submit">Go</button>             
            
        </form>
        
    </body>
</html>