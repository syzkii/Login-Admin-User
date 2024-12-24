<?php
// Start session
session_start();

// Database connection using mysqli (ensure you're using this method for better security and compatibility)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sppadminop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["simpan"])) {
    // Ensure all fields are filled in
    if (!empty($_POST["nama_siswa"]) && !empty($_POST["alamat_siswa"]) && !empty($_POST["no_hp_siswa"]) && isset($_POST["kelas"])) {
        // Sanitize user input
        $nama_siswa = $conn->real_escape_string($_POST["nama_siswa"]);
        $alamat_siswa = $conn->real_escape_string($_POST["alamat_siswa"]);
        $no_hp_siswa = $conn->real_escape_string($_POST["no_hp_siswa"]);
        $kelas = $_POST["kelas"];
        
        // Prepare and execute SQL query
        $qry_insert = "INSERT INTO data_siswa (nama_siswa, alamat_siswa, no_hp_siswa, kelas) 
                        VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($qry_insert)) {
            $stmt->bind_param("ssss", $nama_siswa, $alamat_siswa, $no_hp_siswa, $kelas);
            $stmt->execute();
            $stmt->close();
            header("Location: view_siswa.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "<p>Please fill in all fields.</p>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <title>Tambah Data Siswa</title>
  <style>
    td {
        padding: 10px;
    }

    body {
        color: #555555;
        font-size: 15px;
        font-weight: normal;
        font-family: Segoe UI;
    }
  </style>
</head>
<body>
<div class="container">
  <form action="" method="post" class="form-group">
    <div class="row">
      <div class="col-lg-15 col-xl-10 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-body">
            <h5>SISWA</h5>
            <br>
            <table cellpadding="5" class="table table-bordered">
              <tr>
                <td width="50%">
                  <strong>Nama Siswa:</strong>
                  <input type="text" class="form-control" name="nama_siswa" required>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <strong>Alamat Siswa:</strong>
                  <input type="text" class="form-control mb-3" name="alamat_siswa" required>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <strong>No HP Siswa:</strong>
                  <input type="text" class="form-control mb-3" name="no_hp_siswa" required>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <strong>Kelas:</strong>
                  <br>
                  <input type="radio" name="kelas" value="10" required> 10
                  <br>
                  <input type="radio" name="kelas" value="11"> 11
                  <br>
                  <input type="radio" name="kelas" value="12"> 12
                </td>
              </tr>
              <tr>
                <td width="50%">
                  <input type="submit" value="Simpan" name="simpan" class="btn btn-success">
                  <input type="button" class="btn btn-danger fa fa-trash-o" value="Kembali" onclick="window.location.href='view_siswa.php'" />
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
