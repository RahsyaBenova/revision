<?php

include ('../../../database/koneksi.php');
include ('../../../database/class/lokasi.php');

$id = $_GET['id'];
$jabatanInstance = Lokasi::getInstance();
$success = $jabatanInstance->delete($id);

if ($success) {
    header('Location: ../index.php?page=data-lokasi&msg=1');
} else {
    echo "Gagal menghapus data jabatan.";
}
?>
