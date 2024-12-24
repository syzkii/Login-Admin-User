<?php
// Start session
session_start();

// Ensure the user has admin access
if ($_SESSION["hak_akses"] !== "admin") {
    header("Location: login.php");
    exit();
}

// Database connection using mysqli
$database = "sppadminop";
$host = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search functionality
$sql_cari = "";
if (isset($_POST["cari"])) {
    $keyword = $conn->real_escape_string($_POST["keyword"]);
    $sql_cari = " WHERE username LIKE '%$keyword%'";
}

// Fetch user data
$query = "SELECT * FROM userkiki" . $sql_cari;
$result = $conn->query($query);
?>
<!doctype html>
<html lang="en">
<head>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
  <meta charset="UTF-8">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>SPP</title>
</head>
<body>
<div class="container">
  <div class="row">
    <div class="col-lg-15 col-xl-10 mx-auto">
      <div class="card card-signin flex-row my-5">
        <div class="card-body">
          <a href="user_add.php" class="btn btn-primary ml-4"><i class="fa fa-address-book"> Tambah data</i></a>
          <a href="view_siswa.php" class="btn btn-primary ml-3"><i class="fa fa-chevron-left" aria-hidden="true"> SPP</i></a>
          <br><br>
          <form method="post" action="user.php">
            <table>
              <tr>
                <td>Cari Data</td>
                <td><input type="text" class="form-control" name="keyword" size="30" value="<?php echo $_POST['keyword'] ?? ''; ?>"></td>
                <td><input type="submit" name="cari" class="btn btn-info" value="Cari"></td>
              </tr>
            </table>
          </form>
          <br>
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th><center>NO</th>
                <th><center>USERNAME</th>
                <th><center>PASSWORD</th>
                <th><center>HAK AKSES</th>
                <th><center>ACTION</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $no = 0;
            while ($data = $result->fetch_assoc()) {
                $no++;
            ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo htmlspecialchars($data["username"]); ?></td>
				<td><?php echo htmlspecialchars($data["password"]); ?></td>
                <td><?php echo htmlspecialchars($data["hak_akses"]); ?></td>
                <td align="center">
                  <a href="user_edit.php?id=<?php echo $data["id"]; ?>" class="btn btn-warning"><i class="fa fa-edit"> Edit</i></a>
                  <a href="user_hapus.php?id=<?php echo $data["id"]; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-eraser"> Hapus</i></a>
                </td>
              </tr>
            <?php
            }
            ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
