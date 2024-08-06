<?php
// Pemeriksaan level pengguna

if ($_SESSION['level'] === "common_user") {
    echo "<h1>Akses Ditolak!</h1>";
    echo "<script>window.location.href = 'index.php?page=warning';</script>";
    exit;
}

// Koneksi ke database
$db = Koneksi::connect();

// Ambil data keuangan
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
    <title>Data Keuangan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="path/to/your/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
<?php if ($_SESSION['level'] !== "common_user"): ?>
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <!-- Display statistics here -->
        </div>

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
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <!-- Chart -->
                            <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>

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
<?php endif; ?>
</body>
</html>
