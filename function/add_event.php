<?php
// Veritabanı bağlantısını dahil et
include('dbconfig.php');

// Oturum başlat
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Kullanıcı girişi yapılmadıysa giriş sayfasına yönlendir
    exit();
}

if (isset($_POST['add_event'])) {
    // Formdan gelen verileri al
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $user_id = $_SESSION['user_id'];

    // Etkinliği veritabanına ekleyin
    $insert_query = "INSERT INTO events (user_id, event_date, event_description) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($insert_query);
    $stmt->bind_param("iss", $user_id, $event_date, $event_description);

    if ($stmt->execute()) {
        echo "Etkinlik başarıyla eklendi.";
        header("Location: ../dashboard.php");
    } else {
        echo "Hata: Etkinlik eklenirken bir sorun oluştu.";
    }

    $stmt->close();
}

$mysqli->close();
?>