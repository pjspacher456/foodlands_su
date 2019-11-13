<?php
	session_start();
	header("Location:login_success.php");
	unset($_SESSION["cart_products"]);
?>