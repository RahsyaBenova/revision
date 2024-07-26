<!-- Main content -->
<?php 
if($_SESSION['level'] =="common_user")  {
  echo "<h1>Akses Ditolak!</h1>";
  return false;
}
?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
            <div class="card">
              <div class="card-header">
                <h2 class="card-title">Tabel Pegawai</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                  Tambah Data
                </button>
                <br><br>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>NIP</th>
                    <th>Status</th>
                    <th>Jabatan</th>
                    <th>Golongan</th>
                    <th>Lokasi Kerja</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no =0;
                    $query = mysqli_query($conn ,"SELECT tb_pegawai.*, jabatan.nama_jabatan, tb_golongan.nama_golongan, tb_lokasi.nama_lokasi
                                                  FROM tb_pegawai 
                                                  INNER JOIN jabatan ON tb_pegawai.kode_jabatan=jabatan.kode_jabatan 
                                                  INNER JOIN tb_golongan ON tb_pegawai.kode_golongan=tb_golongan.kode_golongan
                                                  INNER JOIN tb_lokasi ON tb_pegawai.kode_lokasi=tb_lokasi.kode_lokasi ORDER BY tb_pegawai.nama ASC");
                        while($pgw = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $pgw['nama'];?></td>
                    <td align="center"><img src="foto/<?=$pgw['foto'];?>" alt="your photo" width="100px"class="rounded"></td>
                    <td><?= $pgw['nip'];?></td> 
                    <td><?= $pgw['status'];?></td>
                    <td><?= $pgw['nama_jabatan'];?></td>
                    <td><?= $pgw['nama_golongan'];?></td>
                    <td><?= $pgw['nama_lokasi'];?></td>
                    <td><a href="index.php?page=edit-data&&id=<?=$pgw['id'];?>" class="btn btn-success btn-sm">Edit</a>
                        <a onclick="hapus_data(<?=$pgw['id'];?>)" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Jabatan</th >
                    <th>Golongan</th >
                    <th>Lokasi Kerja</th >
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
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
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Tambahkan Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="get" action="add/tambah_data.php" enctype="multipart/form-data">
              
            <div class="modal-body">
            <div class="form-row">
              <div class="col">
                <label>Nama</label>
              </div>
              <div class="col">
                <label>NIP</label>
              </div>
              <div class="col">
                <label>Status</label>
              </div>
              <div class="col">
                <label>Jabatan</label>
              </div> 
              <div class="col">
                <label>Golongan</label>
              </div>
              <div class="col">
                <label>Lokasi</label>
              </div>
              <div class="col">
                <label>Jumlah Anak</label>
              </div> 
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                <input type="text" class="form-control" placeholder="Nama" name="foto" value="def.jpg" hidden>
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="NIP" name="nip" required>
              </div>
              <div class="col">
                <select class="form-control" id="status" onChange="autoAnak()" name="status">
                  <option selected value="">-Status-</option>
                  <option value="belum_menikah">Belum Menikah</option>
                  <option value="menikah">Menikah</option>
                </select>
              </div> 
              <div class="col">
                  <select class="form-control" name="kode_jabatan">
                  <option selected value="">Jabatan...</option>
                  <?php 
                  $sqlJabatan = mysqli_query($conn, "SELECT * FROM jabatan ORDER BY kode_jabatan ASC");
                  while ($j = mysqli_fetch_array($sqlJabatan)) {
                    echo "<option value='$j[kode_jabatan]'>$j[kode_jabatan] - $j[nama_jabatan]</option>";
                  }
                  ?>
                  </select>
              </div>
            
              <div class="col">
              <select class="form-control" name="kode_golongan">
              <option selected value="">-Golongan-</option>
              <?php 
              $sqlGolongan = mysqli_query($conn, "SELECT * FROM tb_golongan ORDER BY kode_golongan ASC");
              while ($g = mysqli_fetch_array($sqlGolongan)) {
                echo "<option value='$g[kode_golongan]'>$g[nama_golongan]</option>";
              }
              ?>
              </select>
              </div> 
              <div class="col">
              <select class="form-control" name="kode_lokasi">
              <option selected value="">-pilih-</option>
              <?php 
              $sqllokasi = mysqli_query($conn, "SELECT * FROM tb_lokasi ORDER BY kode_lokasi ASC");
              while ($l = mysqli_fetch_array($sqllokasi)) {
                echo "<option value='$l[kode_lokasi]'>$l[nama_lokasi]</option>";
              }
              ?>
              </select>
              </div> 
              <div class="col">
                <input type="text" id="jumlahanak" class="form-control" placeholder="jumlah anak" name="jumlah_anak" required>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </div>
      </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <script>
      function autoAnak(){
          var status = $('#status').val();
          if(status =='belum_menikah'){
            $('#jumlahanak').val('0');
            $('#jumlahanak').prop('readonly', true);
          }else{
            $('#jumlahanak').val('');
            $('#jumlahanak').prop('readonly', false);
          }
      }
      </script>
      <script>
        function hapus_data(data_id){
        //  // alert('OK'); 
        //  // 
        //  Swal.fire({
        //     title: 'Yakin Ingin Menghapus Data',
        //     // showDenyButton: true,
        //     showCancelButton: true, 
        //     confirmButtonText: 'Hapus Data',
        //     confirmButtonColor: 'red'
        //     // denyButtonText: `Don't save`,
        //   }).then((result) => {
        //     /* Read more about isConfirmed, isDenied below */
        //     if (result.isConfirmed) {
        //       window.location=("delete/hapus_data.php?id="+data_id); 
        //     } 
        //   })
        const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: true
})

swalWithBootstrapButtons.fire({
  title: 'Yakin Menghapus Data?',
  text: "kamu tidak dapat memulihkannya kembali",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, delete it!',
  confirmButtonColor: 'red',
  cancelButtonText: 'No, cancel!',
  reverseButtons: true
  
}).then((result) => {
  if (result.isConfirmed) {
    swalWithBootstrapButtons.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success',
      
    )
    window.location=("delete/hapus_data.php?id="+data_id);
  } else if (
    /* Read more about handling dismissals below */
    result.dismiss === Swal.DismissReason.cancel
  ) {
    swalWithBootstrapButtons.fire(
      'Dibatalkan',
      'Data tetap ada',
      'error'
    )
  }
})
        }
      </script>