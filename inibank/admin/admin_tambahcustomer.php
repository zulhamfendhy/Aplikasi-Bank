<?php require '../inc/admin_permission.inc'; ?>

<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Bank Administrator</title>
	    <link rel="icon" href="../images/icon.ico">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="background">

			<!-- Navigation Bar -->
			<div class="menu">
				<a class="logo" href="./admin_index.php">BANK INI</a>
				<div class="menuright">
					<a href="./admin_daftarcustomer.php">Daftar Customer</a>
					<a href="./admin_tambahcustomer.php">Tambah Customer</a>
					<a href="./admin_logout.php">Keluar</a>
				</div>
			</div>

			<!-- Form -->
			<div class="register">
				<div class="headform">
					<h3 class="center">Tambah Customer</h3>
				</div>

				<?php

					require "../inc/database.php";

					// Variabel untuk tampilan error
					$errekening = "";
					$ersaldo = "";
					$ernama = "";
					$eralamat = "";
					$eremail = "";
					$ertelepon = "";
					$erusername = "";
					$erpassword = "";
					$erconpassword = "";

					$error = array();
					if (isset($_POST['rekening']) || isset($_POST['saldo']) || isset($_POST['nama']) || isset($_POST['alamat']) || isset($_POST['email']) || isset($_POST['telepon']) || isset($_POST['username']) || isset($_POST['password']) || isset($_POST['conpassword'])) {
						require '../inc/validate.php';

						// Validasi input 
						validateForm($error, $_POST, 'rekening', 'saldo', 'nama', 'alamat', 'email', 'telepon', 'username', 'password', 'conpassword');
						if ($error) {
							foreach ($error as $field => $err){
								if ($field == 'rekening') {
									$errekening = $err;
								}
								else if ($field == 'saldo') {
									$ersaldo = $err;
								}
								else if ($field == 'nama') {
									$ernama = $err;
								}
								else if ($field == 'alamat') {
									$eralamat = $err;
								}
								else if ($field == 'email') {
									$eremail = $err;
								}
								else if ($field == 'telepon') {
									$ertelepon = $err;
								}
								else if ($field == 'username') {
									$erusername = $err;
								}
								else if ($field == 'password') {
									$erpassword = $err;
								}
								else if ($field == 'conpassword') {
									$erconpassword = $err;
								}
								
							}
							include '../inc/form_tambah.inc';
						}
						else{
							insert_data($db); //Menambah data ke database
							transfer_admin($db); //Transfer ke rekening
							riwayat_admin($db); //Menambah riwayat transfer
							echo '<p><b>Data berhasil dibuat</b></p>';
							header("Refresh:1");
						}
					}
					else{
						include '../inc/form_tambah.inc';
					}
				?>
			</div>
		</div>

		<!-- Footer -->
		<div class="footer"> 
	        <p>&copy; BANK INI 2018</p>
	    </div>
	</body>
</html>