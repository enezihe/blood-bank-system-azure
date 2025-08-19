<?php
header('Content-Type: text/plain');
echo "PHP OK\n";

$host = getenv('DB_HOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: 'blood_donation';
$user = getenv('DB_USER') ?: 'root';
echo "ENV DB: host={$host} db={$db} user={$user}\n";

require __DIR__ . '/conn.php';
/** @var mysqli $conn */
echo "DB CONNECTED\n";

$r = $conn->query("SELECT COUNT(*) AS donors FROM donor_details");
$row = $r->fetch_assoc();
echo "donors={$row['donors']}\n";
