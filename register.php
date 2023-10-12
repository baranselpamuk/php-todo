<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Kayıt Ol</h2>
                <form action="register.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="full_name">Ad Soyad:</label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>

                    <div class="form-group">
                        <label for="username">Kullanıcı Adı:</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-posta:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Şifre:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profil Resmi (isteğe bağlı):</label>
                        <input type="file" class="form-control-file" name="profile_image">
                    </div>

                    <button type="submit" class="btn btn-primary" name="register">Kaydol</button>
                </form>

                  <?php
    if (isset($_POST['register'])) {
        // dbconfig.php dosyasını dahil et
        include('./function/dbconfig.php');

        // Form verilerini al
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Şifreyi güvenli bir şekilde hashle

        // Profil resmi yükleme (isteğe bağlı)
        if ($_FILES['profile_image']['name']) {
            $profile_image = $_FILES['profile_image']['name'];
            $profile_image_tmp = $_FILES['profile_image']['tmp_name'];
            move_uploaded_file($profile_image_tmp, "uploads/$profile_image");
        } else {
            $profile_image = null;
        }

        // Kullanıcıyı veritabanına ekleyin
        $insert_query = "INSERT INTO users (full_name, username, email, password, profile_image) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($insert_query);
        $stmt->bind_param("sssss", $full_name, $username, $email, $password, $profile_image);
        
        if ($stmt->execute()) {
            echo "Kayıt başarılı! Giriş yapabilirsiniz.";
        } else {
            echo "Hata: Kayıt sırasında bir sorun oluştu.";
        }
        $stmt->close();
        $mysqli->close();
    }
    ?>


                <p class="text-center">Zaten bir hesabınız var mı? <a href="login.php">Giriş yapın</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>