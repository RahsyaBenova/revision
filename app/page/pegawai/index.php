<?php

// Pemeriksaan level pengguna
if ($_SESSION['level'] === "common_user") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}
$crudUser = Pegawai::getInstance($pdo);
if (isset($_POST["tambah"])) {
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $status = $_POST['status'];
    $jabatan = $_POST['kode_jabatan'];
    $golongan = $_POST['kode_golongan'];
    $lokasi = $_POST['kode_lokasi'];
    $jumlah_anak = $_POST['jumlah_anak'];
    $nama_file = $_POST['foto'];

    $pegawai = Pegawai::getInstance($pdo);
    $success = $pegawai->tambahPegawai($nama, $nip, $status, $jabatan, $golongan, $lokasi, $jumlah_anak, $nama_file);

    if ($success) {
        echo   "<script>window.location.href = 'index.php?page=data-pegawai&msg=1'</script>";
    } else {
        echo "Gagal menambahkan data pegawai.";
    } 
} 
?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tabel Pegawai</h2>
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
                                $pdo = Koneksi::connect();
                                $pegawai = Pegawai::getInstance($pdo);
                                
                                $allPegawai = $pegawai->getAllPegawai();
                                $no = 0;
                                
                                foreach ($allPegawai as $pgw) {
                                  $fotoPath = '../assets/dist/img/foto/' . $pgw['foto'];
                                  $no++;
                                    echo "<tr>
                                        <td width='3%'>{$no}</td>
                                        <td>{$pgw['nama']}</td>
                                        <td align='center'><img src='$fotoPath' alt='your photo' width='100px' class='rounded'></td>
                                        <td>{$pgw['nip']}</td> 
                                        <td>{$pgw['status']}</td>
                                        <td>{$pgw['nama_jabatan']}</td>
                                        <td>{$pgw['nama_golongan']}</td>
                                        <td>{$pgw['nama_lokasi']}</td>
                                        <td>
                                            <a href='index.php?page=data-pegawai&&act=edit&&id={$pgw['id']}' class='btn btn-success btn-sm'>Edit</a>
                                            <a onclick='hapus_data({$pgw['id']})' class='btn btn-danger btn-sm'>Hapus</a>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                            <tfoot>
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
            
                        
            <form method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" placeholder="Foto" name="foto" value="def.jpg" hidden>
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
                                $jabatanList = $pegawai->getAllJabatan();
                                foreach ($jabatanList as $j) {
                                    echo "<option value='{$j['kode_jabatan']}'>{$j['kode_jabatan']} - {$j['nama_jabatan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="kode_golongan">
                                <option selected value="">-Golongan-</option>
                                <?php 
                                $golonganList = $pegawai->getAllGolongan();
                                foreach ($golonganList as $g) {
                                    echo "<option value='{$g['kode_golongan']}'>{$g['nama_golongan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-control" name="kode_lokasi">
                                <option selected value="">-pilih-</option>
                                <?php 
                                $lokasiList = $pegawai->getAllLokasi();
                                foreach ($lokasiList as $l) {
                                    echo "<option value='{$l['kode_lokasi']}'>{$l['nama_lokasi']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" id="jumlahanak" class="form-control" placeholder="Jumlah Anak" name="jumlah_anak" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function autoAnak() {
    var status = document.getElementById('status').value;
    var jumlahAnak = document.getElementById('jumlahanak');
    if (status === 'belum_menikah') {
        jumlahAnak.value = '0';
        jumlahAnak.readOnly = true;
    } else {
        jumlahAnak.value = '';
        jumlahAnak.readOnly = false;
    }
}

function hapus_data(data_id) {
    Swal.fire({
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
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
            window.location.href = ("index.php?page=data-pegawai&&act=delete&&id=" + data_id);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Dibatalkan',
                'Data tetap ada',
                'error'
            )
        }
    })
}
</script>
