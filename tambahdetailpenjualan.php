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
include ("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $PenjualanID = $_POST['PenjualanID'];
    $TanggalPenjualan = date("Y-m-d");
    $DetailID = $_POST['DetailID'];
    $ProdukID = $_POST['ProdukID'];
    $JumlahProduk = $_POST['JumlahProduk'];
    
    // Query untuk mengurangi stok produk
    $queryStok = "SELECT Stok, Harga FROM produk WHERE ProdukID = '$ProdukID'";
    $resultStok = mysqli_query($koneksi, $queryStok);
    $rowStok = mysqli_fetch_assoc($resultStok);
    $stok_produk = $rowStok['Stok'];
    $Harga = $rowStok['Harga'];

    // Hitung subtotal
    $sub = $Harga * $JumlahProduk;

    if ($stok_produk >= $JumlahProduk) {
        // Kurangi stok produk
        $stok_baru = $stok_produk - $JumlahProduk;
        
        // Update stok produk di database
        $queryUpdateStok = "UPDATE produk SET Stok = '$stok_baru' WHERE ProdukID = '$ProdukID'";
        mysqli_query($koneksi, $queryUpdateStok);
        
        // Simpan data ke tabel detail_penjualan
        $queryDetail = "INSERT INTO detail_penjualan (DetailID, PenjualanID, ProdukID, JumlahProduk, SubTotal) VALUES ('$DetailID', '$PenjualanID', '$ProdukID', '$JumlahProduk','$sub')";
        mysqli_query($koneksi, $queryDetail);
        
        // Hitung total harga dari semua barang yang ada dalam penjualan
        $queryTotal = "SELECT SUM(SubTotal) AS TotalHarga FROM detail_penjualan WHERE PenjualanID = '$PenjualanID'";
        $resultTotal = mysqli_query($koneksi, $queryTotal);
        $rowTotal = mysqli_fetch_assoc($resultTotal);
        $totalHarga = $rowTotal['TotalHarga'];
        
        // Simpan data ke tabel penjualan
        $queryPenjualan = "INSERT INTO penjualan (PenjualanID, TanggalPenjualan, TotalHarga) VALUES ('$PenjualanID', '$TanggalPenjualan', '$totalHarga')";
        mysqli_query($koneksi, $queryPenjualan);
    
        // Redirect atau lakukan tindakan lain setelah berhasil menyimpan
        header("Location: detail_penjualan.php");
        exit();
    } else {
        // Stok produk tidak mencukupi
        echo "Stok produk tidak mencukupi untuk transaksi ini.";
    }
}
?>
            <section class="py-5">
                <div class="container px-5">
                    <!-- Contact form-->
                    <div class="bg-light rounded-3 py-5 px-4 px-md-5 mb-5">
                        <div class="text-center mb-5">
                            
                            <h1 class="fw-bolder">APLIAKSI KASIR
                            </h1>
                            <p class="lead fw-normal text-muted mb-0">Form Kasir</p>
                        </div>
                        <div class="row gx-5 justify-content-center">
                            <div class="col-lg-8 col-xl-6">
                                <form action="#" data-sb-form-api-token="API_TOKEN" method="POST">
                                    <!-- NIK input with person icon -->
                                    <div class="form-group">
                                        <label><b>PenjualanID</b></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="text" class="form-control" placeholder="Masukkan Id Penjualan anda" name="PenjualanID" required>
                                        </div>
                                    </div>

                                    <!-- Nama input with person icon -->
                                    <div class="form-group">
                                        <label><b>TanggalPenjualan</b></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                                            <input type="date" class="form-control" placeholder="" name="TanggalPenjualan" required>
                                        </div>
                                    </div>
                                    <script>
                                    // JavaScript code to set the default value to today's date
                                    document.getElementById('TanggalPenjualan').valueAsDate = new Date();
                                    </script>

                                    <!-- No telepon input with person icon -->
                                    <div class="form-group">
                                        <label><b>DetailID</b></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                            <input type="text" class="form-control" placeholder="Masukkan Id Detail anda" name="DetailID" required>
                                        </div>
                                    </div>

                                    <!-- Tanggal Pengaduan input with calendar icon -->
                                    <div class="form-group">
                                    <label for="id_produk">ProdukID</label><select name="ProdukID" class="form-control">
                                    <option disabled selected>Pilih</option>
                                    <?php
                                    $t_produk = mysqli_query($koneksi, "select ProdukID, NamaProduk from produk");
                                    foreach ($t_produk as $produk) {
                                    echo "<option value=$produk[ProdukID]>$produk[NamaProduk]</option>";
                      }            
                      ?>
                      </select>
                                </div>

                                    <!-- Isi input with chat-text icon -->
                                    <div class="form-group">
                                        <label><b>JumlahProduk</b></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-chat-text"></i></span>
                                            <input type="text" class="form-control" placeholder="Masukkan Jumlah Produk anda" name="JumlahProduk" required>
                                        </div>
                                    </div>


                                        <!-- Add some space between the input and buttons -->
                                    <div class="mb-3"></div>

                                    <!-- Center the buttons using text-center class -->
                                    <div class="text-center">
                                        <button type="submit" name="ok" class="btn btn-primary fw-bold">Simpan</button>
                                        <a href="detail_penjualan.php" class="btn btn-secondary fw-bold">Lihat Data</a>
                                    </div>
                                
                                        <div class="text-center mb-3">
                                            <br />
                                            
                                        </div>
                                        
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
