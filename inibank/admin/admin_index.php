<?php

session_start();
if(!isset($_SESSION['isAdmin'])){
    header("Location: ./admin_login.php");
    exit();
}

?>

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

        <!-- Content -->
    	<div class="row">
            <div class="center">
                <h1>Kamu masuk sebagai Admin..</h1>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer"> 
        <p>&copy; BANK INI 2018</p>
    </div>
</body>
</html>