<?php
include "koneksi.php";
$hapus = mysqli_query($koneksi, "delete from produk  where ProdukID='$_GET[ProdukID]'");
header("location:produk.php");
?>
