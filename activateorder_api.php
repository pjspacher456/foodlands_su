<?php
	session_start();
	include "config.php";
	if ($conn->connect_error)
	{
	    die("Connection failed: " . $conn->connect_error);
	    exit();
	}
	else
	{
		$sql = "SELECT * FROM order_product WHERE sid = '".trim($_GET['sid'])."' AND username = '".trim($_GET['username'])."' ";
		$result = $conn->query($sql);

		if ($result->num_rows<1)
		{

			echo "Activate Invalid !";
			// header("Location:register-faild.php");

		}else{
			$sql = "UPDATE order_product SET activate = 'yes'  WHERE sid = '".trim($_GET['sid'])."' AND username = '".trim($_GET['username'])."' ";
			$resultquery = $conn->query($sql);

			echo "Success";
			$_SESSION["check"] = 1 ;
			header("order-success.php");

		}
		$conn->close();
	}
?>