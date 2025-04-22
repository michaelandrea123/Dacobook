<?php
session_start();
require 'function.php';

if (isset($_POST['simpan'])) {
    $nama_siswa = $_POST['nama_siswa'];
    $nama_buku = $_POST['nama_buku'];
    $waktu_pinjam = $_POST['waktu_pinjam'];
    $waktu_kembali = $_POST['waktu_kembali'];
    $username = $_POST['username'];

    if (tambahPinjaman($nama_siswa, $nama_buku, $waktu_pinjam, $waktu_kembali, $username)) {
        // Menyimpan pesan sukses ke session untuk ditampilkan di post.php
        $_SESSION['message'] = [
            'title' => 'Data Berhasil Ditambahkan!',
            'text' => 'Peminjaman buku berhasil ditambahkan.',
            'icon' => 'success',
            'timer' => 3000 // Timer dalam milidetik (3 detik)
        ];
        // Redirect ke halaman index setelah data berhasil ditambahkan
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambah data');</script>";
    }
}

$user = ($_SESSION['user']);
$title = "Add";
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dacebook | <?= $title ?></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="img/logo.png" rel="icon">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/Belajar%20UKK/index.php">Dacebook</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == "Home") echo "active"; ?>" aria-current="page" href="/Belajar%20UKK/index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == "Add") echo "active"; ?>" aria-current="page" href="/Belajar%20UKK/post.php">Add</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5 w-50" style="width: 100%; height:400px;">
        <h2>Tambah Peminjaman Buku</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= htmlspecialchars($user["username"]); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" required>
            </div>
            <div class="mb-3">
                <label for="nama_buku" class="form-label">Nama Buku</label>
                <input type="text" class="form-control" name="nama_buku" id="nama_buku" required>
            </div>
            <div class="mb-3">
                <label for="waktu_pinjam" class="form-label">Waktu Pinjam</label>
                <input type="datetime-local" class="form-control" name="waktu_pinjam" id="waktu_pinjam" required>
            </div>
            <div class="mb-3">
                <label for="waktu_kembali" class="form-label">Waktu Kembali</label>
                <input type="datetime-local" class="form-control" name="waktu_kembali" id="waktu_kembali" required>
            </div>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        </form>
    </div>

    <!-- Script SweetAlert -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if (isset($_SESSION['message'])): ?>
                Swal.fire({
                    title: "<?= $_SESSION['message']['title'] ?>",
                    text: "<?= $_SESSION['message']['text'] ?>",
                    icon: "<?= $_SESSION['message']['icon'] ?>",
                    timer: <?= $_SESSION['message']['timer'] ?>,
                    timerProgressBar: true // Menampilkan progress bar untuk timer
                }).then(function() {
                    // Redirect ke index.php setelah notifikasi selesai
                    window.location.href = '/Belajar%20UKK/index.php';
                });
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>