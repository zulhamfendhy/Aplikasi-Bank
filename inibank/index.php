<?php

    session_start();
    if (!isset($_SESSION['cust']))
    {
        header("Location: ./customer/customer_login.php");
        exit();
    }

	require "./inc/function.php";
?>
<!DOCTYPE html>
<html lang="id">
	<head>
	    <title>My Account</title>
	    <link rel="stylesheet" href="./css/style.css">
	    <link rel="icon" href="./images/icon.ico">
	</head>

	<body>
		<div class="background">

			<!-- Navigation Bar -->
		    <div class="menu">
		        <a class="logo" href="./index.php">BANK INI</a>
		        <div class="menuright">
		            <a href="./customer/customer_browse.php">Browse</a>
		            <a href="./customer/customer_transaksi.php">Transaksi</a>
					<a href="./customer/customer_edit.php">Ubah Profil</a>
					<a href="./customer/customer_logout.php">Keluar</a>
		        </div>
		    </div>

		    <!-- Content -->
		    <div class="row">
		    	<div class="center">
					<?php
						//fungsi select pada mysql dan pilihan select berdasarkan akun yang masuk
						try{ 
							$statement = $dbc->prepare("SELECT * FROM customer WHERE NO_REK = :username ");
							$statement->bindValue(':username', $_SESSION['user']);
							$statement->execute();
						}
						catch (PDOException $err){
							$err->getMessage();echo $err;
						}

						echo "<table>";

						foreach($statement as $ket ){
							//perintah untuk untuk menampilkan identitas diri  
							echo "<tr><td id=\"w25\">Nomor Rekening</td><td>{$ket['NO_REK']}</td></tr>";
							echo "<tr><td>Nama</td><td>{$ket['NAMA']}</td></tr>";
							echo "<tr><td>Alamat</td><td>{$ket['ALAMAT']}</td></tr>";
							echo "<tr><td>Email</td><td>{$ket['EMAIL']}</td></tr>";
							echo "<tr><td>Nomor Telepon</td><td>{$ket['NO_HP']}</td></tr>";
							echo "<tr><td>Jumlah Saldo</td>";
						}
						try{
							$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
							$nilai = $dbc->prepare("SELECT MAX(ID_RIWAYAT) AS ID FROM `riwayat` WHERE NO_REK = :username ");
							$nilai->bindValue(':username', $_SESSION['user']);
							
							$nilai->execute();
							
						}
						catch (PDOException $err){
							$err->getMessage();echo $err;
						}
						//perintah untuk mengeluarkan nilai saldo yang masih ada 
						foreach($nilai as $ket){
							try{
								$saldo = $dbc->prepare("SELECT * FROM `riwayat` WHERE NO_REK = :username AND ID_RIWAYAT = :ID ");
								$saldo->bindValue(':username', $_SESSION['user']);
								$saldo->bindValue(':ID', $ket['ID']);
								$saldo->execute();
								foreach($saldo as $saldo){
									echo "<td>{$saldo['SALDO']}</td></tr>";
								}
							}
							catch (PDOException $err){
								$err->getMessage();echo $err;
							}
						}
						echo "</table>";
					?>
		        </div>
	        </div>
	    </div>

	    <!-- Footer -->
	    <div class="footer"> 
	         <p>&copy; BANK INI 2018</p>
	    </div>
	</body>
</html>