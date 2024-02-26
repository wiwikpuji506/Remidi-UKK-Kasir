<?php
include "koneksi.php";
$hapus = mysqli_query($koneksi, "delete from detail_penjualan where DetailID='$_GET[DetailID]'");
header("location:detail_penjualan.php");
?>
