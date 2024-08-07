<?php
include "../database/class/user.php";

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {

    case 'change':
        include('change.php');
        break;
    case 'check':
        include('check.php');
        break;
    default:
        include('index.php');
}
