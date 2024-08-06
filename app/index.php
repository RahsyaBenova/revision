<?php
include("../database/koneksi.php");
include "../database/class/auth.php";

$pdo = Koneksi::connect();
$user = Auth::getInstance($pdo);
$currentUser = $user->getUser();
if (!$user->isLoggedIn() && $user->isLoggedIn() == false) {
    $login = isset($_GET['auth']) ? $_GET['auth'] : 'auth';
    switch ($login) {
        case 'login':
            include 'auth/login.php';
            break;
        case 'register':
            include 'auth/register.php';
            break;
        case 'forget':
            include 'auth/forget.php';
            break;
        case 'reset':
            include 'auth/reset.php';
            break;
        default:
            include 'auth/login.php';
            break;
    }

} else {

    $cetak = isset($_GET['cetak']) ? $_GET['cetak'] : 'cetak';
    switch ($cetak) {
        case 'keuangan':
            include 'page/report/pdf-keuangan.php';
        case 'penggajian':
            include 'page/report/cetak_penggajian.php';
        case 'grafik':
            include 'page/report/cetak_grafik.php';
    }

    include 'layout/header.php'; ?>
    <body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
    
      <!-- Preloader -->
      <?php  include ('layout/preloader.php'); ?>
    
       <!-- Navbar -->
       <?php include ('layout/navbar.php'); ?>
       <!-- /.navbar -->
      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <?php include ('layout/brandlogo.php');  ?>
    
        <!-- Sidebar -->
        <?php include ('layout/sidebar.php'); ?>
        <!-- /.sidebar -->
      </aside>
    
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <?php include('layout/content_header.php'); ?>
        <!-- /.content-header -->
      
        <!-- Main content -->
        <?php if(isset($_GET['page'])){
              if($_GET['page']== 'dashboard'){   
                  include ('page/dashboard/index.php');}
              else if($_GET['page']== 'data-pegawai'){ 
                  include ('page/pegawai/default.php');}
              else if($_GET['page']== 'data-keuangan'){ 
                  include ('page/keuangan/default.php');}
              else if($_GET['page']== 'edit-data-keuangan'){ 
                  include ('edit/edit_data_keuangan.php');}
              else if($_GET['page']== 'informasi'){ 
                  include ('page/informasi.php');}
              else if($_GET['page']== 'user'){ 
                  include ('page/user/default.php');}
              else if($_GET['page']== 'edit-user'){ 
                  include ('edit/edit_data_user.php');}
              else if($_GET['page']== 'data-penggajian'){ 
                  include ('page/penggajian/index.php');}
              else if($_GET['page']== 'invoice-gaji'){ 
                  include ('report/cetak_invoice.php');}
              else if($_GET['page']== 'data-jabatan'){ 
                  include ('page/jabatan/default.php');}
              else if($_GET['page']== 'data-golongan'){ 
                  include ('page/golongan/default.php');}
              else if($_GET['page']== 'data-lokasi'){ 
                  include ('page/lokasi/default.php');}
              else if($_GET['page']== 'edit-data-jabatan'){ 
                  include ('edit/edit_data_jabatan.php');}
              else if($_GET['page']== 'warning'){ 
                  include ('page/warning.php');}
              else{
                    include('page/notfound.php');}}
              else{include ('page/dashboard/index.php');}
              ?>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      
      <?php include('layout/footer.php'); ?>
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    
    </body>
    </html>
<?php } ?>    