<!DOCTYPE html>
<html>
<head>
    <title>Kullanıcı Ayarları</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
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

                <h3>Adınızı Değiştirin</h3>
                <form action="/function/update_name.php" method="post">
                    <div class="form-group">
                        <label for="new_full_name">Yeni Ad Soyad:</label>
                        <input type="text" class="form-control" name="new_full_name" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="update_name">Değiştir</button>
                </form>

                <h3>Şifre Değiştirin</h3>
                <form action="/function/update_password.php" method="post">
                    <div class="form-group">
                        <label for="new_password">Yeni Şifre:</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="update_password">Değiştir</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>