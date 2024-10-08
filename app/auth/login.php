<?php
$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);

if (isset($_POST["login"])) {
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    if (!empty($username) && !empty($password)) {
        if ($user->login($username, $password)) {
            header("Location: ../app/index.php");
            exit();
        } else {
            // jika gagal login
            $error = $user->getError();
            header("Location: login.php?error=$error");
            exit();
        }
    } else {
        header("Location: login.php?error=2"); // Input fields are empty
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RaR | Log in</title>
  <style>
    .login-options {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .forgot-password-link {
      text-align: right;
      color: cyan;
    }
    .forgot-password-link a {
      color: cyan;
    }
    .input-group-text .eye-icon {
      cursor: pointer;
    }
  </style>

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
      <p class="login-box-msg" style="color:white; margin-top:-10px;">Sign in to start your session</p>

      <form  method="POST">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye-slash eye-icon" id="togglePassword" onclick="togglePasswordVisibility()"></span>
            </div>
          </div>
        </div>
        <div class="row login-options">
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block" name="login">Log In</button>
          </div>
          <div class="col-7 forgot-password-link">
            <p><a href="index.php?auth=forget">Forgot Password?</a></p>
          </div>
        </div>
        </div>
        
        <center>
          <div class="text-center" style="color:white; margin-right:-2px;">
            <p>Belum Punya Akun?<a href="index.php?auth=register" style="color:cyan;"> Register</a></p>
          </center>
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
<!-- Toggle Password Visibility -->
<script>
function togglePasswordVisibility() {
  const passwordField = document.getElementById('password');
  const togglePassword = document.getElementById('togglePassword');
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    togglePassword.classList.remove('fa-eye-slash');
    togglePassword.classList.add('fa-eye');
  } else {
    passwordField.type = 'password';
    togglePassword.classList.remove('fa-eye');
    togglePassword.classList.add('fa-eye-slash');
  }
}
</script>

<?php 
if (isset ($_GET['error'])){
  $x =( $_GET['error']);
  if ($x==1) {
      echo "
      <script>
      var Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
      });
      Toast.fire({
        icon: 'error',
        title: 'Login Gagal.'
      })
      </script>";
  }else if ($x==2) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'warning',
      title: 'Silahkan Input Username & Password.'
    })
    </script>";
  }else if ($x==3) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'success',
      title: 'Registrasi Berhasil.'
    })
    </script>";
  }else if ($x==4) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'success',
      title: 'Email telah dikirim. Cek Kotak Pesan Anda.'
    })
    </script>";
  }else if ($x==5) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'success',
      title: 'Password Berhasil Diubah. Silahkan Login Kembali.'
    })
    </script>";
  }else if ($x==6) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'error',
      title: 'Link Tidak Valid/Kadaluarsa. Silahkan Request Kembali/Hubungi Superadmin.'
    })
    </script>";
  }
  else if ($x==7) {
    echo "
    <script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'center',
      showConfirmButton: false,
      timer: 3000
    });
    Toast.fire({
      icon: 'error',
      title: 'Username Tidak Terdaftar. Silahkan Registrasi Terlebih Dahulu.'
    })
    </script>";
  }
  else {
      echo '';
  }
}
?>
</body>
</html>
