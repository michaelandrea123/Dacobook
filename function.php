<?php
$conn = mysqli_connect("localhost", "root", "", "dacebook");

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows = $row;
    }
    return $rows;
}

function getAllPinjaman()
{
    global $conn;

    $query = "SELECT * FROM pinjams";
    $result = mysqli_query($conn, $query);

    $pinjaman = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $pinjaman[] = $row;
    }

    return $pinjaman;
}

function tambahPinjaman($nama_siswa, $nama_buku, $tanggal_pinjam, $tanggal_kembali, $username)
{
    global $conn;

    $query = "INSERT INTO pinjams (nama_siswa, nama_buku, tanggal_pinjam, tanggal_kembali, username) 
              VALUES ('$nama_siswa', '$nama_buku', '$tanggal_pinjam', '$tanggal_kembali', '$username')";

    return mysqli_query($conn, $query);
}


function updatePinjaman($id, $nama_siswa, $nama_buku, $tanggal_pinjam, $tanggal_kembali)
{
    global $conn;

    $query = "UPDATE pinjams SET
nama_siswa = '$nama_siswa',
nama_buku = '$nama_buku',
tanggal_pinjam = '$tanggal_pinjam',
tanggal_kembali = '$tanggal_kembali'
WHERE id = $id";

    return mysqli_query($conn, $query);
}

function hapusPinjaman($id)
{
    global $conn;

    // Pastikan ID adalah angka
    $id = intval($id);

    // Query untuk menghapus data berdasarkan ID
    $query = "DELETE FROM pinjams WHERE id = $id";

    return mysqli_query($conn, $query);
}




function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $role = strtolower(stripslashes($data["role"]));
    $name = $data["name"];
    $email = $data["email"];
    $password = mysqli_real_escape_string($conn, $data["password"]);

    $password = password_hash($password, PASSWORD_DEFAULT);

    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>
    alert('username sudah digunakan');
</script>";
        return false;
    }

    mysqli_query($conn, "INSERT INTO users VALUES('', '$username', '$name', '$email', '$password', '$role')");

    return mysqli_affected_rows($conn);
}

function searchPinjaman($query)
{
    global $conn; // Gunakan koneksi database global
    $sql = "SELECT * FROM pinjams WHERE username LIKE ? OR nama_buku LIKE ?";
    $stmt = $conn->prepare($sql);
    $search = "%" . $query . "%";
    $stmt->bind_param('ss', $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
