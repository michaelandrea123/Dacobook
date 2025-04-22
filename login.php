<?php
session_start();
require 'function.php';

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Melakukan query untuk mencari user berdasarkan username/email
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR gmail = '$username'");

    // Jika user ditemukan
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Verifikasi password
        if (password_verify($password, $row["password"])) {
            // Menyimpan data pengguna ke session
            $_SESSION['login'] = true;
            $_SESSION['user'] = $row;

            // Menyimpan pesan sukses ke session untuk ditampilkan di login.php
            $_SESSION['message'] = [
                'title' => 'Login Berhasil!',
                'text' => 'Selamat datang, ' . $row['username'] . '. Anda berhasil login.',
                'icon' => 'success',
                'timer' => 3000 // Timer dalam milidetik (5 detik)
            ];

            // Redirect ke halaman login setelah memproses login
            header("Location: login.php");
            exit;
        } else {
            // Menyimpan pesan error ke session jika password salah
            $_SESSION['message'] = [
                'title' => 'Password salah!',
                'text' => 'Cek kembali password Anda.',
                'icon' => 'error',
                'timer' => 3000
            ];
        }
    } else {
        // Menyimpan pesan error ke session jika username tidak ditemukan
        $_SESSION['message'] = [
            'title' => 'Username tidak ditemukan!',
            'text' => 'Pastikan username atau email yang Anda masukkan benar.',
            'icon' => 'error',
            'timer' => 3000
        ];
    }

    // Redirect ke halaman login setelah memproses login
    header("Location: login.php");
    exit;
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dacebook | Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="img/logo.png" rel="icon">
</head>

<body class="bg-light">
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow" style="width: 100%; width:400px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Login</h3>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username/Email</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username/email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
                    <div class="text-center mt-3">
                        <small>Don't have an account? <a href="register.php">Register</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script SweetAlert -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['message'])): ?>
                Swal.fire({
                    title: "<?= $_SESSION['message']['title'] ?>",
                    text: "<?= $_SESSION['message']['text'] ?>",
                    icon: "<?= $_SESSION['message']['icon'] ?>",
                    confirmButtonText: "OK",
                    timer: <?= $_SESSION['message']['timer'] ?>,
                    timerProgressBar: true // Menampilkan progress bar untuk timer
                }).then(function() {
                    // Setelah SweetAlert selesai, lakukan redirect ke index.php jika login berhasil
                    <?php if ($_SESSION['message']['icon'] == 'success') : ?>
                        window.location.href = 'index.php'; // Redirect ke halaman index.php setelah berhasil login
                    <?php endif; ?>
                });
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>