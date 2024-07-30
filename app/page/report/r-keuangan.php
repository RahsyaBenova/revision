<?php 
session_start();
if(!$_SESSION['nama']){
  header('location: ../index.php?session=expired');
  exit;
}

require_once "../../conf/config.php";
?>

<!DOCTYPE html>
<html lang="en">
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
    <table cellspacing="10px" style="border-bottom: 3px solid  grey">
        <thead>
            <tr>
                <td colspan="7" style="height: 5px;">
                    <hr style="margin-bottom:2px; margin-left:-5px;", size="3" color="grey">
                </td>
            </tr>
            <tr>
                <th style="width: 10px;">No</th>
                <th style="width: 100px;">Tanggal</th>
                <th style="width: 100px;">keterangan</th>
                <th style="width: 100x;">Pemasukan</th>
                <th style="width: 100px;">Pengeluaran</th>
            </tr>
            <tr>
                <td colspan="7">
                    <hr style="margin-bottom: 2px; margin-top: 1px; margin-left: -5px;", size="3" color="grey">
                </td>
            </tr>
        </thead>
        <tbody>
            <?php 
                 $no =0;
                 $totalpemasukan=0;
                 $totalpengeluaran=0;
                $dataKeuangan =mysqli_query($conn, "SELECT * FROM tb_keuangan");
                // $totalpemasukan =mysqli_query($conn, "SELECT SUM(pemasukan) FROM tb_keuangan");
                while ($data = mysqli_fetch_array($dataKeuangan)){  
                    $totalpemasukan += $data["pemasukan"];
                    $totalpengeluaran += $data["pengeluaran"];
                    $no++?>
                <tr>
                    <td align="center"><?= $no; ?></td>
                    <td align="center"><?= $data['tanggal']; ?></td>
                    <td align="center"><?= $data['keterangan']; ?></td>
                    <td align="center">Rp <?= $data['pemasukan']; ?></td>
                    <td align="center">Rp <?= $data['pengeluaran']; ?></td>
                </tr>    
               <?php } ?>
               <tr>
                <td colspan="7">
                    <hr style="margin-bottom: 2px;  padding-top margin-left: -5px;", size="3" color="grey">
                </td>
                </tr>
               <tr>
                <td align="center" colspan="2" style="font-size: 25px;"><b>Total</b> </td>
                <td></td>
                <td align="center">Rp <?= number_format($totalpemasukan);?></td>
                <td align="center">Rp <?= number_format($totalpengeluaran);?></td>
               </tr>
           
        </tbody>
    </table>
    </center>
</body>

<script type="text/javascript">
        window.print();
</script>
</html>