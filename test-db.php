<?php
// Ortam değişkenlerini oku
$server = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$database = getenv("DB_NAME");

// SSL sertifikasının yolu
$ssl_ca = '/home/site/wwwroot/DigiCertGlobalRootCA.crt.pem';

// Bağlantıyı başlat
$conn = mysqli_init();

// SSL bağlantısını ayarla
mysqli_ssl_set($conn, NULL, NULL, $ssl_ca, NULL, NULL);

// Veritabanına bağlan
if (!mysqli_real_connect($conn, $server, $username, $password, $database, 3306, NULL, MYSQLI_CLIENT_SSL)) {
    // Bağlantı hatası durumunda hata mesajını göster ve script'i durdur
    die('Connection failed: ' . mysqli_connect_error());
} else {
    // Başarılı olursa
    echo 'Connected successfully using SSL!';
}

// Bağlantıyı kapat
mysqli_close($conn);
?>