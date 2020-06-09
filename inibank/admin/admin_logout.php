<?php
session_start();
unset($_SESSION['isAdmin']);
unset($_SESSION['norek']);
header("Location: ./admin_index.php");
exit();
?>