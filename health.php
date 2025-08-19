<?php
header('Content-Type: text/plain');

echo "PHP OK\n";

$host = getenv('DB_HOST') ?: '127.0.0.1';
$db   = getenv('DB_NAME') ?: 'blood_donation';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';

printf("ENV DB: host=%s db=%s user=%s\n", $host, $db, $user);

$mysqli = @new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
  echo "DB FAIL: {$mysqli->connect_error}\n";
  exit(1);
}

echo "DB OK\n";
if ($res = $mysqli->query("SELECT COUNT(*) AS donors FROM donor_details")) {
  $row = $res->fetch_assoc();
  echo "donors={$row['donors']}\n";
}
