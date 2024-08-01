<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_jabatan = $_POST['kode_jabatan'];
    $nama_jabatan = $_POST['nama_jabatan'];
    $gapok = $_POST['gapok'];
    $tunjangan_jabatan = $_POST['tunjangan_jabatan'];

    $jabatanInstance = Jabatan::getInstance();
    $jabatanInstance->updateJabatan($kode_jabatan, $nama_jabatan, $gapok, $tunjangan_jabatan);

    echo "<script>window.location.href = 'index.php?page=data-jabatan&&msg=2'</script>";
}
?>

<?php

if ($_SESSION['level'] == "common_user" || $_SESSION['level'] == "operator") {
  echo "<h1>Akses Ditolak!</h1>";
  return false;
}


$id = $_GET['id'];
$jabatanInstance = Jabatan::getInstance();
$view = $jabatanInstance->getJabatanById($id);
?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Jabatan</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kode Jabatan</label>
                                <input type="text" class="form-control" name="kode_jabatan" value="<?= $view['kode_jabatan']; ?>">
                                <input type="hidden" class="form-control" name="id" value="<?= $view['kode_jabatan']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Jabatan</label>
                                <input type="text" class="form-control" name="nama_jabatan" value="<?= $view['nama_jabatan']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gapok</label>
                                <input type="text" class="form-control" name="gapok" value="<?= $view['gapok']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tunjangan Jabatan</label>
                                <input type="text" class="form-control" name="tunjangan_jabatan" value="<?= $view['tunjangan_jabatan']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-sm btn-info">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
