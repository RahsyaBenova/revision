<?php
include "../../../database/class/user.php";
include "../../../database/koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $pdo = Koneksi::connect();
    $user = User::getInstance($pdo);
    $success = $user->hapusUser($id);

    if ($success) {
        header("Location: ../index.php?page=user&msg=2");
    } else {
        echo "Gagal menghapus user.";
    }
} else {
    echo "ID user tidak ditemukan.";
}
?>
