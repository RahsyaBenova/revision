<?php


$id = $_GET['id'];

$pegawai = Pegawai::getInstance(Koneksi::connect());

if ($pegawai->hapusPegawai($id)) {
    echo "<script>window.location.href = 'index.php?page=data-pegawai'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-pegawai'</script>";
}
?>
