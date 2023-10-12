<?php
// Veritabanı bağlantısı için gerekli bilgiler
$host = "localhost"; // Veritabanı sunucusunun adresi
$username = "database_name"; // Veritabanı kullanıcı adı
$password = "database_pass"; // Veritabanı şifresi
$database = "database"; // Kullanılacak veritabanının adı

// Veritabanı bağlantısını oluştur
$mysqli = new mysqli($host, $username, $password, $database);

// Bağlantı hatası kontrolü
if ($mysqli->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $mysqli->connect_error);
}
?>
