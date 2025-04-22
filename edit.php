<?php
session_start();
require 'function.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM pinjams WHERE id = $id");
    $data = mysqli_fetch_assoc($result);
}

// Fungsi untuk mengubah format tanggal
function formatDateForInput($date)
{
    return date('Y-m-d\TH:i', strtotime($date));
}

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $nama_siswa = $_POST['nama_siswa'];
    $nama_buku = $_POST['nama_buku'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    if (updatePinjaman($id, $username, $nama_siswa, $nama_buku, $tanggal_pinjam, $tanggal_kembali)) {
        $_SESSION['message'] = [
            'title' => 'Sukses',
            'text' => 'Data berhasil diperbarui!',
            'icon' => 'success',
            'timer' => 2000
        ];
        header("Location: index.php");
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}

if ($_SESSION['user']['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href = 'index.php';</script>";
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Peminjaman Buku</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= htmlspecialchars($data["username"]); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" class="form-control" name="nama_siswa" id="nama_siswa" value="<?= htmlspecialchars($data['nama_siswa']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_buku" class="form-label">Nama Buku</label>
                <input type="text" class="form-control" name="nama_buku" id="nama_buku" value="<?= htmlspecialchars($data['nama_buku']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="datetime-local" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam" value="<?= formatDateForInput($data['tanggal_pinjam']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                <input type="datetime-local" class="form-control" name="tanggal_kembali" id="tanggal_kembali" value="<?= formatDateForInput($data['tanggal_kembali']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
        </form>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "<?= $_SESSION['message']['title'] ?>",
                    text: "<?= $_SESSION['message']['text'] ?>",
                    icon: "<?= $_SESSION['message']['icon'] ?>",
                    timer: <?= $_SESSION['message']['timer'] ?>,
                    timerProgressBar: true
                });
            });
        </script>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>