<?php require '../inc/admin_permission.inc'; ?>

<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Edit Customer</title>
		<link rel="icon" href="../images/icon.ico">
	    <link rel="stylesheet" href="../css/style.css">
	</head>
	<body onload="<?php $_SESSION['norek'] = $_GET['rekening']; ?>">
		<div class="background">

			<!-- Navigation Bar -->
			<div class="menu">
				<a class="logo" href="./admin_index.php">BANK INI</a>
				<div class="menuright">
					<a href="./admin_logout.php">Keluar</a>
				</div>
			</div>

			<!-- Form -->
			<div class="register">
		    	<div class="headform">
		    		<h3 class="center">Edit Customer</h3>
		    	</div>

		    	<?php

					require "../inc/database.php";


					$statment = null;
					select_rekening_data($db, $statment, $_SESSION['norek']);
					foreach ($statment as $row) {
						$_POST['rekening'] = $row['NO_REK'];
						$_POST['nama'] = $row['NAMA'];
						$_POST['alamat'] = $row['ALAMAT'];
						$_POST['email'] = $row['EMAIL'];
						$_POST['telepon'] = $row['NO_HP'];
						$_POST['username'] = $row['USERNAME_CUS'];
					}

					$errekening = "";
					$ernama = "";
					$eralamat = "";
					$eremail = "";
					$ertelepon = "";
					$erusername = "";
					$erpassword = "";
					$erconpassword = "";

					$error = array();
					if ((isset($_POST['rekening']) || isset($_POST['nama']) || isset($_POST['alamat']) || isset($_POST['email']) || isset($_POST['telepon']) || isset($_POST['username']) || isset($_POST['password']) || isset($_POST['conpassword'])) && isset($_POST['submit'])) {
						require '../inc/validate.php';
						validateForm($error, $_POST, 'rekening', 'saldo', 'nama', 'alamat', 'email', 'telepon', 'username', 'password', 'conpassword');
						if ($error) {
							foreach ($error as $field => $err){
								if ($field == 'nama') {
									$ernama = $err;
								}
								else if ($field == 'rekening') {
									$errekening = $err;
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
							include "../inc/form_edit.inc";
						}
						else{
							update_data($db);
							header("Location: ./admin_daftarcustomer.php");
						}
							
					}
					else{
						include "../inc/form_edit.inc";
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