<?php
if ($_SESSION['level'] == "common_user" || $_SESSION['level'] == "operator") {
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    return false;
}

$id = $_GET['id'];

$user = user::getInstance(Koneksi::connect());

if ($user->hapusUser($id)) {
    echo "<script>window.location.href = 'index.php?page=user&&msg=3'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=user&&msg=3'</script>";
}
?>
