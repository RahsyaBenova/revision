<?php

include ('../../../database/koneksi.php');
include ('../../../database/class/pegawai.php');

$id = $_GET['id'];

$pegawai = Pegawai::getInstance(Koneksi::connect());

if ($pegawai->hapusPegawai($id)) {
    header('Location: ../index.php?page=data-pegawai');
} else {
    echo "Error deleting record.";
}
?>
