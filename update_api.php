<?php
	session_start();
	include "config.php";
	$name = $_POST["name"];
	$tel = $_POST["tel"];
	$email = $_POST["email"];
	$username = $_POST["username"];
	$password = $_POST["password"];
	$type = $_POST["f_type"];

	if ($conn->connect_error)
	{
	    die("Connection failed: " . $conn->connect_error);
	    exit();
	}
	else
	{
		$sql = "SELECT * FROM member WHERE username = '".$username."' ";
		$result = $conn->query($sql);

		if ($result->num_rows>0)
		{

			header("Location:register.php");
			$_SESSION["check"] = 0;

		}else{
			$sql = "INSERT INTO member(name, username, password, email, tel, type, sid, confirm) VALUES ('".$name."','".$username."','".$password."','".$email."','".$tel."','".$type."','".session_id()."','no')";
			$resultquery = $conn->query($sql);
			echo "Register Complete";
			$_SESSION["check"] = 1;	
			
			// $userid = mysql_insert_id();
			echo "Register Completed!<br>Please check your email to activate account";
		$subject = "Activate สมาชิก Foodland @ Silpakorn";
		$Header = "Content-type: text/html; charset=UTF-8\n"; 
		$Header .= "From: admin@foodslandatsu.com\nReply-To: admin@foodslandatsu.com";
		$Message = "";
		$Message .= "สวัสดีคุณ : ".$name."<br>";
		$Message .= "------------------------------------------------------------------------------<br>";
		$Message .= "คุณได้สมัครชิกกับทางเรา Foodland @Silpakorn";
		$Message .= "เราอยากรู้ว่าคุณมีตัวตนอยู่จริง คลิ๊กที่นี่เพื่ยืนยัน <br>";
		$Message .= "http://www.foodslandatsu.com/activate_api.php"."?sid=".session_id()."&username=".$username."<br>";
		$Message .= "-------------------------------------------------------------------------------<br>";
		$Message .= "Foodland.com";

		$Send = mail($email,$subject,$Message,$Header);
		$_SESSION["email"] = $email;
		header("Location:register_success.php");
	}
			$conn->close();
}
?>