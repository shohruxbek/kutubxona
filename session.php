<?php
	session_start();
    if(!isset($_SESSION["login"]) and !isset($_SESSION["ism"])) {
        header("Location: login.php");
    }
?>