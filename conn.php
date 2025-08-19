<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$server   = getenv('DB_HOST') ?: '127.0.0.1';
$database = getenv('DB_NAME') ?: 'blood_donation';
$username = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASS') ?: '';

if (strpos($server, 'mysql.database.azure.com') !== false) {
    // Azure Flexible Server -> TLS zorunlu
    $conn = mysqli_init();
    mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
    mysqli_ssl_set($conn, null, null, null, null, null);
    if (!@mysqli_real_connect($conn, $server, $username, $password, $database, 3306, null, MYSQLI_CLIENT_SSL)) {
        die('DB connect failed (Azure): '.mysqli_connect_error());
    }
} else {
    // Local dev
    $conn = new mysqli($server, $username, $password, $database);
}

$conn->set_charset('utf8mb4');
