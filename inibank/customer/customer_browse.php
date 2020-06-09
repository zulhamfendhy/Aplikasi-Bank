<?php include '../inc/customer_permission.inc'; require "../inc/function.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tranfer History</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../images/icon.ico">
</head>

<body>
	<div class="background">

		<!-- Navigation Bar -->
	    <div class="menu">
	        <a class="logo" href="../index.php">BANK INI</a>
	        <div class="menuright">
	            <a href="./customer_browse.php">Browse</a>
	            <a href="./customer_transaksi.php">Transaksi</a>
				<a href="./customer_edit.php">Ubah Profil</a>
				<a href="./customer_logout.php">Keluar</a>
	        </div>
	    </div>
	    
	    <!-- Content -->
	    <div class="row">
	        <div class="center">
				<?php
					try{
						//perintah untuk menampilkan daftar dimana history transaksi dilakukan  
						$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
						$statement = $dbc->prepare("SELECT * FROM riwayat WHERE NO_REK = :username");
						$statement->bindValue(':username', $_SESSION['user']);
						$statement->execute();
						echo " <table class=\"center\"><thead><tr><th id=\"w25\">Tanggal Transaksi</th><th>Debet</th><th>Kredit</th><th>Saldo</th></tr></thead>";
						foreach($statement as $history){
							try{
								$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
							
								$saldo = $dbc->prepare("SELECT * FROM transfer WHERE (NO_REK = :username OR CUS_NO_REK = :username) AND ID_TRANSFER = :ID ");
								$saldo->bindValue(':username', $_SESSION['user']);
								$saldo->bindValue(':ID', $history['ID_TRANSFER']);
								$saldo->execute();
								foreach($saldo as $saldo){
									//perintah untuk menampilkan waktu 
									echo "<tbody><tr><td class=\"center\">{$saldo['WAKTU']}</td>";
								}
							}
							catch (PDOException $err){	
								$err->getMessage();echo $err;
							}
							echo "<td class=\"center\">{$history['DEBET']}</td>";
							echo "<td class=\"center\">{$history['KREDIT']}</td>";
							echo "<td class=\"center\">{$history['SALDO']}</td></tr></tbody>";
						}
						echo"</table>";
					}
					catch (PDOException $err){
						$err->getMessage();echo $err;
					}	
				?>
			</div>
	    </div>
    </div>

    <!-- Footer -->
    <div class="footer"> 
         <p>&copy; BANK INI 2018</p>
    </div>
</body>