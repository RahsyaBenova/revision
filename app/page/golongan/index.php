<!-- Main content -->

<?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $kode_golongan = $_POST['kode_golongan'];
      $nama_golongan = $_POST['nama_golongan'];
      $tunjangan_si = $_POST['tunjangan_si'];
      $tunjangan_anak = $_POST['tunjangan_anak'];
      $uang_makan = $_POST['uang_makan'];
      $askes = $_POST['askes'];

      $golongan = Golongan::getInstance();
      $result = $golongan->create($kode_golongan, $nama_golongan, $tunjangan_si, $tunjangan_anak, $uang_makan, $askes);

      if ($result) {
        echo   "<script>window.location.href = 'index.php?page=data-golongan&msg=1'</script>";
      } else {
          echo "Data gagal ditambahkan!";
      }
}
?>

<?php 
// Pemeriksaan level pengguna
if ($_SESSION['level'] !== "superadmin") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}
?>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
            <div class="card">
              <div class="card-header">
                <h2 class="card-title">Tabel Golongan</h2>
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
                    <th>Kode Golongan</th>
                    <th>Nama Golongan</th>
                    <th>Tunjangan Suami Istri</th>
                    <th>Tunjangan Anak</th>
                    <th>Uang Makan</th>
                    <th>Askes</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no =0;
                    $conn = mysqli_connect('localhost', 'root', '', 'db_kepegawaian');
                    $query = mysqli_query($conn ,"SELECT * FROM tb_golongan ORDER BY kode_golongan ASC");
                    while($gol = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $gol['kode_golongan'];?></td>
                    <td><?= $gol['nama_golongan'];?></td> 
                    <td><?= $gol['tunjangan_si'];?></td>
                    <td><?= $gol['tunjangan_anak'];?></td>
                    <td><?= $gol['uang_makan'];?></td>
                    <td><?= $gol['askes'];?></td>
                    <td width="3%" >
                      <!-- <a href="index.php?page=edit-data-golongan&&id= class="btn btn-success btn-sm">Edit</a> -->
                        <a onclick="hapus_data('<?=$gol['kode_golongan'];?>')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode Golongan</th>
                    <th>Nama Golongan</th>
                    <th>Tunjangan Suami Istri</th>
                    <th>Tunjangan Anak</th>
                    <th>Uang Makan</th>
                    <th>Askes</th>
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
            <form method="POST" enctype="multipart/form-data">
              
            <div class="modal-body">
            <div class="form-row">
              <div class="col">
                <label>Kode Golongan</label>
              </div>
              <div class="col">
                <label>Nama Golongan</label>
              </div>
              <div class="col">
                <label>Tunjangan Suami Istri</label>
              </div> 
              <div class="col">
                <label>Tunjangan Anak</label>
              </div> 
              <div class="col">
                <label>Uang Makan</label>
              </div> 
              <div class="col">
                <label>Askes</label>
              </div>
              
              
            </div>
            <div class="form-row">
              <div class="col">
                <input type="text"  class="form-control"placeholder="Kode Golongan" name="kode_golongan" >
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Nama Golongan" name="nama_golongan" required>
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Tunjangan Suami Istri" name="tunjangan_si">
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Tunjangan Anak" name="tunjangan_anak">
              </div>
              <div class="col">
                <input type="text"  class="form-control"placeholder="Uang Makan" name="uang_makan" >
              </div>
              <div class="col">
                <input type="text" class="form-control" placeholder="Askes" name="askes" required>
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
        function hapus_data(kode_golongan){
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
    window.location=("index.php?page=data-golongan&&act=delete&&id="+kode_golongan);
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