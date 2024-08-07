<?php
$pdo = Koneksi::connect();
$auth = Auth::getInstance($pdo);

if (!isset($_SESSION['confirm_password']) || !$_SESSION['confirm_password']) {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}

$user = $auth->getUser();
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            if ($auth->updateProfilePassword($user['id'], $new_password)) {
                echo "<script>window.location.href = 'index.php?page=profile&&msg=1';</script>";
            } else {
                $error = "Gagal mengupdate password.";
            }
        } else {
            $error = "Password dan konfirmasi password tidak sama.";
        }
    }
}
?>

<div class="container">
    <div class="section-header text-center">
        <h1>Change Email/Password</h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <form method="POST">
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="new_password">New Password</label>
                                <div class="input-group">
                                    <input id="new_password" type="password" class="form-control" name="new_password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash eye-icon" style="cursor:pointer;" id="toggleNewPassword" onclick="togglePasswordVisibility('new_password', 'toggleNewPassword')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="confirm_password">Confirm New Password</label>
                                <div class="input-group">
                                    <input id="confirm_password" type="password" class="form-control" name="confirm_password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye-slash eye-icon" style="cursor:pointer;" id="toggleConfirmPassword" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPassword')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-lg btn-block">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(fieldId, toggleIconId) {
    const passwordField = document.getElementById(fieldId);
    const togglePassword = document.getElementById(toggleIconId);
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
