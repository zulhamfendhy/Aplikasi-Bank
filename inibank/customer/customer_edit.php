<?php include '../inc/customer_permission.inc'; require "../inc/function.php"; ?>
<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Ubah Profil</title>
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
					<h3 class="center">Edit Profil</h3>
				</div>
				<?php
				   $email = "";
					//variable yang digunakan untuk pemberitahuan eror
					$email_eror = $pass_eror1 = $pass_eror2 = $pass_eror3 = '';
					//variable yang digunakan untuk menentukan apakah akan bergerak atau tidak
					$go = $go2 = $go3 = false;

					if($_SERVER["REQUEST_METHOD"]=="POST"){
						$email = $_POST["email"];
						if(isset($_POST["email"])){
							$email_eror1 = validatEmail($email);
							$email_eror = $email_eror1[0];
						}

						//validasi password baru 
						if(isset($_POST["npass"])){
							//ketika kondisi benar
							if(empty($_POST["npass"])){
								$pass_eror2="please fill the new password form<br>";
							}
							else if(strlen($_POST['npass']<7)){	
								$pass_eror2="your password not strong enough<br>";
							}
							//ketika kondisi salah 
							else{
								$go2=true;
							}
						}

						//validasi kesamaan password baru 
						if(isset($_POST["renpass"])){
							//ketika kondisi salah 
							if (strlen($_POST['npass']<7 || empty($_POST["npass"]) )){
								if(empty($_POST["renpass"])){
									$pass_eror3="please fill the retype new password<br>";
								}	
								else {
									$pass_eror3="please correct the new password first <br>";
								}
							}
							else if(empty($_POST["renpass"])){
								$pass_eror3="please fill the retype new password<br>";$go3 = false;
							}
							else if($_POST["renpass"] != $_POST["npass"]){
								$pass_eror3="wrong type <br>";$go3 = false;
							}
							//ketika kondisi benar
							else{
								$go3=true;
							}
						}

						//ketika semua kondisi benar
						if($email_eror1[1] == true && $go2 == true && $go3 == true){
							$_SESSION['pass'] = $_POST['npass'];
							try{
								$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
								$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$statement = $dbc->prepare("UPDATE customer SET EMAIL = :email,
								PASSWORD = SHA2( :pass , 0 ) 
								WHERE NO_REK = :no_rek ");
								$statement->bindValue(':email', $_POST['email']);
								$statement->bindValue(':pass', $_POST['npass']);
								$statement->bindValue(':no_rek', $_SESSION['user']);
								$statement->execute();
							}
							catch (PDOException $err){
								$err->getMessage();
								echo $err;
							}
							header('Location: ../index.php');
						}
					}
					else{
						try{
							$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$statement = $dbc->prepare("SELECT * FROM customer WHERE NO_REK = :username ");
							$statement->bindValue(':username', $_SESSION['user']);
							$statement->execute();
						}
						catch (PDOException $err){
							$err->getMessage();
							echo $err;
						}
						foreach($statement as $profil){
							$email = $profil["EMAIL"];
						}
					}
				?>

				<form name='editform' action='customer_edit.php' method='post'>
					<div class="form-row">
						<div class="col-25"><label>Email</label></div>
						<div class="col-40"><input type='text' name='email' id='email' value="<?php echo $email; ?>"></div>
						<div class="col-35"><?php echo $email_eror; ?></div>
					</div>

					<!-- masukkan password yang baru -->
					<div class="form-row">
						<div class="col-25"><label>Password Baru</label></div>
						<div class="col-40"><input type='password' name='npass' id='npass'></div>
						<div class="col-35"><?php echo $pass_eror2; ?></div>
					</div>

					<!-- retype password yang baru  -->
					<div class="form-row">
						<div class="col-25"><label>Konfirmasi Password</label></div>
						<div class="col-40"><input type='password' name='renpass' id='renpass'></div>
						<div class="col-35"><?php echo $pass_eror3; ?></div>
					</div>
						
					<div class="form-row">
						<div class="col-25"></div>
						<div class="col-40"><input type='submit' value='Submit' name='submit'/></div>
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