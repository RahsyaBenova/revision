<?php
$db = Koneksi::connect();

$query = "SELECT tanggal, pemasukan, pengeluaran FROM tb_keuangan";
$result = $db->query($query);

if ($result) {
    $data = $result->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Gagal mengambil data.";
    $data = [];
}

$tanggal = [];
$pemasukan = [];
$pengeluaran = [];

foreach ($data as $row) {
    $tanggal[] = $row['tanggal'];
    $pemasukan[] = $row['pemasukan'];
    $pengeluaran[] = $row['pengeluaran'];
}

$chartData = [
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
<!DOCTYPE html>
<html>
<head>
    <title>Chart.js Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
</head>
<body>
<?php 
include "../database/class/count.php";
$pdo = Koneksi::connect();
$count = count::getInstance($pdo);
$view = $count->countData("users");
$view2 = $count->countData("tb_pegawai");
?>
<section class="content">
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?= $view ?></h3>
          <p>Professional Worker</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="#" class="small-box-footer">Jumlah Pegawai<i class="fas"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?= $view2 ?></h3>
          <p>User Registrations</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer">Registrasi User</a>
      </div>
    </div>
    <!-- ./col -->
  </div>
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row" id="report-pgw"></div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">
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
                                <form method="post" id="new_pdf" action="index.php?cetak=grafik" target="_blank">
                                <input type="hidden" name="hidden_div_html" id="hidden_div_html" />
                                <input type="hidden" name="chart_image" id="chart_image" />
                                <button type="button" id="create_pdf" class="btn btn-info">Cetak Grafik</button>
                               </form>
                                </li>
                            </ul>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Chart -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </section><!-- /.Left col -->
        </div><!-- /.row (main row) -->
    </div><!-- /.container-fluid -->

   

    <script>
        $(document).ready(function(){
            var ctx = document.getElementById('myChart').getContext('2d');
            var chartData = <?php echo json_encode($chartData); ?>;

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: 'Grafik Data Keuangan'
                    }
                }
            });

            $('#create_pdf').click(function(){
                const canvas = document.getElementById('myChart');
                const canvasImage = canvas.toDataURL('image/png');
                $('#chart_image').val(canvasImage);
                $('#hidden_div_html').val($('#revenue-chart').html());
                $('#new_pdf').submit();
            });
        });
    </script>
</body>
</html>
