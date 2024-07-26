<!-- Main content -->
<?php 

if($_SESSION['level'] =="common_user")  {
  echo "<h1>Akses Ditolak!</h1>";
  return false;
}
date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d');


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
             
                
                <!-- <div class="dropdown d-inline" >
                  <button class="btn btn-sm btn-success float-right dropdown-toggle w-20" style="height:36px" type="button" data-bs-toggle="dropdown" >Cetak</button>
                  <ul class="dropdown-menu">
                    <li><button type="button" onclick="printdoc()" class="dropdown-item"> Data Keuangan</button></li>
                  </ul>
                </div> -->
                <div class="dropdown d-inline">
                <button class="btn btn-success dropdown-toggle  w-20" style="height:36px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Cetak
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="report/cetak_penggajian.php" target="_blank">Data Keuangan</a>
                </div>
              </div>
                <br><br>
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="40px">No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Jabatan</th >
                    <th>Golongan</th >
                    <th>Gaji Pokok</th >
                    <th>Tunjangan Suami Istri</th >
                    <th>Tunjangan Anak</th >
                    <th>Uang Makan</th >
                    <th>Askes</th >
                    <th>Total Gaji</th >
                    <!-- <th>Action</th> -->
                  </tr>
                  </thead>
                  <tbody>
                    
                    <?php 
                    $no =1;   
                    $query = mysqli_query($conn ,"SELECT tb_pegawai.nip, tb_pegawai.nama, jabatan.nama_jabatan, tb_golongan.nama_golongan, tb_pegawai.status, tb_pegawai.jumlah_anak, jabatan.gapok, jabatan.tunjangan_jabatan,
                                                    IF(tb_pegawai.status='menikah', tunjangan_si, 0) AS tjsi,
                                                    IF(tb_pegawai.status='menikah', tunjangan_anak*jumlah_anak, 0) AS tjanak,
                                                    uang_makan AS uangmakan,
                                                    askes,
                                                    (gapok+tunjangan_jabatan+(SELECT tjsi)+(SELECT tjanak)+(SELECT uangmakan)+askes) AS totalgaji
                                                    FROM tb_pegawai
                                                    INNER JOIN tb_golongan ON tb_golongan.kode_golongan = tb_pegawai.kode_golongan
                                                    INNER JOIN jabatan ON jabatan.kode_jabatan = tb_pegawai.kode_jabatan
                                                    ORDER BY tb_pegawai.nama ASC");
                while($pgw = mysqli_fetch_array($query)){
                      echo"
                      <td width='3px' align='center'>$no</td>
                      <td>$pgw[nama]</td> 
                      <td>$pgw[nip]</td> 
                      <td>$pgw[status]</td>
                      <td>$pgw[nama_jabatan]</td>
                      <td>$pgw[nama_golongan]</td>
                      <td>$pgw[gapok]</td>
                      <td>$pgw[tjsi]</td>
                      <td>$pgw[tjanak]</td>
                      <td>$pgw[uangmakan]</td>
                      <td>$pgw[askes]</td>
                      <td>$pgw[totalgaji]</td>
                      ";
                      $no++;
                      ?>
                  <tr>
                    
                    <!-- <td width="25%"><a href="report/cetak_invoice.php" target="_blank"class="btn btn-success btn-sm">Cetak Invoice Gaji</a> </td>-->
              
                  </tr>
                  <?php } ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Jabatan</th >
                    <th>Golongan</th >
                    <th>Gaji Pokok</th >
                    <th>Tunjangan Suami Istri</th >
                    <th>Tunjangan Anak</th >
                    <th>Uang Makan</th >
                    <th>Askes</th >
                    <th>Total Gaji</th >
                    <!-- <th>Action</th> -->
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
