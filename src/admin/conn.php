<?php
$server = "blooddbserver.mysql.database.azure.com";
$username = "bloodadmin@blooddbserver";
$password = "Admin123";
$database = "blood_donation";

// Initialize a secure connection with SSL
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Establish the connection
mysqli_real_connect(
    $conn,
    $server,
    $username,
    $password,
    $database,
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
);

// Handle connection errors
if (mysqli_connect_errno($conn)) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
