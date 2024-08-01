<?php
// Inisialisasi PDO
$pdo = Koneksi::connect();
$pegawaiInstance = Pegawai::getInstance($pdo);

// Mendapatkan ID dari URL
$id = $_GET['id'];

// Mendapatkan data pegawai berdasarkan ID
$view = $pegawaiInstance->getPegawaiById($id);

// Mendapatkan data jabatan, golongan, dan lokasi
$jabatanList = $pegawaiInstance->getAllJabatan();
$golonganList = $pegawaiInstance->getAllGolongan();
$lokasiList = $pegawaiInstance->getAllLokasi();

// Mendapatkan data dari form jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $nip = $_POST['nip'];
    $status = $_POST['status'];
    $kode_jabatan = $_POST['jabatan'];
    $kode_golongan = $_POST['kode_golongan'];
    $kode_lokasi = $_POST['kode_lokasi'];
    $jumlah_anak = $_POST['jumlah_anak'];

    // Proses upload foto jika ada file yang diunggah
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $foto = $_FILES['foto']['name'];
        $tmp_name = $_FILES['foto']['tmp_name'];
        $upload_dir = '../../assets/dist/img/foto/';
        move_uploaded_file($tmp_name, $upload_dir . $foto);
    } else {
        // Jika tidak ada file foto baru yang diunggah, gunakan foto lama
        $pegawai = $pegawaiInstance->getPegawaiById($id);
        $foto = $pegawai['foto'];
    }

    // Update data pegawai
    $updated = $pegawaiInstance->updatePegawai($id, $nama, $nip, $status, $kode_jabatan, $kode_golongan, $kode_lokasi, $jumlah_anak, $foto);

    if ($updated) {
        // Redirect ke halaman pegawai jika berhasil diupdate
        echo "<script>window.location.href = 'index.php?page=data-pegawai&&msg=2'</script>";
        exit();
    } else {
        // Tampilkan pesan error jika gagal
        echo "Terjadi kesalahan saat mengupdate data.";
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Edit Data Pegawai</h3>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $view['nama']; ?>">
                                <input type="text" class="form-control" name="id" value="<?= $view['id']; ?>" hidden>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select class="form-control" name="jabatan">
                                    <option value="">Pilih</option>
                                    <?php 
                                    foreach ($jabatanList as $jabatan) {
                                        $selected = ($jabatan['kode_jabatan'] == $view['kode_jabatan']) ? 'selected="selected"' : "";
                                        echo "<option value='{$jabatan['kode_jabatan']}' $selected>{$jabatan['kode_jabatan']} - {$jabatan['nama_jabatan']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Golongan</label>
                            <select class="form-control" name="kode_golongan">
                                <option selected value="">-Golongan-</option>
                                <?php 
                                foreach ($golonganList as $golongan) {
                                    $selected = ($golongan['kode_golongan'] == $view['kode_golongan']) ? 'selected="selected"' : "";
                                    echo "<option value='{$golongan['kode_golongan']}' $selected>{$golongan['nama_golongan']}</option>";
                                }
                                ?>
                            </select>
                        </div> 
                        <div class="col">
                            <label>Status</label>
                            <select class="form-control" name="status" id="status" onChange="autoAnak()">
                                <option selected value="<?= $view['status']; ?>"><?= $view['status']; ?></option>
                                <option value="belum_menikah">Belum Menikah</option>
                                <option value="menikah">Menikah</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>NIP</label>
                                <input type="text" name="nip" class="form-control" placeholder="NIP" value="<?= $view['nip']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label" for="customFile">Upload Foto</label>
                            <input type="file" name="foto" class="form-control" id="customFile">
                        </div>
                        <div class="col-sm-6">
                            <label>Jumlah Anak</label>
                            <input type="text" id="jumlahanak" class="form-control" placeholder="jumlah anak" name="jumlah_anak" value="<?= $view['jumlah_anak']; ?>" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Lokasi Penempatan</label>
                            <select class="form-control" name="kode_lokasi">
                                <?php 
                                foreach ($lokasiList as $lokasi) {
                                    $selected = ($lokasi['kode_lokasi'] == $view['kode_lokasi']) ? 'selected="selected"' : "";
                                    echo "<option value='{$lokasi['kode_lokasi']}' $selected>{$lokasi['nama_lokasi']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <img src="../assets/dist/img/foto/<?= $view['foto']; ?>" alt="your photo" height="200px" class="rounded float-right">
                        </div>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-sm btn-info">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function autoAnak(){
            var status = document.getElementById('status').value;
            var jumlahAnak = document.getElementById('jumlahanak');
            if(status == 'belum_menikah' || status == 'Belum Menikah'){
                jumlahAnak.value = '0';
                jumlahAnak.readOnly = true;
            } else {
                jumlahAnak.value = '';
                jumlahAnak.readOnly = false;
            }
        }
    </script>
</section>
