<?php include '../inc/customer_permission.inc'; require "../inc/function.php"; ?>
<!DOCTYPE html>
<html lang="id">
	<head>
	    <title>Tranfer</title>
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

		    <!-- Form -->
		    <div class="register">
		    	<div class="headform">
					<h3 class="center">Transfer</h3>
				</div>
					<?php 
						//variable yang digunakan untuk validasi
						$acc =$value ="";
						$t = true;
						//validasi akun bank 
						if($_SERVER["REQUEST_METHOD"]=="POST"){
							if(isset($_POST["acc"])){
								$acc1 = validateAcc($_SESSION['user'],$_POST['acc']);
								$acc = $acc1[0];
							}
							//validasi nilai pada uang yang akan di transfer
							if(isset($_POST["value"])){
								$val1 = validateVal($_POST['value'],$_SESSION['user'],$dbc);
								$value = $val1[0];
							}
							//transfer jika inputan sudah benar 
							if ($val1[1] == $t && $acc1[1] == $t){
								$value2 = (float) $_POST['value'];
								transfer($dbc,$_SESSION['user'],$_POST['acc'],$value2);
								header("Location: ./customer_browse.php");
							}
						}
					?>

					<!-- inputan untuk memasukkan akun bank -->
					<form name='myform' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='post'>
						<div class="form-row">
							<div class="col-25"><label>Rekening Tujuan</label></div>
							<div class="col-40"><input type='text' name='acc' id='acc'/></div>
							<div class="col-35"><?php echo $acc ;?></div>
						</div>

						<!-- inputan untuk memasukk -->
						<div class="form-row">
							<div class="col-25"><label>Jumlah Uang</label></div>
							<div class="col-40"><input type='text' name='value' id='value'></div>
							<div class="col-35"><?php echo $value ;?></div>
						</div>

						<div class="form-row">
							<div class="col-25"></div>
							<div class="col-25"><input type='submit' value='Submit' name='submit'/></div>
						</div>
					</form>
		    </div>
	    </div>

	    <!-- Footer -->
	    <div class="footer"> 
	         <p>&copy; BANK INI 2018</p>
	    </div>
	</body>
</html>