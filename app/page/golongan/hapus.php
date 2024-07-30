<?php

include ('../../../database/koneksi.php');
include ('../../../database/class/golongan.php');

$id = $_GET['id'];
$jabatanInstance = Golongan::getInstance();
$success = $jabatanInstance->delete($id);

if ($success) {
    header('Location: ../index.php?page=data-golongan&msg=1');
} else {
    echo "Gagal menghapus data jabatan.";
}
?>
