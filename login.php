<!DOCTYPE html>
<html>
<head>
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center">Giriş Yap</h2>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="email">E-posta:</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Şifre:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary" name="login">Giriş Yap</button>
                </form>

                <?php
                if (isset($_POST['login'])) {
                    // Veritabanı bağlantısı için dbconfig.php dosyasını dahil et
                    include('./function/dbconfig.php');

                    // Formdan gelen verileri al
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    // Kullanıcıyı veritabanından sorgula
                    $query = "SELECT * FROM users WHERE email = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $user = $result->fetch_assoc();

                        // Şifreyi doğrula
                        if (password_verify($password, $user['password'])) {
                            // Giriş başarılı, oturum aç
                            session_start();
                            $_SESSION['user_id'] = $user['id'];
                            header("Location: dashboard.php"); // Kullanıcıyı yönlendir

                        } else {
                            echo '<div class="alert alert-danger">Geçersiz şifre.</div>';
                        }
                    } else {
                        echo '<div class="alert alert-danger">Geçersiz e-posta adresi.</div>';
                    }

                    $stmt->close();
                    $mysqli->close();
                }
                ?>

                <p class="text-center">Hesabınız yok mu? <a href="register.php">Kaydolun</a></p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>