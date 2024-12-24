<?php
// Nonaktifkan error reporting untuk produksi
error_reporting(0);
session_start();

// Periksa hak akses
if ($_SESSION["hak_akses"] !== "admin") {
    header("Location: index.php");
    exit();
}

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

// Periksa jika form disubmit
if (isset($_POST["simpan"])) {
    $id = $conn->real_escape_string($_GET["id"]);
    $username = $conn->real_escape_string($_POST["username"]);
    $password = $conn->real_escape_string($_POST["password"]);
    $hak_akses = $conn->real_escape_string($_POST["hak_akses"]);

    // Update data
    $query_update = "UPDATE userkiki SET username = ?, password = ?, hak_akses = ? WHERE id = ?";
    $stmt = $conn->prepare($query_update);
    $stmt->bind_param("sssi", $username, $password, $hak_akses, $id);

    if ($stmt->execute()) {
        header("Location: user.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Ambil data pengguna berdasarkan ID
if (isset($_GET["id"])) {
    $id = $conn->real_escape_string($_GET["id"]);
    $query_select = "SELECT * FROM userkiki WHERE id = ?";
    $stmt = $conn->prepare($query_select);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $stmt->close();
} else {
    header("Location: user.php");
    exit();
}

// Tutup koneksi
$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            color: #333;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary, .btn-danger {
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
        }

        .header {
            background-color: #007bff;
            color: #fff;
            padding: 20px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .header h1 {
            font-size: 1.5rem;
            margin: 0;
        }

        .container {
            margin-top: 50px;
        }

        .card-body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header text-center">
        <h1>Edit User</h1>
    </div>

    <div class="container">
        <form method="post">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="user_edit.php?id=<?php echo $data['id']; ?>">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" class="form-control" name="username"
                                           value="<?php echo htmlspecialchars($data['username']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" id="password" class="form-control" name="password"
                                           value="<?php echo htmlspecialchars($data['password']); ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label for="hak_akses" class="form-label">Hak Akses</label>
                                    <select id="hak_akses" class="form-control" name="hak_akses" required>
                                        <option value="">PILIH</option>
                                        <option value="admin" <?php echo ($data['hak_akses'] === "admin" ? "selected" : ""); ?>>
                                            Admin
                                        </option>
                                        <option value="operator" <?php echo ($data['hak_akses'] === "operator" ? "selected" : ""); ?>>
                                            Operator
                                        </option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                    <a href="user.php" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
