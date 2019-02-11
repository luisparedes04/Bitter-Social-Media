<?php
// $password = $_POST['txtPassword'];
$password = "password";
$password2 = "password";
$password = md5($password);
$password2 = md5($password2);

//$password = password_hash($password, PASSWORD_DEFAULT);
//$password2 = password_hash($password2, PASSWORD_DEFAULT);

echo $password."<br>";
echo $password2;

?>

<form action="chapter15_proc.php" method="post" enctype="multipart/form-data">
    select your image:
    <input type="file" name="pic" accept="image/*" required>
    <input id ="button" type="submit" value="submit">
</form>
