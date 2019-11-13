<?php
	session_start();
	include "config.php";
	$addoption = $_POST["address"];
 	$username = $_POST["usernamepost"];
 	
	if ($conn->connect_error)
	{
	    die("Connection failed: " . $conn->connect_error);
	    exit();
	}
	else
	{
		if(isset($_POST["submit"])){
			$number = 0;
		foreach ($_SESSION["cart_products"] as $cart_itm){
			$product_qty = $cart_itm["product_qty"];
			$product_price = $cart_itm["f_price"];
			$product_code = $cart_itm["product_code"];
			$subtotal = ($product_price * $product_qty);
			$number++;

			$sql = "INSERT INTO order_product(username,product_code, product_qty, totalprice, address, more, sid,activate) VALUES 
			('".$username."','".$product_code."','".$product_qty."','".$subtotal."','".$addoption."','".$_SESSION["detail".$number.""]."','".session_id()."','no')";

			if ($conn->query($sql) == TRUE) {
		    $last_id = $conn->insert_id;
		    // header("Location:shopping-backets-success.php");
		    echo "success".$last_id;
		    
		} else {
			echo "<br><br>";
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
		$sqlupdate = "UPDATE member SET address = '".$addoption."' WHERE username = '".$username."' ";
		if ($conn->query($sqlupdate) == TRUE) {
		    $last_id = $conn->insert_id;
		    echo "success".$last_id;
		    
		} else {
			echo "<br><br>";
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$sqlemail = "SELECT email FROM member WHERE username = '".$username."' ";
		$result = $conn->query($sqlemail);
		if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
        	$email = $row["email"];
        }
        }

		// $userid = mysql_insert_id();
			echo "Register Completed!<br>Please check your email to activate account";
		$subject = "Activate สมาชิก Foodland @ Silpakorn";
		$Header = "Content-type: text/html; charset=UTF-8\n"; 
		$Header .= "From: admin@foodslandatsu.com\nReply-To: admin@foodslandatsu.com";
		$Message = "";
		$Message .= "สวัสดีคุณ : ".$username."<br>";
		$Message .= "------------------------------------------------------------------------------<br>";
		$Message .= "คุณได้สั่งสินค้ากับทางเรา Foodland @Silpakorn";
		$Message .= "คุณได้สั่งอาหารไปทั้งหมด".count($_SESSION["cart_products"])."<br>";
		$Message .= "โปรดคลิ้กที่ลิ้งนี้เพื่อยืนยันการสั่งของคุณ";
		$Message .= "http://www.foodslandatsu.com/activateorder_api.php"."?sid=".session_id()."&username=".$username."<br>";
		$Message .= "-------------------------------------------------------------------------------<br>";
		$Message .= "Foodland.com";

		$Send = mail($email,$subject,$Message,$Header);
		$_SESSION["emailorder"] = $email;
		echo $_SESSION["emailorder"];
		header("Location:shopping-backets-success.php");
		
}else {
	unset($_SESSION["cart_products"]);
	header("Location:login_success.php");
}
$conn->close();
}

?>