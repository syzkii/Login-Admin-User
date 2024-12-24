<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Form</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="login.css">
<style>
  .border-line {
  border-right: 2px solid #EEEEEE;
  margin-top: 40px;
  height: 400px;
  }
    /* Umum untuk semua perangkat */
  body, html {
    height: 100%;
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
  }

  /* Responsif untuk perangkat Android */
  @media only screen and (max-width: 768px) {
    .container-fluid {
      padding: 0;
      margin: 0;
    }

    .bg-image {
      display: none; /* Sembunyikan gambar di layar kecil */
    }

    .login-heading {
      font-size: 24px; /* Ukuran teks lebih kecil untuk layar kecil */
      text-align: center;
    }

    .form-label-group {
      margin-bottom: 20px;
    }

    input.form-control {
      font-size: 16px; /* Pastikan input cukup besar untuk layar sentuh */
      padding: 10px;
    }

    .btn-login {
      font-size: 18px;
      padding: 10px 15px;
    }

    label[style="color:red;"] {
      font-size: 14px; /* Pesan error lebih kecil */
      text-align: center;
      display: block;
      margin-top: 10px;
    }

    .border-line {
      border: none; /* Hilangkan garis untuk layar kecil */
    }

    .login {
      padding: 20px;
      align-items: center;
    }
}

/* Optimalisasi untuk layar yang lebih besar */
@media only screen and (min-width: 769px) {
  .bg-image {
    background: url('img/bgopsi.png') no-repeat center center;
    background-size: cover;
  }

  .login-heading {
    font-size: 32px;
  }
}

}
</style>
</head>
<body>
<div class="container-fluid">
  <form method="post" action="logincek.php">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image border-line"></div>
    <div class="col-md-8 col-lg-6">
      <div class="login d-flex align-items-center py-5">
        <div class="container">
          <div class="row">
            <div class="col-md-9 col-lg-8 mx-auto">
              <h3 class="login-heading mb-4"><strong>Login Data Siswa</h3></strong>
              <form action="logincek.php" method="POST">
                <div class="form-label-group">
                  <td>Username</td>
                  <td><input type="text" name="username" class="form-control mb-2"></td>
                </div>
                <div class="form-label-group">
                <td>Password</td>
                  <td><input type="password" name="password" class="form-control mb-5"></td>
                </div>
                <input class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" name="simpan" value="Login"></input>
              </form>
              <?php if(isset($_GET['pesan'])) {  ?>
                  <label style="color:red;"><?php echo $_GET['pesan']; ?></label>
              <?php } ?>	
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>