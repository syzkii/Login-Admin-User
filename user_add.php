<?php
error_reporting(0);
session_start();

// Periksa apakah user memiliki hak akses admin
if ($_SESSION["hak_akses"] !== "admin") {
    header("location: index.php");
    exit();
}

// Koneksi ke database menggunakan mysqli
$database = "sppadminop";
$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["simpan"])) {
    // Simpan data
    $username = $conn->real_escape_string($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Hash password untuk keamanan
    $hak_akses = $conn->real_escape_string($_POST["hak_akses"]);

    if (!empty($username) && !empty($_POST["password"]) && !empty($hak_akses)) {
        $q_simpan = "INSERT INTO userkiki (username, password, hak_akses) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($q_simpan);
        $stmt->bind_param("sss", $username, $password, $hak_akses);
        $stmt->execute();
        $stmt->close();

        header("location: user.php");
        exit();
    } else {
        echo "<script>alert('Harap isi semua data!');</script>";
    }
}
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title>SPP</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <form method="post" action="user_add.php">
                        <div class="form-group">
                            <label for="username">Username :</label>
                            <input type="text" class="form-control" name="username" id="username" size="30">
                        </div>
                        <div class="form-group">
                            <label for="password">Password :</label>
                            <input type="password" class="form-control" name="password" id="password" size="30">
                        </div>
                        <div class="form-group">
                            <label for="hak_akses">Hak Akses :</label>
                            <select class="form-control" name="hak_akses" id="hak_akses">
                                <option value="">PILIH</option>
                                <option value="admin">Admin</option>
                                <option value="operator">Operator</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <input type="submit" class="btn btn-success mt-4" name="simpan" value="Simpan">
                            <a href="user.php" class="btn btn-danger mt-4">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
