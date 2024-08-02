<?php 
unset($_SESSION['nama']);
unset($_SESSION['level']);
header('location: ../');

// atau bisa gunakan
// session_destroy();
?>