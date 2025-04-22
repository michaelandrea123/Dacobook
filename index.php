<?php
session_start();  // Memulai session
require 'function.php';

if (isset($_SESSION['message'])):
    $message = $_SESSION['message']; // Ambil pesan dari session
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
endif;

// Mengecek apakah pengguna sudah login
if (!isset($_SESSION['login']) || !$_SESSION['login']) {
    // Jika pengguna belum login, redirect ke halaman login
    header("Location: login.php");
    exit;
}

if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $searchQuery = $_GET['cari'];
    // Ambil data berdasarkan pencarian
    $pinjaman = searchPinjaman($searchQuery);
} else {
    // Jika tidak ada pencarian, ambil semua data
    $pinjaman = getAllPinjaman();
}

// Mengambil data pengguna dari session
$user = $_SESSION['user'];  // Data pengguna yang sudah disimpan di session saat login
$title = "Home";

// Cek jika ada aksi logout
if (isset($_POST['logout'])) {
    session_destroy();  // Hapus session
    header("Location: login.php");  // Redirect ke halaman login
    exit;
}
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

<body>
    <?php if (isset($message)): ?>
        <!-- Tampilkan SweetAlert dengan pesan yang diterima -->
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "<?= $message['title'] ?>",
                    text: "<?= $message['text'] ?>",
                    icon: "<?= $message['icon'] ?>",
                    timer: <?= $message['timer'] ?>,
                    timerProgressBar: true
                });
            });
        </script>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="index.php">Dacebook</a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == "Home") echo "active"; ?>" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($title == "Add") echo "active"; ?>" href="post.php">Add</a>
                    </li>
                </ul>
                <form class="d-flex" style="width:30%" role="search" method="GET" action="">
                    <input class="form-control me-2" type="search" placeholder="Cari nama siswa atau buku..." name="cari" aria-label="Search" value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
                <a class="text-light btn btn-success" style="margin-left: 20px; text-decoration:none;"><?= $user["name"] ?></a>
                <form method="POST" action="" class="d-flex justify-content-center align-items-center" style="margin-left: 5px;">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h2>Data Peminjaman Buku</h2>
        <a href="post.php" class="mt-2">
            <button class="btn btn-primary w-20 mb-2">Tambah Data</button>
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Siswa</th>
                    <th>Nama Buku</th>
                    <th>Waktu Pinjam</th>
                    <th>Waktu Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($pinjaman as $data): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['username']; ?></td>
                        <td><?= $data['nama_siswa']; ?></td>
                        <td><?= $data['nama_buku']; ?></td>
                        <td><?= $data['tanggal_pinjam']; ?></td>
                        <td><?= $data['tanggal_kembali']; ?></td>
                        <td>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <a href="edit.php?id=<?= $data['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete.php?id=<?= $data['id']; ?>" class="btn btn-danger btn-sm">Hapus</a>
                            <?php else: ?>
                                <span class="text-muted">Tidak ada aksi</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>