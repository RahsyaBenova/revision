<?php

include ('../../../database/koneksi.php');
include ('../../../database/class/keuangan.php');

$id = $_GET['id'];
$keuangan = Keuangan::getInstance();
$success = $keuangan->deleteKeuangan($id);

if ($success) {
    header('Location: ../index.php?page=data-keuangan&msg=1');
} else {
    header('Location: ../index.php?page=data-keuangan&msg=1');
}
?>
