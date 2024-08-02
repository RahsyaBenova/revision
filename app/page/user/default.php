<?php
include "../database/class/user.php";
include "../database/class/page.php";
session_start();

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
