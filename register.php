<?php
session_start();
require 'function.php';

if (isset($_POST["register"])) {
  if (registrasi($_POST) > 0) {
    $_SESSION['message'] = [
      'title' => 'Registrasi Berhasil!',
      'text' => 'Akun baru telah ditambahkan. Silakan login.',
      'icon' => 'success',
      'redirect' => '/Belajar%20UKK/login.php'
    ];
  } else {
    $_SESSION['message'] = [
      'title' => 'Registrasi Gagal!',
      'text' => 'Terjadi kesalahan, coba lagi.',
      'icon' => 'error'
    ];
  }
  header("Location: register.php");
  exit;
}
?>



<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dacebook | Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="img/logo.png" rel="icon">
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      <?php if (isset($_SESSION['message'])): ?>
        Swal.fire({
          title: "<?= $_SESSION['message']['title'] ?>",
          text: "<?= $_SESSION['message']['text'] ?>",
          icon: "<?= $_SESSION['message']['icon'] ?>",
          confirmButtonText: "OK"
        }).then((result) => {
          <?php if (!empty($_SESSION['message']['redirect'])): ?>
            if (result.isConfirmed) {
              window.location.href = "<?= $_SESSION['message']['redirect'] ?>";
            }
          <?php endif; ?>
        });
        <?php unset($_SESSION['message']); ?>
      <?php endif; ?>
    });
  </script>

</head>

<body class="bg-light">
  <div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="card shadow" style="width: 100%; width:400px;">
      <div class="card-body">
        <h3 class="card-title text-center mb-4">Register</h3>
        <form action="" method="POST">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required>
          </div>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
          </div>
          <input type="hidden" name="role" value="user">
          <button type="submit" class="btn btn-primary w-100" name="register">Register</button>
          <div class="text-center mt-3">
            <small>Already have an account? <a href="/Belajar%20UKK/login.php">Login</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>