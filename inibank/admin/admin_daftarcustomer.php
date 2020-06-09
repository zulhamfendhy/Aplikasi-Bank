<?php require '../inc/admin_permission.inc'; require "../inc/database.php"; ?>

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
				<a class="logo" href="../index.php">BANK INI</a>
				<div class="menuright">
					<a href="./admin_daftarcustomer.php">Daftar Customer</a>
					<a href="./admin_tambahcustomer.php">Tambah Customer</a>
					<a href="./admin_logout.php">Keluar</a>
				</div>
			</div>

			<!-- Content -->
			<div class="row">
				<div class="center">
					<h1>Daftar Customer</h1>
					<table>
						<thead>
							<tr>
								<th id="w25">No. Rekening</th>
								<th id="w55">Nama</th>
								<th id="col-2" colspan="2">Pilihan</th>
							</tr>
						</thead>
						<tbody>

							<?php

								$statment = null;
								// Mengambil data dari database
								read_all_data($db, $statment);

								foreach ($statment as $row) {
									$var = "".$row['NO_REK'];

									// Menampilkan data customer per baris
									echo "<tr>";
									echo "<td>{$row['NO_REK']}</td><td>{$row['NAMA']}</td>";
									echo "<td><a class=\"button\" href=\"./admin_editcustomer.php?rekening={$row['NO_REK']}\">Edit</a></td>";
									echo "<td><form action=\"admin_daftarcustomer.php\" method=\"POST\">
											<input type=\"hidden\" name=\"$var\" value=\"DELETE\">
											<input type=\"submit\" value=\"Delete\" /></form>
											</td>
										</tr>";

									if (isset($_POST[$var])) {
										// Menghapus data
										delete_data($db, $row['NO_REK']);
										header("Refresh:0");
									}
								}

							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- Footer -->
	    <div class="footer"> 
	        <p>&copy; BANK INI 2018</p>
	    </div>
	</body>
</html>