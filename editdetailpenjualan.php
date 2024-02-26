<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kasir UKK Wiwik</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <?php
include "koneksi.php";

if (isset($_POST["ok"])) {
    $DetailID = $_POST['DetailID'];
    $PenjualanID = $_POST['PenjualanID'];
    $ProdukID = $_POST['ProdukID'];
    $JumlahProduk = $_POST['JumlahProduk'];
    
    // Pastikan untuk melakukan validasi dan pembersihan data sebelum digunakan dalam kueri SQL

    // Misalnya, Anda dapat menggunakan fungsi mysqli_real_escape_string untuk membersihkan data dari potensi serangan SQL injection
    $DetailID = mysqli_real_escape_string($koneksi, $DetailID);
    $PenjualanID = mysqli_real_escape_string($koneksi, $PenjualanID);
    $ProdukID = mysqli_real_escape_string($koneksi, $ProdukID);
    $JumlahProduk = mysqli_real_escape_string($koneksi, $JumlahProduk);

    // Ambil nilai harga produk dari database berdasarkan ProdukID yang dipilih
    $queryHarga = "SELECT Harga FROM produk WHERE ProdukID = '$ProdukID'";
    $resultHarga = mysqli_query($koneksi, $queryHarga);
    $rowHarga = mysqli_fetch_assoc($resultHarga);
    $hargaProduk = $rowHarga['Harga'];

    // Hitung SubTotal
    $subTotal = $hargaProduk * $JumlahProduk;

    $simpan = mysqli_query($koneksi, "UPDATE detail_penjualan SET
        PenjualanID='$PenjualanID',
        ProdukID='$ProdukID',
        JumlahProduk='$JumlahProduk',
        SubTotal='$subTotal'
        WHERE DetailID='$DetailID'");

    if ($simpan) {
        // Perbarui TotalHarga di tabel penjualan
        $queryTotalHarga = "SELECT SUM(SubTotal) AS TotalHarga FROM detail_penjualan WHERE PenjualanID = '$PenjualanID'";
        $resultTotalHarga = mysqli_query($koneksi, $queryTotalHarga);
        $rowTotalHarga = mysqli_fetch_assoc($resultTotalHarga);
        $totalHarga = $rowTotalHarga['TotalHarga'];

        // Update TotalHarga di tabel penjualan
        $updateTotalHarga = mysqli_query($koneksi, "UPDATE penjualan SET TotalHarga = '$totalHarga' WHERE PenjualanID = '$PenjualanID'");

        if ($updateTotalHarga) {
            header("location:detail_penjualan.php");
            exit(); // Pastikan untuk keluar setelah melakukan redirect
        } else {
            // Tambahkan pesan kesalahan jika penyimpanan gagal
            $errorMessage = "Gagal Memperbarui TotalHarga: " . mysqli_error($koneksi);
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
    } else {
        // Tambahkan pesan kesalahan jika penyimpanan gagal
        $errorMessage = "Gagal Menyimpan Data Detail Penjualan: " . mysqli_error($koneksi);
        echo "<div class='alert alert-danger'>$errorMessage</div>";
    }
}
?>
    <div class="container">
      <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="text-center">
       <h2>Form Input Data Detail Penjualan</h2>
       <form method="post" action="">
        <?php
            $tampil=mysqli_query($koneksi, "select * from detail_penjualan where DetailID='$_GET[DetailID]'");
            foreach ($tampil as $row){
        ?>
        <div class="form-group">
            <label><b>DetailID</b></label>
            <input value="<?php echo $row['DetailID']; ?>" class="form-control" placeholder="DetailID" name="DetailID" readonly>
        </div>
        <div class="form-group">
            <label><b>PenjualanID</b></label>
            <input value="<?php echo $row['PenjualanID']; ?>" type="text" class="form-control" placeholder="PenjualanID" name="PenjualanID">
        </div>
        <div class="form-group">
            <label><b>ProdukID</b></label>
            <input value="<?php echo $row['ProdukID']; ?>" type="text" class="form-control" placeholder="ProdukID" name="ProdukID">
        </div>
        <div class="form-group">
            <label><b>JumlahProduk</b></label>
            <input value="<?php echo $row['JumlahProduk']; ?>" type="text" class="form-control" placeholder="JumlahProduk" name="JumlahProduk">
        </div>
        
    
        <button type="submit" name="ok" class="btn btn-primary">SIMPAN</button>
        <button type="reset" class="btn btn-danger">CANCEL</button>
        <?php } ?>
        </form>
        </div>
      </div>
    </div>
    <!-- End your project here-->

    <!-- MDB -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript"></script>
  </body>
</html>
