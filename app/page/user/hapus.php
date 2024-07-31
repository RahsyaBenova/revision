<?php

$id = $_GET['id'];

$user = user::getInstance(Koneksi::connect());

if ($user->hapusUser($id)) {
    echo "<script>window.location.href = 'index.php?page=user'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=user'</script>";
}
?>
