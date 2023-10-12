<?php
// Veritabanı bağlantısını dahil et
include('dbconfig.php');

// Oturumu başlat
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Kullanıcı girişi yapılmadıysa giriş sayfasına yönlendir
    exit();
}

if (isset($_POST['update_name'])) {
    // Formdan yeni adı al
    $new_full_name = $_POST['new_full_name'];
    $user_id = $_SESSION['user_id'];

    // Adı veritabanında güncelle
    $update_query = "UPDATE users SET full_name = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("si", $new_full_name, $user_id);

    if ($stmt->execute()) {
        echo "Ad başarıyla güncellendi. Yeniden giriş yapabilirsiniz.";
    } else {
        echo "Hata: Ad güncellenirken bir sorun oluştu.";
    }

    $stmt->close();
}

$mysqli->close();
?>