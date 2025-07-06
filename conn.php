<?php
$server = "blooddbserver.mysql.database.azure.com";      
$username = "bloodadmin@blooddbserver";                  
$password = "Admin123";                       
$database = "blood_donation";                      

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
