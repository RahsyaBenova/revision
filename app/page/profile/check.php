<?php
$pdo = Koneksi::connect();
$auth = Auth::getInstance($pdo);

if (!$auth->isLoggedIn()) {
    echo "<h1>Anda harus login terlebih dahulu!</h1>";
    echo "<script>window.location.href = 'index.php?page=login';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $auth->getUser();
    $confirm_password = $_POST['confirm_password'];

    if (password_verify($confirm_password, $user['password'])) {
        $_SESSION['confirm_password'] = true;
        echo   "<script>window.location.href = 'index.php?page=profile&&act=change'</script>";
        exit;
    } else {
        echo   "<script>window.location.href = 'index.php?page=profile&&msg=2'</script>";
    }
} else {
    echo "<script>window.location.href = 'profile.php';</script>";
}
?>
