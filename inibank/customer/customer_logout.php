<?php
    session_start();
    unset($_SESSION['cust']);
	header("Location: ../index.php");
?>
