<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $pemasukan = $_POST['pemasukan'];
    $pengeluaran = $_POST['pengeluaran'];

    $keuangan = Keuangan::getInstance();
    $keuangan->updateKeuangan($id, $tanggal, $keterangan, $pemasukan, $pengeluaran);

    echo "<script>window.location.href = 'index.php?page=data-keuangan'</script>";
}
?>

<?php

$id = $_GET['id'];
$keuangan = Keuangan::getInstance();
$view = $keuangan->getKeuanganById($id);
?>
<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Keuangan</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- text input -->
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="tanggal" value="<?= $view['tanggal']; ?>">
                                <input type="text" class="form-control" name="id" value="<?= $view['id']; ?>" hidden>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Keterangan</label>
                                <input type="text" class="form-control" name="keterangan" value="<?= $view['keterangan']; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <!-- textarea -->
                            <div class="form-group">
                                <label class="form-label" for="customFile">Pemasukan</label>
                                <input type="text" name="pemasukan" class="form-control" placeholder="pemasukan" value="<?= $view['pemasukan']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Pengeluaran</label>
                            <input type="text" name="pengeluaran" class="form-control" placeholder="pengeluaran" value="<?= $view['pengeluaran']; ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-sm btn-info">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
