<?php

$token = $_GET["token"];
$auth = Auth::getInstance($pdo);

$user = $auth->verifyResetToken($token);

if (!$user) {
    header("Location: index.php?auth=login&&error=6");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $token = $_POST["token"];
    $user_id = $_POST["user_id"];
    $password = $_POST["password"];
    $password_confirmation = $_POST["password_confirmation"];

    // Ensure password and confirmation match
    if ($password !== $password_confirmation) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[a-z]/i", $password)) {
        $error = "Password must contain at least one letter.";
    } elseif (!preg_match("/[0-9]/", $password)) {
        $error = "Password must contain at least one number.";
    } else {
        // Attempt to update the password
        if ($auth->updatePassword($user_id, $password)) {
            echo "<script>window.location.href = 'index.php?error=5';</script>";
            exit;
        } else {
            $error = $auth->getError();
        }
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
      <p class="login-box-msg" style="color:white; margin-top:-10px;">Insert Your New Password</p>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      <form  method="POST">
      <div class="input-group mb-3">
      <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
      <input type="password" class="form-control" placeholder="New Password" name="password"  >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" class="form-control" placeholder="Retype New Password" name="password_confirmation"  >
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
    
        <div class="row login-options">
          <div class="col-5">
            <button type="submit" class="btn btn-primary btn-block" name="login">Reset Password</button>
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
