<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    $pdo = Koneksi::connect();
    $auth = Auth::getInstance($pdo);

    if ($auth->sendPasswordReset($email)) {
        echo "<script>window.location.href = 'index.php?auth=login&&error=4';</script>";
    } else {
        echo $auth->getError();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RaR | Log in</title>
 

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- icon web -->
  <link rel="shortcut icon" href="../assets/dist/img/Logo Rahsya Benova Akbar.png" type="image/png">
</head>

<body class="hold-transition login-page" style="background-image: url('../assets/dist/img/background.jpg')">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline " style="background:transparent; backdrop-filter:blur(20px) brightness(200%); border:1px solid white;
  border-radius:20px;">
    <div class="card-header text-center">
      <a href="" class="h1" style="color:white;"><b>RAR</b> Corp</a>
    </div>
    <hr color="white">
    <div class="card-body">
      <p class="login-box-msg" style="color:white; margin-top:-10px;">Forget Password</p>
      <p class="login-box-msg" style="color:white; margin-top:-10px;">Please enter your email address. You will receive a link to create a new password via email.</P>
      <form  method="POST">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email"  >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row login-options">
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block" name="login">Send Link</button>
          </div>
        </div>
        </div>
        
      </div>
      </form>

    </div>
  </div>
</div>
<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="../assets/plugins/sweetalert2/sweetalert2.min.js"></script>
</body>
</html>