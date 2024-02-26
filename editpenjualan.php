

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
        $PenjualanID=$_POST['PenjualanID'];
        $TanggalPenjualan=$_POST['TanggalPenjualan'];
        $TotalHarga=$_POST['TotalHarga'];
        
        $simpan=mysqli_query($koneksi, "update penjualan set
        PenjualanID='$PenjualanID',
        TanggalPenjualan='$TanggalPenjualan',
        TotalHarga='$TotalHarga'
        where PenjualanID='$PenjualanID'");

        if ($simpan) {
           header("location:penjualan.php");
        } else {
            echo "<div class='alert alert-danger'>Gagal Menambah Data Baru!</div> ";
        }
    }
?>
    <div class="container">
      <div class="d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="text-center">
       <h2>Form Input Data Penjualan</h2>
       <form method="post" action="">
        <?php
            $tampil=mysqli_query($koneksi, "select * from penjualan where PenjualanID='$_GET[PenjualanID]'");
            foreach ($tampil as $row){
        ?>
        <div class="form-group">
            <label><b>PenjualanID</b></label>
            <input value="<?php echo $row['PenjualanID']; ?>" class="form-control" placeholder="PenjualanID" name="PenjualanID" readonly>
        </div>
        <div class="form-group">
            <label><b>TanggalPenjualan</b></label>
            <input value="<?php echo $row['TanggalPenjualan']; ?>" type="date" class="form-control" placeholder="TanggalPenjualan" name="TanggalPenjualan">
        </div>
        <div class="form-group">
            <label><b>TotalHarga</b></label>
            <input value="<?php echo $row['TotalHarga']; ?>" type="text" class="form-control" placeholder="TotalHarga" name="TotalHarga">
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
