<?php
session_start();
error_reporting(0);

// Validasi hak akses
if (!isset($_SESSION["hak_akses"]) || $_SESSION["hak_akses"] == "") {
    header("location: index.php");
    exit();
}

// Memuat koneksi database
include('koneksi.php');

// Logika pencarian
$sql_cari = "";
if (isset($_POST["cari"]) && !empty($_POST["keyword"])) {
    $keyword = $conn->real_escape_string($_POST["keyword"]);
    $sql_cari = "WHERE no_induk LIKE '%$keyword%' 
                 OR nama_siswa LIKE '%$keyword%' 
                 OR alamat_siswa LIKE '%$keyword%' 
                 OR no_hp_siswa LIKE '%$keyword%' 
                 OR kelas LIKE '%$keyword%'";
}

// Query data siswa
$query = "SELECT * FROM data_siswa $sql_cari ORDER BY no_induk";
$result = $conn->query($query);
?>

<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
<style>
    /* Menyesuaikan margin dan padding untuk layar kecil */
    body {
        font-size: 14px;
        line-height: 1.5;
    }

    .container {
        margin: 0 auto;
        padding: 10px;
    }

    .form-group input {
        font-size: 14px;
    }

    .btn {
        font-size: 14px;
        padding: 10px 12px;
    }

    /* Media query untuk perangkat kecil (smartphone) */
    @media (max-width: 768px) {
        .table {
            font-size: 12px;
        }

        .form-group input {
            width: 100%;
            margin-bottom: 10px;
        }

        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        .float-right {
            float: none !important;
            width: 100%;
        }
    }

    /* Media query untuk perangkat sangat kecil (kurang dari 576px) */
    @media (max-width: 576px) {
        .table {
            font-size: 11px;
        }

        h2 {
            font-size: 18px;
        }

        .btn {
            font-size: 12px;
        }
    }
</style>
</head>
<body>
<div class="container">
    <h2 class="text-center mt-5">Data Siswa</h2>
    <form method="post" class="form-group">
        <input type="text" class="form-control mb-3" name="keyword" placeholder="Cari data.." value="<?php echo $_POST['keyword'] ?? ''; ?>">
        <input type="submit" name="cari" class="btn btn-primary" value="Search">
        <a href="logout.php" class="btn btn-danger float-right">Logout</a>
        <a href="add_siswa.php" class="btn btn-success float-right mr-2">Tambah Data Siswa</a>
        <?php if ($_SESSION["hak_akses"] == "admin") { ?>
            <a href="user.php" class="btn btn-warning float-right mr-2">User Admin</a>
        <?php } ?>
    </form>

    <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>No Induk</th>
                <th>Nama Siswa</th>
                <th>Alamat Siswa</th>
                <th>No HP Siswa</th>
                <th>Kelas</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($data = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($data["no_induk"]); ?></td>
                <td><?php echo htmlspecialchars($data["nama_siswa"]); ?></td>
                <td><?php echo htmlspecialchars($data["alamat_siswa"]); ?></td>
                <td><?php echo htmlspecialchars($data["no_hp_siswa"]); ?></td>
                <td><?php echo htmlspecialchars($data["kelas"]); ?></td>
                <td>
                    <a href="edit_siswa.php?no_induk=<?php echo $data["no_induk"]; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_siswa.php?no_induk=<?php echo $data["no_induk"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
