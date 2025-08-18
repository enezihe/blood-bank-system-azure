<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server   = '127.0.0.1';
$database = 'blood_donation';
$username = 'bloodbank';
$password = 'Strong!Pass123';

$conn = new mysqli($server, $username, $password, $database);
$conn->set_charset('utf8mb4');
