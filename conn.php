<?php
// Read database configuration from environment variables
$server = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$database = getenv("DB_NAME");

// Ensure environment variables are set
if (!$server || !$username || !$password || !$database) {
    die("Database environment variables are not set correctly.");
}

// SSL sertifikasının doğru yolu
$ssl_ca = '/home/site/wwwroot/admin/DigiCertGlobalRootCA.crt.pem';

// Initialize a secure connection with SSL
$conn = mysqli_init();

// SSL bağlantısını ayarla
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

// Establish connection with the provided connection details
if (!mysqli_real_connect(
    $conn,
    $server,
    $username,
    $password,
    $database,
    3306, // MySQL default port
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    // Connection error handling
    die("Connection failed: " . mysqli_connect_error());
}
?>