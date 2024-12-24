<?php
// Matikan laporan error untuk produksi
error_reporting(0);

// Koneksi ke database menggunakan MySQLi
$database = "sppadminop";
$host = "localhost";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan data
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["simpan"])) {
    $nama_siswa = $conn->real_escape_string($_POST["nama_siswa"]);
    $alamat_siswa = $conn->real_escape_string($_POST["alamat_siswa"]);
    $no_hp_siswa = $conn->real_escape_string($_POST["no_hp_siswa"]);
    $kelas = $conn->real_escape_string($_POST["kelas"]);
    $no_induk = $conn->real_escape_string($_GET["no_induk"]);

    if (!empty($nama_siswa) && !empty($alamat_siswa) && !empty($no_hp_siswa) && !empty($kelas)) {
        $q_simpan = "UPDATE data_siswa 
                     SET nama_siswa = '$nama_siswa', alamat_siswa = '$alamat_siswa', no_hp_siswa = '$no_hp_siswa', kelas = '$kelas' 
                     WHERE no_induk = '$no_induk'";
        if ($conn->query($q_simpan)) {
            header("Location: view_siswa.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<script>alert('Harap isi semua data!');</script>";
    }
}

// Ambil data siswa berdasarkan `no_induk`
$no_induk = $conn->real_escape_string($_GET["no_induk"]);
$q_show = "SELECT * FROM data_siswa WHERE no_induk = '$no_induk'";
$result = $conn->query($q_show);
$data = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        .btn-kembali {
            font-size: 15px;
            letter-spacing: 1px;
            padding: 10px;
            border-radius: 2rem;
            float: right;
            margin-right: 20px;
            position: absolute;
            right: 2px;
        }
    </style>
</head>
<body>
<div class="container">
    <form action="" method="post" class="form-group">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card card-signin flex-row my-5">
                    <div class="card-body">
                        <a href="view_siswa.php" class="btn btn-lg btn-danger btn-kembali text-uppercase font-weight-bolder">Kembali</a>
                        <h5 class="card-title text-center">Edit Data Siswa</h5>
                        <table class="table table-bordered">
                            <tr>

                                <td>Nama Siswa:</td>
                                <td><input type="text" class="form-control mb-3" name="nama_siswa" value="<?php echo htmlspecialchars($data['nama_siswa']); ?>" required></td>
                            </tr>
                            <tr>
                                <td>Alamat Siswa:</td>
                                <td><input type="text" class="form-control mb-3" name="alamat_siswa" value="<?php echo htmlspecialchars($data['alamat_siswa']); ?>" required></td>
                            </tr>
                            <tr>
                                <td>No HP Siswa:</td>
                                <td><input type="text" class="form-control mb-3" name="no_hp_siswa" value="<?php echo htmlspecialchars($data['no_hp_siswa']); ?>" required></td>
                            </tr>
                            <tr>
                                <td>Kelas:</td>
                                <td>
                                    <label><input type="radio" name="kelas" value="10" <?php if ($data['kelas'] == '10') echo 'checked'; ?>> 10</label><br>
                                    <label><input type="radio" name="kelas" value="11" <?php if ($data['kelas'] == '11') echo 'checked'; ?>> 11</label><br>
                                    <label><input type="radio" name="kelas" value="12" <?php if ($data['kelas'] == '12') echo 'checked'; ?>> 12</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-center">
                                    <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>


