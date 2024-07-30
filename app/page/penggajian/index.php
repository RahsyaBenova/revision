<!-- Main content -->
<?php 

if($_SESSION['level'] == "common_user")  {
  echo "<h1>Akses Ditolak!</h1>";
  return false;
}
date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d');

include_once '../database/class/penggajian.php';

?>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
            <div class="card">
              <div class="card-header">
                <h2 class="card-title">Tabel Gaji Pegawai</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body d-inline">
                
                <div class="dropdown d-inline">
                <button class="btn btn-success dropdown-toggle w-20" style="height:36px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Cetak
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="page/report/cetak_penggajian.php" target="_blank">Data Keuangan</a>
                </div>
              </div>
                <br><br>
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="40px">No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>Golongan</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan Suami Istri</th>
                    <th>Tunjangan Anak</th>
                    <th>Uang Makan</th>
                    <th>Askes</th>
                    <th>Total Gaji</th>
                  </tr>
                  </thead>
                  <tbody>
                    
                    <?php 
                    $gajiPegawai = Gaji::getInstance();
                    $dataGaji = $gajiPegawai->getGajiPegawai();
                    $no = 1;
                    foreach ($dataGaji as $pgw) {
                      echo "
                      <tr>
                      <td width='3px' align='center'>$no</td>
                      <td>{$pgw['nama']}</td> 
                      <td>{$pgw['nip']}</td> 
                      <td>{$pgw['status']}</td>
                      <td>{$pgw['nama_jabatan']}</td>
                      <td>{$pgw['nama_golongan']}</td>
                      <td>{$pgw['gapok']}</td>
                      <td>{$pgw['tjsi']}</td>
                      <td>{$pgw['tjanak']}</td>
                      <td>{$pgw['uangmakan']}</td>
                      <td>{$pgw['askes']}</td>
                      <td>{$pgw['totalgaji']}</td>
                      </tr>";
                      $no++;
                    }
                    ?>
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>Golongan</th>
                    <th>Gaji Pokok</th>
                    <th>Tunjangan Suami Istri</th>
                    <th>Tunjangan Anak</th>
                    <th>Uang Makan</th>
                    <th>Askes</th>
                    <th>Total Gaji</th>
                  </tr>
                  </tfoot>
                </table>
                <br><br>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

<!-- print / cetak dokumen -->
<script>
  function printDoc(){
    const myWindow = window.open("report/pdf-keuangan.php");
  }
</script>
