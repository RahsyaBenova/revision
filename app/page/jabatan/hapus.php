<?php


$id = $_GET['id'];
$jabatanInstance = Jabatan::getInstance();
$success = $jabatanInstance->deleteJabatan($id);

if ($success) {
    echo "<script>window.location.href = 'index.php?page=data-jabatan&&msg=3'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-jabatan'</script>";
}
?>
