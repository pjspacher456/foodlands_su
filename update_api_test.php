<?php
require_once('class.phpmailer.php');
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

			echo "Username already exists!";
			header("Location:register.php");

		}else{
			$sql = "INSERT INTO member(name, username, password, email, tel, type, sid, confirm) VALUES ('".$name."','".$username."','".$password."','".$tel."','".$type."','".session_id()."','no')";
			$resultquery = $conn->query($sql);

			$userid = mysql_insert_id();
$mail = new PHPMailer();
$mail->isHTML(true);
$mail->isSMTP();
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
$mail->Port = 465; // set the SMTP port for the GMAIL server
$mail->Username = "pjspacher456@gmail.com"; // GMAIL username
$mail->Password = "456837461256"; // GMAIL password
$mail->From = "pjspacher456@gmail.com"; // "name@yourdomain.com";
$mail->FromName = "Foodland @silpakorn";  // set from Name
$mail->Subject = "สวัสดีคุณ : ".$name."<br>"; 
$mail->Body = 'ทดสอบการส่งเมล์ครับ body ครับ';
$mail->Body .= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."activate_api.php?sid=".session_id()."&id=".$userid."";
 
$mail->AddAddress('pjspacher4567@gmail.com'); // to Address
 
$mail->set('X-Priority', '3'); //Priority 1 = High, 3 = Normal, 5 = low
if(!$mail->Send()) 
{
    echo 'Mailer Error: ' . $mail->ErrorInfo.'<br />';
} 
else 
{
    echo "Register Completed!<br>Please check your email to activate account";
}
}
$conn->close();
}
?>