<?php
    session_start();
    if(!isset($_SESSION["studentid"])) {
        header("Location: login.php");
        exit();
    }
?>