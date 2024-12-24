<?php 
// Mengaktifkan session
session_start();

// Menghapus semua variabel sesi
$_SESSION = array();

// Menghapus sesi
session_destroy();

// Redirect ke halaman login dengan pesan
header("Location: index.php?pesan=logout berhasil :)");
exit;
?>
