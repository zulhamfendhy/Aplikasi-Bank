<!DOCTYPE html>
<html lang="id">
	<head>
		<title>Login Admin</title>
		<link rel="icon" href="../images/icon.ico">
		<link rel="stylesheet" href="../css/style.css">
	</head>
	<body>
		<div class="background">

			<!-- Header -->
	        <div class="menu">
	            <p class="logo">BANK INI</p>
	        </div>

	        <?php

				require "../inc/database.php";

				$erusername = "";
				$erpassword = "";
				$erdata = "";

				$error = array();
				if (isset($_POST['username']) || isset($_POST['password'])) {
					require '../inc/validate.php';

					// Validasi input error
					validateLogin($error, $_POST, 'username', 'password');
					if ($error) {
						foreach ($error as $field => $err){
							if ($field == 'username') {
								$erusername = $err;
							}
							else if ($field == 'password') {
								$erpassword = $err;
							}
						}
						include '../inc/form_login.php';
					}
					else{
						if (check_admin($db, $_POST['username'], $_POST['password'])) {
							session_start();
							$_SESSION['isAdmin'] = true;
							header("Location: ./admin_index.php");
							exit();
						}
						else{
							$erdata = "data tidak ditemukan";
							include '../inc/form_login.php';
						}
					}
				}
				else{
					include '../inc/form_login.php';
				}
			?>

	    </div>

	    <!-- Footer -->
	    <div class="footer">
	    	<p>&copy; BANK INI 2018</p>
	    </div>
	</body>
</html>