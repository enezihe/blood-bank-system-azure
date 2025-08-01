<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "blood_bank_database"; // phpMyAdmin'de oluşturduğun veritabanı adı

$conn = mysqli_connect($server, $username, $password, $database);

// Hata kontrolü
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
