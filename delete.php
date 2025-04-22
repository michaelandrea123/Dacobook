<?php
session_start();
require 'function.php'; // pastikan file ini berisi koneksi ke database

// Mengecek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Pastikan ID adalah angka dan aman untuk digunakan
    $id = intval($id);

    // Panggil fungsi hapusPinjaman untuk menghapus data
    if (hapusPinjaman($id)) {
        echo "<script>alert('Pinjaman berhasil dihapus'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus pinjaman'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan'); window.location.href = 'index.php';</script>";
}

if ($_SESSION['user']['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href = 'index.php';</script>";
    exit;
}
