<?php 
    session_start();
    include 'koneksi.php';
 
    // menangkap data yang dikirim dari form login
    $user = $_POST['user'];
    $pass = $_POST['pass'];
 
    // menyeleksi data pada tabel admin dengan username dan password yang sesuai
    $data = mysqli_query($koneksi, "SELECT * FROM kasir WHERE user='$user' and pass='$pass'");
 
    // menghitung jumlah data yang ditemukan
    $cek = mysqli_num_rows($data);
 
    if($cek > 0){
        $_SESSION['user'] = $user;
        $_SESSION['status'] = "login";
        header("location:dashboard.php");
    }
    else{
        header("location:login.php?pesan=gagal");
    }
?>
Perhatikan baris dem