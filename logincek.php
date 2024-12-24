<?php
session_start();
error_reporting(0);

// Koneksi ke database (gunakan file koneksi eksternal jika memungkinkan)
$database = "sppadminop";
$host = "localhost";
$username = "root";
$password = "";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validasi input
    if (!empty($username) && !empty($password)) {
        // Gunakan prepared statement untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT * FROM userkiki WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifikasi password (gunakan hash jika disimpan dengan password_hash)
            if ($password === $user["password"]) { // Gunakan password_verify untuk hash
                $_SESSION["hak_akses"] = $user["hak_akses"];
                header("Location: view_siswa.php");
                exit();
            } else {
                header("Location: login.php?pesan=Password salah.");
                exit();
            }
        } else {
            header("Location: login.php?pesan=Username tidak ditemukan.");
            exit();
        }
    } else {
        header("Location: login.php?pesan=Harap isi semua field.");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
