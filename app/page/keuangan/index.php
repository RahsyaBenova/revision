<?php

// Pemeriksaan level pengguna
if ($_SESSION['level'] === "common_user") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}


$keuangan = Keuangan::getInstance();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['tanggal'], $_POST['keterangan'], $_POST['pemasukan'], $_POST['pengeluaran'])) {
        $keuangan->addKeuangan($_POST['tanggal'], $_POST['keterangan'], $_POST['pemasukan'], $_POST['pengeluaran']);
    }
}

if (isset($_GET['delete_id'])) {
    $keuangan->deleteKeuangan($_GET['delete_id']);
}

$allKeuangan = $keuangan->getAllKeuangan();

date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tabel Keuangan</title>
    <link rel="stylesheet" href="path/to/your/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
<?php if ($_SESSION['level'] === "common_user"): ?>
    <h1>Akses Ditolak!</h1>
    <script>window.location.href = 'index.php?page=warning';</script>
<?php else: ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tabel Keuangan</h2>
                    </div>
                    <div class="card-body">
                        <?php if ($_SESSION['level'] === "superadmin"): ?>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">
                                Tambah Data
                            </button>
                        <?php endif; ?>

                        <div class="dropdown d-inline">
                            <button class="btn btn-success dropdown-toggle w-20" style="height:36px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Cetak
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="index.php?cetak=keuangan" target="_blank">Tabel Data Keuangan</a>
                                <a class="dropdown-item" onclick="downloadPDF()" target="_blank">Grafik Data Keuangan</a>
                            </div>
                        </div>
                        <br><br>
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <?php if ($_SESSION['level'] === "superadmin"): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 0;
                            foreach ($allKeuangan as $uang):
                                $no++;
                                ?>
                                <tr>
                                    <td width="3%"><?= $no; ?></td>
                                    <td><?= $uang['tanggal']; ?></td>
                                    <td><?= $uang['keterangan']; ?></td>
                                    <td><?= "Rp " . $uang['pemasukan']; ?></td>
                                    <td><?= "Rp " . $uang['pengeluaran']; ?></td>
                                    <?php if ($_SESSION['level'] === "superadmin"): ?>
                                        <td>
                                            <a href="index.php?page=data-keuangan&&act=edit&&id=<?=$uang['id'];?>" class="btn btn-success btn-sm">Edit</a>
                                            <a onclick="hapus_data(<?= $uang['id']; ?>)" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Pemasukan</th>
                                <th>Pengeluaran</th>
                                <?php if ($_SESSION['level'] === "superadmin"): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                            </tfoot>
                        </table>
                        <br><br>
                        <div class="card-header">
                            <h2 class="card-title">Chart</h2>
                        </div>
                        <div class="container">
                            <canvas id="myChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
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
                            <label>Tanggal</label>
                        </div>
                        <div class="col">
                            <label>Keterangan</label>
                        </div>
                        <div class="col">
                            <label>Pemasukan</label>
                        </div>
                        <div class="col">
                            <label>Pengeluaran</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="date" id="tanggal" name="tanggal" value="<?= $date; ?>">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Keterangan" name="keterangan" required>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="" name="pemasukan">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="" name="pengeluaran">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function hapus_data(data_id) {
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
                window.location.href = ("index.php?page=data-keuangan&&act=delete&&id=" + data_id);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Dibatalkan',
                    'Data tetap ada',
                    'error'
                )
            }
        })
    }

    function downloadPDF() {
        const canvas = document.getElementById('myChart');
        const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
        let pdf = new jspdf.jsPDF({
            orientation: 'landscape'
        });
        pdf.setFontSize(20);
        pdf.addImage(canvasImage, 'jpeg', 15, 15, 280, 150);
        pdf.save('Grafik Data Keuangan.pdf');
    }
</script>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var data = <?php echo json_encode([
        'labels' => array_column($allKeuangan, 'tanggal'),
        'datasets' => [
            [
                'label' => 'Pemasukan',
                'data' => array_column($allKeuangan, 'pemasukan'),
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 1,
            ],
            [
                'label' => 'Pengeluaran',
                'data' => array_column($allKeuangan, 'pengeluaran'),
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 1,
            ],
        ],
    ]); ?>;
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php endif; ?>
</body>
</html>
