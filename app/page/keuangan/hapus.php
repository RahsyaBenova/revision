<?php
$id = $_GET['id'];
$keuangan = Keuangan::getInstance();
$success = $keuangan->deleteKeuangan($id);

if ($success) {
    echo "<script>window.location.href = 'index.php?page=data-keuangan'</script>";
} else {
    echo "<script>window.location.href = 'index.php?page=data-keuangan'</script>";
}
?>
