<?php
// Example connection config (do NOT use in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$server='127.0.0.1'; $database='blood_donation'; $username='bloodbank'; $password='***';
$conn = new mysqli($server, $username, $password, $database);
$conn->set_charset('utf8mb4');
