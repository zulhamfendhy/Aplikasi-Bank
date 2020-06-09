<?php
    session_start();
    if (!isset($_SESSION['cust']))
    {
        header("Location: http:./customer_login.php");
        exit();
    }
?>