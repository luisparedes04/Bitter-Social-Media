<?php
$message = "Hello World";

echo md5($message)."<br>";
// means initialization vector
// cbc means chiper block chaining
$iv = mcrypt_create_iv(8, MCRYPT_RAND);
$key = "secret";
// cipher, key, data, mode, iv
$encMessage = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $message, MCRYPT_MODE_CBC, $iv);

echo $encMessage."<br>";

echo bin2hex($encMessage). "<br>";

echo mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $encMessage, MCRYPT_MODE_CBC, $iv)
?>
