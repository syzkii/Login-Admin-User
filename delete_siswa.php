<?php
// Nonaktifkan error reporting untuk produksi
error_reporting(0);

// Koneksi ke database menggunakan MySQLi
$host = "localhost";
$username = "root";
$password = "";
$database = "sppadminop";

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses hapus data
if (isset($_GET["no_induk"])) {
    $no_induk = $conn->real_escape_string($_GET["no_induk"]);

    $str_hapus = "DELETE FROM data_siswa WHERE no_induk = '$no_induk'";
    if ($conn->query($str_hapus)) {
        // Redirect ke halaman view_siswa.php jika berhasil
        header("Location: view_siswa.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "No Induk tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
