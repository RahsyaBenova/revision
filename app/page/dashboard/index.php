

<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" id="report-pgw"></div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Data Keuangan
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                    <button type="button" onclick="downloadPDF()"  class="btn btn-info" data-toggle="modal"> Cetak Grafik</button></li>
                    
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;">
                       <canvas id="myChart" width="400" height="200"></canvas>
                   </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                  </div>
                  <div class="card-header">
            
               </div>
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DIRECT CHAT -->
           
            <!--/.direct-chat -->

            <!-- TO DO List -->
         
            <!-- /.card -->
        
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
        

           

            <!-- solid sales graph -->
           
            <!-- /.card -->

            <!-- Calendar -->

            <!-- /.card -->
          
          <!-- right col -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
      
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
    </section>