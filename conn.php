<?php
// Read database configuration from environment variables
$server = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$database = getenv("DB_NAME");

// Initialize a secure connection with SSL
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Establish connection
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

// Connection error handling
if (mysqli_connect_errno($conn)) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
