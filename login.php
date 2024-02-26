<?php 
 if(isset($_GET['pesan'])){
 if($_GET['pesan'] == "gagal"){
 echo "Login gagal! username dan password salah!";
 }else if($_GET['pesan'] == "logout"){
 echo "Anda telah berhasil logout";
 }else if($_GET['pesan'] == "belum_login"){
 echo "Anda harus login untuk mengakses halaman admin";
 }
 }
 ?>

<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

	<title>Login</title>
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-md-4 offset-md-4">

				<div class="card mt-5">
					<div class="card-title text-center">
						<h1>Login Form</h1>
					</div>
					<div class="card-body">
						<form action="log.php" method="post">
							<div class="form-group">
								<label for="user">Username</label>
								<input type="text" name="user" class="form-control" id="user" aria-describedby="username" placeholder="User">

							</div>
							<div class="form-group">
								<label for="pass">Password</label>
								<input type="pass" name="pass" class="form-control" id="pass" placeholder="Pass">
							</div>

							<button type="submit" class="btn btn-primary">Submit</button>
						</form>

					</div>
				</div>
			</div>

		</div>

	</div>
</body>