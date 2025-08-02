<?php
$conn = mysqli_init();
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
mysqli_real_connect(
    $conn,
    'blooddbserver-67528.mysql.database.azure.com',
    'bloodadmin@blooddbserver-67528',
    'NewPassword2025!',
    'blood_donation',
    3306,
    NULL,
    MYSQLI_CLIENT_SSL
);
if (mysqli_connect_errno($conn)) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo 'Connected successfully using SSL!';
}
?>