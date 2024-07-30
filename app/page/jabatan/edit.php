<?php 

if($_SESSION['level'] == "common_user" || $_SESSION['level'] == "operator") {
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
                <form method="post" action='update/update_data_jabatan.php'>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Kode Jabatan</label>
                                <input type="text" class="form-control" name="kode_jabatan" value="<?=$view['kode_jabatan'];?>">
                                <input type="text" class="form-control" name="id" value="<?=$view['kode_jabatan'];?>" hidden>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Jabatan</label>
                                <input type="text" class="form-control" name="nama_jabatan" value="<?=$view['nama_jabatan'];?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gapok</label>
                                <input type="text" class="form-control" name="gapok" value="<?=$view['gapok'];?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tunjangan Jabatan</label>
                                <input type="text" class="form-control" name="tunjangan_jabatan" value="<?=$view['tunjangan_jabatan'];?>">
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
