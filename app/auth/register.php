<?php

$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);

if ($user->isLoggedIn()) {
    header("Location: ../app/index.php");
    exit;
}

if (isset($_POST["register"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $password2 = htmlspecialchars($_POST["password2"]);
    $level = htmlspecialchars($_POST["level"]);

    if ($password !== $password2) {
        $error = "Passwords must match";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        if ($user->register($nama, $email, $username, $hashedPassword, $level)) {
            header("Location: index.php?error=3");
            exit;
        } else {
            $error = $user->getError();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>RaR Corp | Registration</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- icon web -->
  <link rel="shortcut icon" href="../assets/dist/img/Logo Rahsya Benova Akbar.png" type="image/png">
</head>
<body class="hold-transition register-page" style="background-image: url('../assets/dist/img/background.jpg')">
<div class="register-box">
  <div class="card card-outline card-primary" style="background:transparent; backdrop-filter:blur(20px) brightness(200%); border:1px solid white; border-radius:20px;">
    <div class="card-header text-center">
      <a href="" class="h1" style="color:white;"><b>RaR</b>Corp</a>
    </div>
    <hr color="white">
    <div class="card-body">
      <p class="login-box-msg" style="color:white; margin-top:-10px;">Buat akun untuk melanjutkan</p>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye-slash eye-icon" style="cursor:pointer;" id="togglePassword" onclick="togglePasswordVisibility('password')"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Retype password" name="password2" id="password2" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-eye-slash eye-icon" style="cursor:pointer;" id="togglePassword2" onclick="togglePasswordVisibility('password2')"></span>
            </div>
          </div>
        </div>
        <input type="text" class="form-control" name="level" value="common_user" hidden>
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms" style="color:white;">
               I agree to the <a href="terms">terms</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const togglePassword = document.querySelector(`#togglePassword${fieldId === 'password2' ? '2' : ''}`);
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
<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
</body>
</html>
