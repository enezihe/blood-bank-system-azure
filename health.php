<?php
require __DIR__ . '/conn.php';
echo "PHP OK<br>";
$r = $conn->query('SELECT 1 AS ok');
echo $r ? "DB OK; test=".$r->fetch_assoc()['ok'] : "DB FAIL";
