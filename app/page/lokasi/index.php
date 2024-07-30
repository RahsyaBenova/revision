<?php

if ($_SESSION['level'] == "common_user") {
    echo "<h1>Akses Ditolak!</h1>";
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_lokasi = $_POST['kode_lokasi'];
    $nama_lokasi = $_POST['nama_lokasi'];

    $lokasi = Lokasi::getInstance();
    $result = $lokasi->create($kode_lokasi, $nama_lokasi);

    if ($result) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Data gagal ditambahkan!";
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tabel Lokasi</h2>
                    </div>
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
                            $no = 0;
                            $lokasi = Lokasi::getInstance();
                            $dataLokasi = $lokasi->read();

                            foreach ($dataLokasi as $lks) {
                                $no++;
                            ?>
                              <tr>
                                    <td width='3%'><?= $no; ?></td>
                                    <td><?= $lks['kode_lokasi'] ?></td>
                                    <td><?= $lks['nama_lokasi'] ?></td>
                                    <td width='3%'>
                                        <a onclick="hapus_data('<?=$lks['kode_lokasi']?>')" class='btn btn-danger btn-sm'>Hapus</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
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
                </div>
            </div>
        </div>
    </div>
</section>

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
                            <label>Kode lokasi</label>
                        </div>
                        <div class="col">
                            <label>Nama Lokasi</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <input type="text" class="form-control" id="kode_lokasi" name="kode_lokasi">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Nama Lokasi" name="nama_lokasi" required>
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
function hapus_data(kode_lokasi) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger'
        },
        buttonsStyling: true
    });

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
                'Your file has been deleted.',
                'success'
            );
            window.location = ("page/lokasi/hapus.php?id=" + kode_lokasi);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Dibatalkan',
                'Data tetap ada',
                'error'
            );
        }
    });
}
</script>
