<?php
// SSL Sertifikası yolu
// Azure App Service için bu dizin kullanılabilir.
$ssl_ca = '/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem';

// Veritabanı bağlantı bilgileri
$server = 'blooddbserver-67528.mysql.database.azure.com';
$username = 'bloodadmin@blooddbserver-67528';
$password = 'NewPassword2025!'; // App Service'teki DB_PASS ile aynı olmalı
$database = 'blood_donation';
$port = 3306;

// Bağlantıyı başlat
$conn = mysqli_init();

// SSL bağlantısını ayarla
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

// Veritabanına bağlan
if (!mysqli_real_connect($conn, $server, $username, $password, $database, $port, NULL, MYSQLI_CLIENT_SSL)) {
    // Bağlantı hatası oluşursa
    die('Connection failed: ' . mysqli_connect_error());
} else {
    // Başarılı olursa
    echo 'Connected successfully using SSL!';
}

// Bağlantıyı kapat
mysqli_close($conn);
?>