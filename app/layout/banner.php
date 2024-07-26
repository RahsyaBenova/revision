<?php 
include("../../database/koneksi.php");
include "../../database/class/count.php";
$pdo = Koneksi::connect();
$count =  count::getInstance($pdo);
$view = $count->countData("users");
$view2 = $count->countData("tb_pegawai");

// try {
//     $conn = Koneksi::connect();

//     $query = $conn->query("SELECT count(id) AS jmlhpgw FROM tb_pegawai");
//     $view = $query->fetch(PDO::FETCH_ASSOC);

//     $query2 = $conn->query("SELECT count(id) AS jmlhusr FROM users");
//     $view2 = $query2->fetch(PDO::FETCH_ASSOC);
// } catch (PDOException $e) {
//     die("Database error: " . $e->getMessage());
// }
?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $view ?></h3>

                <p>Professional Worker</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="#" class="small-box-footer">Jumlah Pegawai<i class="fas"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $view2 ?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">Registrasi User</a>
            </div>
          </div>
          <!-- ./col -->
          </div>
          <!-- ./col -->
    