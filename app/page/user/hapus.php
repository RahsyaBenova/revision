<?php

$id = $_GET['id'];

$user = user::getInstance(Koneksi::connect());

if ($user->hapusUser($id)) {
    echo "<script>window.location.href = 'index.php?page=user&&msg=3'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=user&&msg=3'</script>";
}
?>
