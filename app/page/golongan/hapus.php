<?php


$id = $_GET['id'];
$jabatanInstance = Golongan::getInstance();
$success = $jabatanInstance->delete($id);

if ($success) {
    echo "<script>window.location.href = 'index.php?page=data-golongan&&msg=3';</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-golongan&&msg=3';</script>";
}
?>
