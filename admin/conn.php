<?php
$server = "blooddbserver.mysql.database.azure.com";
$username = "bloodadmin@blooddbserver";
$password = "Admin123";
$database = "blood_donation";

$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

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

if (mysqli_connect_errno($conn)) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
?>
