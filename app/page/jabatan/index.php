
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_jabatan = $_POST['kode_jabatan'];
    $nama_jabatan = $_POST['nama_jabatan'];
    $gapok = $_POST['gapok'];
    $tunjangan_jabatan = $_POST['tunjangan_jabatan'];

    $jabatanInstance = Jabatan::getInstance();
    $success = $jabatanInstance->addJabatan($kode_jabatan, $nama_jabatan, $gapok, $tunjangan_jabatan);

    if ($success) {
        echo   "<script>window.location.href = 'index.php?page=data-jabatan&msg=1'</script>";
    } else {
        echo "Gagal menambahkan data jabatan.";
    }
}
?>


<!-- Main content -->
<?php 
if($_SESSION['level'] == "common_user") {
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
              <h2 class="card-title">Tabel Jabatan</h2>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Tambah Data</button>
              <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Jabatan</th>
                    <th>Nama Jabatan</th>
                    <th>Gapok</th>
                    <th>Tunjangan Jabatan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $no = 0;
                  $jabatanInstance = Jabatan::getInstance();
                  $dataJabatan = $jabatanInstance->getAllJabatan();
                  foreach($dataJabatan as $jbt) {
                    $no++;
                  ?>
                  <tr>
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $jbt['kode_jabatan'];?></td>
                    <td><?= $jbt['nama_jabatan'];?></td> 
                    <td><?= $jbt['gapok'];?></td>
                    <td><?= $jbt['tunjangan_jabatan'];?></td>
                    <td>
                      <a href="index.php?page=data-jabatan&&act=edit&&id=<?= $jbt['kode_jabatan'];?>" class="btn btn-success btn-sm">Edit</a>
                      <a onclick="hapus_data('<?= $jbt['kode_jabatan'];?>')" class="btn btn-danger btn-sm">Hapus</a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Kode Jabatan</th>
                    <th>Nama Jabatan</th>
                    <th>Gapok</th>
                    <th>Tunjangan Jabatan</th>
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
      <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-row">
            <div class="col">
              <label>Kode Jabatan</label>
            </div>
            <div class="col">
              <label>Nama Jabatan</label>
            </div>
            <div class="col">
              <label>Gapok</label>
            </div>
            <div class="col">
              <label>Tunjangan Jabatan</label>
            </div>
          </div>
          <div class="form-row">
            <div class="col">
              <input type="text" class="form-control" id="kode_jabatan" name="kode_jabatan" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Nama Jabatan" name="nama_jabatan" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Gaji Pokok" name="gapok" required>
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Tunjangan Jabatan" name="tunjangan_jabatan" required>
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
</div>
<!-- Include SweetAlert2 CSS and JS files if not already included -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
  }

  document.addEventListener("DOMContentLoaded", function() {
    var msg = getUrlParameter('msg');
    if (msg == 1) { 
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil ditambahkan',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
    else if (msg == 2) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil diupdate',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }else if (msg == 3) {
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Data berhasil dihapus',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'OK'
      });
    }
  });
</script>

<script>
  function hapus_data(kode_jabatan){
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'btn btn-success',
        cancelButton: 'btn btn-danger'
      },
      buttonsStyling: true
    })

    swalWithBootstrapButtons.fire({
      title: 'Yakin Menghapus Data?',
      text: "Kamu tidak dapat memulihkannya kembali",
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
          'Data telah dihapus.',
          'success'
        )
        // window.location = ("delete/hapus_data_jabatan.php?id=" + kode_jabatan);
        window.location.href = ("index.php?page=data-jabatan&&act=delete&&id=" + kode_jabatan);
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        swalWithBootstrapButtons.fire(
          'Dibatalkan',
          'Data tetap ada',
          'error'
        )
      }
    })
  }
</script>
