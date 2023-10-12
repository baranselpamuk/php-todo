<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Paneli</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-3">Kullanıcı Paneli</h2>
        <div class="container">
        <div class="row mt-3">
            <div class="col-md-6">
                <h3>Profil Bilgileri</h3>

                <?php
                // Veritabanı bağlantısını dahil et
                include('./function/dbconfig.php');

                // Oturum başlat
                session_start();

                if (!isset($_SESSION['user_id'])) {
                    header("Location: login.php"); // Kullanıcı girişi yapılmadıysa giriş sayfasına yönlendir
                    exit();
                }

                $user_id = $_SESSION['user_id'];

                // Kullanıcının profil bilgilerini çek
                $query = "SELECT * FROM users WHERE id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows == 1) {
                    $user = $result->fetch_assoc();
                    echo '<p>Ad Soyad: ' . $user['full_name'] . '</p>';
                    echo '<p>Kullanıcı Adı: ' . $user['username'] . '</p>';
                    echo '<p>E-posta: ' . $user['email'] . '</p>';
                    echo '<p>Profil Resmi: <img src="./uploads/' . $user['profile_image'] . '" style="max-width: 200px;"></p>';
                }

                $stmt->close();
                $mysqli->close();
                ?>
</div>
</div>
</div>
        <div class="row mt-3">
            <div class="col-md-6">
                <h3>Takvim</h3>

                <?php
                include('./function/dbconfig.php');

                session_start();
                $user_id = $_SESSION['user_id'];
                $query = "SELECT * FROM events WHERE user_id = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<h4>Etkinlikler:</h4>';
                    while ($row = $result->fetch_assoc()) {
                        echo '<p>' . $row['event_date'] . ' - ' . $row['event_description'] . '</p>';
                    }
                } else {
                    echo '<p>Henüz etkinlik eklenmedi.</p>';
                }

                $stmt->close();
                $mysqli->close();
                ?>
                

                <!-- Örnek bir etkinlik ekleme formu -->
                <form action="./function/add_event.php" method="post">
                    <div class="form-group">
                        <label for="event_date">Tarih:</label>
                        <input type="date" class="form-control" name="event_date" required>
                    </div>
                    <div class="form-group">
                        <label for="event_description">Etkinlik Açıklaması:</label>
                        <textarea class="form-control" name="event_description" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success" name="add_event">Etkinlik Ekle</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
