<?php
include "../database/class/user.php";
include "../database/class/page.php";
session_start();
if ($_SESSION['level'] == "common_user" || $_SESSION['level'] == "operator") {
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    return false;
}

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {

    case 'create':
        include('add.php');
        break;
    case 'edit':
        include('edit.php');
        break;
    case 'delete':
        include('hapus.php');
        break;
    case 'logout':
        include('userLogout.php');
        break;
    default:
        include('index.php');
}
