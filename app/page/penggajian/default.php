<?php

// Pemeriksaan level pengguna
if ($_SESSION['level'] === "common_user") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}
include "../database/class/penggajian.php";

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {
    default:
        include('index.php');
}
