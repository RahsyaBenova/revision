<?php
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

if(isset($_POST["hidden_div_html"]) && $_POST["hidden_div_html"] != '' && isset($_POST["chart_image"]) && $_POST["chart_image"] != '')
{
    $chart_image = $_POST["chart_image"];

    $html = '<img src="' . $chart_image . '" style="width: 100%; height: auto;">';
    
    // Optionally, you can include other HTML content here
    // $html .= $_POST["hidden_div_html"];

    $mpdf->WriteHTML($html);
    $mpdf->Output();
}
?>
