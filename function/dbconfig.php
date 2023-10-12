<?php
// Veritabanı bağlantısı için gerekli bilgiler
$host = "localhost"; // Veritabanı sunucusunun adresi
$username = "tilkisof_event"; // Veritabanı kullanıcı adı
$password = "baransel2023++"; // Veritabanı şifresi
$database = "tilkisof_event"; // Kullanılacak veritabanının adı

// Veritabanı bağlantısını oluştur
$mysqli = new mysqli($host, $username, $password, $database);

// Bağlantı hatası kontrolü
if ($mysqli->connect_error) {
    die("Veritabanı bağlantısı başarısız: " . $mysqli->connect_error);
}
?>