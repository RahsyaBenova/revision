<?php
session_start();
if(!$_SESSION['nama']){
  header('location: ../index.php?session=expired');
  exit;
}

require_once "../../conf/config.php";
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tb_pegawai WHERE id='$id'" );
$view = mysqli_fetch_array($query);


include ('../../conf/config.php');

use Mpdf\Mpdf;

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
<table cellspacing="none" style="margin-left: auto;
margin-right: auto;">
<tr>
<td colspan="7" style="height: 5px;">
    <hr style="margin-bottom:2px; margin-left:-5px;", size="3" color="grey">
</td>
</tr>
<thead>
    
    <tr>
        <th style="width: 10px;">No</th>
        <th style="width: 100px;">Tanggal</th>
        <th style="width: 100px;">keterangan</th>
        <th style="width: 100x;">Pemasukan</th>
        <th style="width: 100px;">Pengeluaran</th>
    </tr>
    
    <tr>
    <td colspan="7" style="height: 5px;">
        <hr style="margin-bottom:2px; margin-left:-5px;", size="3" color="grey">
    </td>
</tr>
</thead>
';
$no =0;
                 $totalpemasukan=0;
                 $totalpengeluaran=0;
                $dataGaji =mysqli_query($conn, "SELECT * FROM tb_pegawai");
                // $totalpemasukan =mysqli_query($conn, "SELECT SUM(pemasukan) FROM tb_keuangan");
                while ($data = mysqli_fetch_array($dataGaji)){  
                    $totalGaji = $data["pemasukan"];
                    $totalpengeluaran += $data["pengeluaran"];
                    $no++;
                    $html .= '<tr>
                    <td>'. $no .'</td>
                    <td align="center">'. $data['tanggal'] .'</td>
                    <td align="center">'. $data['keterangan'] .'</td>
                    <td align="center">'. $data['pemasukan'] .'</td>
                    <td align="center">'. $data['pengeluaran'] .'</td>
                              </tr>';
                }

               $html .= ' <tr>
               <td colspan="7" style="height: 5px;">
                   <hr style="margin-bottom:2px; margin-left:-5px;", size="3" color="grey">
               </td>
           </tr>
               <tr>
                <td align="center" colspan="2" style="font-size: 25px; border: none;"><b>Total</b> </td>
                <td></td>
                <td align="center">Pemasukan :</td>
                <td align="center">Rp '.number_format($totalpemasukan) .'</td>
               </tr>
           </tr>
               <tr>
                <td align="center" colspan="2" style="font-size: 25px; border: none;"></b> </td>
                <td></td>
                <td align="center">Pengeluaran :</td>
                <td align="center">Rp '.number_format($totalpengeluaran).'</td>
                
               </tr>';
$html .= '</table>
</center>
</body> 
</html>';

$mpdf->WriteHTML($html);
$mpdf->Output();
?>