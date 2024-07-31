<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once '../database/class/pegawai.php';

$pdo = Koneksi::connect();
$pegawai = Pegawai::getInstance($pdo);

$mpdf = new \Mpdf\Mpdf(); // Create an mPDF instance

$dataPegawai = $pegawai->getGajiPegawai();

// Define the HTML content with your table
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<center>
<div style="text-align:center">
<h2 style="margin-bottom: -15px;">Laporan Gaji Pegawai</h2>
<h2 style="margin-bottom: 15px;">RaR Corp</h2>
<hr style="height: 4px; margin-top: -10px;" width="3px">
<br>
<br>
</div>
<center>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th width="40px">No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Status</th>
            <th>Jabatan</th>
            <th>Golongan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan Suami Istri</th>
            <th>Tunjangan Anak</th>
            <th>Uang Makan</th>
            <th>Askes</th>
            <th>Total Gaji</th>
        </tr>
    </thead>
    <tbody>';

$no = 1;
foreach ($dataPegawai as $pgw) {
    $html .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . $pgw['nama'] . '</td>
        <td>' . $pgw['nip'] . '</td>
        <td>' . $pgw['status'] . '</td>
        <td>' . $pgw['nama_jabatan'] . '</td>
        <td>' . $pgw['nama_golongan'] . '</td>
        <td>' . $pgw['gapok'] . '</td>
        <td>' . $pgw['tjsi'] . '</td>
        <td>' . $pgw['tjanak'] . '</td>
        <td>' . $pgw['uangmakan'] . '</td>
        <td>' . $pgw['askes'] . '</td>
        <td>' . $pgw['totalgaji'] . '</td>
    </tr>';
}

$html .= '
    </tbody>
</table>
</body>
</html>';

$mpdf->WriteHTML($html); // Add HTML content to the PDF

// Output the PDF to the browser for download
$mpdf->Output(); // 'D' sends the PDF to the browser for download
?>
