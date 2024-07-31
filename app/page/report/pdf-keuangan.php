<?php
if(!isset($_SESSION['nama'])){
  header('location: ../index.php?session=expired');
  exit;
}

require_once '../database/class/keuangan.php';

use Mpdf\Mpdf;

// Connect to the database
$pdo = Koneksi::connect();
$keuangan = Keuangan::getInstance();

// Fetch all financial records
$keuanganData = $keuangan->getAllKeuangan();

require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new Mpdf();
$html = '
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
</head>
<body>
    <div style="text-align:center">
    <h2 style="margin-bottom: -15px;">Laporan Keuangan</h2>
    <h2 style="margin-bottom: 15px;">RaR Corp</h2>
    </div>
<center>
<table cellspacing="none" style="margin-left: auto; margin-right: auto;">
<tr>
<td colspan="5" style="height: 5px;">
    <hr style="margin-bottom:2px; margin-left:-5px;" size="3" color="grey">
</td>
</tr>
<thead>
    <tr>
        <th style="width: 10px;">No</th>
        <th style="width: 100px;">Tanggal</th>
        <th style="width: 100px;">Keterangan</th>
        <th style="width: 100px;">Pemasukan</th>
        <th style="width: 100px;">Pengeluaran</th>
    </tr>
    <tr>
    <td colspan="5" style="height: 5px;">
        <hr style="margin-bottom:2px; margin-left:-5px;" size="3" color="grey">
    </td>
</tr>
</thead>
';

$no = 0;
$totalPemasukan = 0;
$totalPengeluaran = 0;

foreach ($keuanganData as $data) {
    $totalPemasukan += $data["pemasukan"];
    $totalPengeluaran += $data["pengeluaran"];
    $no++;
    $html .= '<tr>
        <td>' . $no . '</td>
        <td align="center">' . $data['tanggal'] . '</td>
        <td align="center">' . $data['keterangan'] . '</td>
        <td align="center">' . number_format($data['pemasukan']) . '</td>
        <td align="center">' . number_format($data['pengeluaran']) . '</td>
    </tr>';
}

$html .= '
<tr>
   <td colspan="5" style="height: 5px;">
       <hr style="margin-bottom:2px; margin-left:-5px;" size="3" color="grey">
   </td>
</tr>
<tr>
    <td align="center" colspan="3" style="font-size: 25px; border: none;"><b>Total</b></td>
    <td align="center">Pemasukan :</td>
    <td align="center">Rp ' . number_format($totalPemasukan) . '</td>
</tr>
<tr>
    <td align="center" colspan="3" style="font-size: 25px; border: none;"></td>
    <td align="center">Pengeluaran :</td>
    <td align="center">Rp ' . number_format($totalPengeluaran) . '</td>
</tr>
';

$html .= '</table>
</center>
</body>
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();
?>
