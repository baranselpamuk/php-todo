<?php
// Veritabanı bağlantısını dahil et
include('dbconfig.php');

// Oturumu başlat
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Kullanıcı girişi yapılmadıysa giriş sayfasına yönlendir
    exit();
}

if (isset($_POST['update_password'])) {
    // Formdan yeni şifreyi al
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    // Şifreyi veritabanında güncelle
    $update_query = "UPDATE users SET password = ? WHERE id = ?";
    $stmt = $mysqli->prepare($update_query);
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        echo "Şifre başarıyla güncellendi. Yeniden giriş yapabilirsiniz.";
    } else {
        echo "Hata: Şifre güncellenirken bir sorun oluştu.";
    }

    $stmt->close();
}

$mysqli->close();
?>