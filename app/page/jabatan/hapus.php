<?php

include ('../../../database/koneksi.php');
include ('../../../database/class/jabatan.php');

$id = $_GET['id'];
$jabatanInstance = Jabatan::getInstance();
$success = $jabatanInstance->deleteJabatan($id);

if ($success) {
    header('Location: ../index.php?page=data-jabatan&msg=1');
} else {
    echo "Gagal menghapus data jabatan.";
}
?>
