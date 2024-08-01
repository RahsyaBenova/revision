<?php


$id = $_GET['id'];
$jabatanInstance = Lokasi::getInstance();
$success = $jabatanInstance->delete($id);

if ($success) {
    echo "<script>window.location.href = 'index.php?page=data-lokasi&&msg=3';</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-lokasi&&msg=3';</script>";
}
?>
