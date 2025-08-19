<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);

$server = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user   = getenv('DB_USER');
$pass   = getenv('DB_PASS');

if ($server && $dbname && $user !== false && $pass !== false) {
    $conn = new mysqli($server, $user, $pass, $dbname);
    $conn->set_charset('utf8mb4');
} elseif (is_file(__DIR__ . '/conn.local.php')) {
    require __DIR__ . '/conn.local.php';  // defines $conn for local
} else {
    http_response_code(500);
    die('Database configuration missing. Set DB_* env vars or create conn.local.php');
}
