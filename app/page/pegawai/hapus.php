<?php


$id = $_GET['id'];

$pegawai = Pegawai::getInstance(Koneksi::connect());

if ($pegawai->hapusPegawai($id)) {
    echo "<script>window.location.href = 'index.php?page=data-pegawai&&msg=3'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-pegawai&&msg=3'</script>";
}
?>
