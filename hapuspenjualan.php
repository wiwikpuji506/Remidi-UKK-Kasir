<?php
include "koneksi.php";
$hapus = mysqli_query($koneksi, "delete from penjualan  where PenjualanID='$_GET[PenjualanID]'");
header("location:penjualan.php");
?>
