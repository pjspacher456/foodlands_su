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
		$sql = "SELECT * FROM member WHERE sid = '".trim($_GET['sid'])."' AND username = '".trim($_GET['username'])."' ";
		$result = $conn->query($sql);

		if ($result->num_rows<1)
		{

			echo "Activate Invalid !";
			// header("Location:register-faild.php");

		}else{
			$sql = "UPDATE member SET confirm = 'y'  WHERE sid = '".trim($_GET['sid'])."' AND username = '".trim($_GET['username'])."' ";
			$resultquery = $conn->query($sql);

			echo "Success";
			$_SESSION["check"] = 1 ;
			header("location:activate_success.php");

		}
		$conn->close();
	}
?>
