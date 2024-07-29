<!-- Main content -->
<?php 

if($_SESSION['level'] =="common_user")  {
  echo "<h1>Akses Ditolak!</h1>";
  return false;
}
date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d');


?>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              
            <div class="card">
              <div class="card-header">
                <h2 class="card-title">Tabel Keuangan</h2>
              </div>
              <!-- /.card-header -->
              <div class="card-body d-inline"><?php if($_SESSION['level'] =="superadmin")  {
                    echo "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#modal-lg'>
                    Tambah Data
                  </button>";
                    } ?>
              
                
                <!-- <div class="dropdown d-inline" >
                  <button class="btn btn-sm btn-success float-right dropdown-toggle w-20" style="height:36px" type="button" data-bs-toggle="dropdown" >Cetak</button>
                  <ul class="dropdown-menu">
                    <li><button type="button" onclick="printdoc()" class="dropdown-item"> Data Keuangan</button></li>
                  </ul>
                </div> -->
                <div class="dropdown d-inline">
                <button class="btn btn-success dropdown-toggle  w-20" style="height:36px" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Cetak
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="report/pdf-keuangan.php" target="_blank">Tabel Data Keuangan</a>
                  <a class="dropdown-item" onclick="downloadPDF()" target="_blank">Grafik Data Keuangan</a>
                </div>
              </div>
                <br><br>
                <table  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <?php if($_SESSION['level'] =="superadmin")  {
                    echo "<th>Action</th>";
                    } ?>
                  </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $no =0;
                    $query = mysqli_query($conn ,"SELECT * FROM tb_keuangan");
                    while($uang = mysqli_fetch_array($query)){
                      $no++
                    ?>
                  <tr>
                    <td width="3%"><?= $no; ?></td>
                    <td><?= $uang['tanggal'];?></td>
                    <td><?= $uang['keterangan'];?></td> 
                    <td><?= "Rp". " " .$uang['pemasukan'];?></td> 
                    <td><?= "Rp". " " .$uang['pengeluaran'];?></td> 
                    <?php if($_SESSION['level'] =="superadmin")  {
                    echo "<td><a href='index.php?page=edit-data-keuangan&&id=$uang[id];' class='btn btn-success btn-sm'>Edit</a>
                    <a onclick='hapus_data($uang[id])' class='btn btn-danger btn-sm'>Hapus</a>
                     ";
                    } ?>
                    </td>
                  </tr>
                  <?php } ?>
                  </tbody>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                    <?php if($_SESSION['level'] =="superadmin")  {
                    echo "<th>Action</th>";
                    } ?>
                    
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
            <form method="get" action="add/tambah_data_keuangan.php" enctype="multipart/form-data">
              
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
                <input type="date" id="tanggal" name="tanggal" value="<?=$date;?>">
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
        </div>
      </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    <!-- swal -->
      <script>
        function hapus_data(data_id){
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
    window.location=("delete/hapus_data_keuangan.php?id="+data_id);
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


<!-- print / cetak dokumen -->
<script>
  function printDoc(){
    const myWindow = window.open("report/pdf-keuangan.php");
  }

</script>


<!-- chart -->
<?php 
try {
    $db = new PDO('mysql:host=localhost;dbname=db_kepegawaian', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Koneksi gagal: ' . $e->getMessage());
}

$query = "SELECT tanggal, pemasukan, pengeluaran FROM tb_keuangan";
$result = $db->query($query);

if ($result) {
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Gagal mengambil data.";
}
$tanggal = [];
$pemasukan = [];
$pengeluaran = [];

foreach ($data as $row) {
    $tanggal[] = $row['tanggal'];
    $pemasukan[] = $row['pemasukan'];
    $pengeluaran[] = $row['pengeluaran'];
}

// Ambil data dari database
// ...

// Ubah data ke format yang sesuai
$data = [
  'labels' => $tanggal,
  'datasets' => [
      [
          'label' => 'Pemasukan',
          'data' => $pemasukan,
          'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
          'borderColor' => 'rgba(75, 192, 192, 1)',
          'borderWidth' => 1,
      ],
      [
          'label' => 'Pengeluaran',
          'data' => $pengeluaran,
          'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
          'borderColor' => 'rgba(255, 99, 132, 1)',
          'borderWidth' => 1,
      ],
  ],
];

?>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar', // Tipe grafik (misalnya, bar, line, pie)
    data: <?php echo json_encode($data); ?>,
    options: {
        // Konfigurasi grafik (opsional)
    }
});
</script>

<!-- cetak chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
      <script>
        function downloadPDF(){
        const canvas = document.getElementById('myChart');
        const canvasImage = canvas.toDataURL('image/jpeg', 1.0);
        let pdf = new jspdf.jsPDF({
          orientation: 'landscape'
        });
        pdf.setFontSize(20);
        pdf.addImage(canvasImage, 'jpeg', 15,15,280,150);
        pdf.save('Grafik Data Keuangan.pdf');
    }

      </script>