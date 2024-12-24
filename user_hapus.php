<?php
// Nonaktifkan error reporting untuk produksi
error_reporting(0);
session_start();

// Periksa hak akses
if ($_SESSION["hak_akses"] !== "admin") {
    header("Location: index.php");
    exit();
}

// Koneksi ke database menggunakan MySQLi (PHP 8 kompatibel)
$database = "sppadminop";
$host = "localhost";
$username = "root";
$password = "";

// Koneksi menggunakan mysqli
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil ID yang dikirimkan melalui URL
$id = $_GET["id"] ?? null;

if ($id) {
    // Menyiapkan query untuk menghapus data
    $stmt = $conn->prepare("DELETE FROM userkiki WHERE id = ?");
    $stmt->bind_param("i", $id); // Mengikat parameter, "i" untuk integer

    if ($stmt->execute()) {
        // Redirect setelah penghapusan berhasil
        header("Location: user.php");
        exit();
    } else {
        // Jika gagal menghapus
        echo "Terjadi kesalahan saat menghapus data.";
    }

    // Menutup prepared statement
    $stmt->close();
} else {
    // Jika ID tidak ditemukan
    echo "ID tidak valid.";
}

// Menutup koneksi
$conn->close();
?>
