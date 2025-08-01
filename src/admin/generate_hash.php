<?php
$password = "123"; 
$hashed = password_hash($password, PASSWORD_DEFAULT);
echo "Şifre: $password<br>";
echo "Hash: $hashed";
?>
