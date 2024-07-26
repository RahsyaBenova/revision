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
                <h2 class="card-title">Tabel lokasi</h2>
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
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no =0;
                    $conn = mysqli_connect('localhost', 'root', '', 'db_kepegawaian');
                    $query = mysqli_query($conn ,"SELECT * FROM tb_lokasi ORDER BY kode_lokasi ASC");
                    while($lks = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $lks['kode_lokasi'];?></td>
                    <td><?= $lks['nama_lokasi'];?></td> 
                    <td width="3%" >
                        <a onclick="hapus_data('<?=$lks['kode_lokasi'];?>')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>No</th>
                    <th>Kode Lokasi</th>
                    <th>Nama Lokasi</th>
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
            <form method="get" action="add/tambah_data_lokasi.php" enctype="multipart/form-data">
              
            <div class="modal-body">
            <div class="form-row">
              <div class="col">
                <label>Kode lokasi</label>
              </div>
              <div class="col">
                <label>nama_lokasi</label>
              </div>
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text"  class="form-control"id="kode_lokasi" name="kode_lokasi" >
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="nama_lokasi" name="nama_lokasi" required>
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
        function hapus_data(kode_lokasi){
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
    window.location=("delete/hapus_data_lokasi.php?id="+kode_lokasi);
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