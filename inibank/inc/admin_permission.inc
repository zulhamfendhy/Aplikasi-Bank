<?php

session_start();
if(!isset($_SESSION['isAdmin'])){
	header("Location: ./admin_login.php");
	exit();
}

?>