<?php
$conn = mysqli_init();
mysqli_real_connect(
    $conn,
    'blooddbserver-67528.mysql.database.azure.com',
    'bloodadmin@blooddbserver-67528',
    'NewPassword2025!',
    'blood_donation',
    3306,
    NULL,
    0 // MYSQLI_CLIENT_SSL yerine 0 kullanın
);
if (mysqli_connect_errno($conn)) {
    die('Connection failed: ' . mysqli_connect_error());
} else {
    echo 'Connected successfully!';
}
?>