<?php
session_start();
include "config.php";
include "login_check.php";
$_SESSION["current_url"] = urldecode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
if (!isset($_SESSION["emailorder"])) {
	header("Location:login_success.php");
}
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Food Land @Silpakorn</title>
	 <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/register-2.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
</head>
<body>
<header class="header">
		<div id="box-header">
		<div id="menu-header">
		<ul>
			<a href="index.php"><li class="logo"></li></a>
			<a href="index.php"><li class="home">
			<h3>HOME</h3>
			<h4 style="margin-top:0px;">หน้าแรก</h4>
			</li></a>
			<a href="promotion.php"><li class="home"> 
			<h3>PROMOTION</h3>
			<h4>โปรโมชั่น</h4>
			</li></a>
			<a href="about.php"><li class="home">
				<h3>About us</h3>
			<h4>เกี่ยวกับเรา</h4>
			</li></a>
			</ul>
			</div>
		<div id="menu-sign">
			<ul class="dd-menu">
			<!-- <form action="cart_update.php" method="POST"> -->
			<a class="btn-dropdown" onclick="f()"><li class="sign">
				<h4 style="font-family: 'dk_dirrrtyregular'; color:#ee4848;  font-weight:bold;"><i class="fa fa-shopping-basket" style="font-size:20px; color:#ee4848;"></i> <?php 
				if(!isset($_SESSION["cart_products"])){
					echo "0";

				}else{
					echo count($_SESSION["cart_products"]);
					}?></h4>
			</li></a>
				
				<!-- </form> -->
			</ul>
			<a href="register.php"><li class="sign">
				<h4><i class="fa fa-user-plus" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN UP</h4>
			</li></a>
			<li class="sign endsign logedin" onclick="ff()">
				<div class="arrow-dropdown dropdown-menu arroww"  style="margin-left:0;"><i class="fa fa-caret-up"></i></div>
				<h4><i class="fa fa-user" style="font-size:20px; margin-right: 4px;"></i> <?= $fgmembersite->UserFullName(); ?></h4></li>
				<ul class="dropdown-menu dropdown-box dropdownn">
					<table class="signin-tb">
						<tr>
							<td><div style="text-align: center;"><form action="logout.php" method="POST"><input type="submit" class="nore-pass" value="ออกจากระบบ" style="cursor:pointer;border-width:0; background-color:rgba(0,0,0,0);"></form> </div></td>
						</tr>
					</table>
				<div class="end-ddbox dropdown-menu"></div>
				</ul>
		</div>
		</div>
		<div class="triangle"></div>
		<div class="triangle-shadow"></div>
	</header>
	<div id="banner">
		<div id="text-banner">
			<ul>
			<li class="bold-banner">ORDER FOODS ONLINE & DERIVERY<br> 
			IN CAMPUS AND NEARBY AREA</li>
			<li class="light-banner">ให้คุณสั่งอาหารออนไลน์<br>พร้อมบริการจัดส่งอาหารถึงมือ<br>ภายในมหาลัยศิลปากร<br>และพื้นที่ใกล้เคียง</li>
			</ul>
			<div class="logo-banner"></div>
		</div>
	</div>
	<div id="register" style="height: 412px;">
		<div class="register-box" style="height: 368px;">
			<div class="inbox" style="height: 100%;">
			<h1>ORDER SUCCESS</h1>
				<table style="border-spacing: 0 40px; position: absolute;">
					<tr class="all-td" style="position: absolute;left: 96px;">
						<td style="padding: 26px 257px;text-align: center;font-family: 'supermarketregular';background-color: #fff;"><h3 style="font-size:18px; color:#888888;">รับ Order เรียบร้อยแล้ว</h3>
						<h5 style="font-size:14px; color:#888888;width: 300px;">แต่ขั้นตอนยังไม่เสร็จสมบูรณ์ คุณสามารถยืนยันการสั่งซื้อได้ที่ 
						<?php
							$a = $_SESSION["emailorder"];

						if (strpos($a, 'gmail') !== false) {
    							echo "<a href='https://accounts.google.com/'>";
						}else if(strpos($a, 'hotmail') !== false) {
							echo "<a href='https://login.live.com/'>";
							
						}else if(strpos($a, 'outlook') !== false) {
							echo "<a href='https://login.live.com/'>";
							
						}else{
							echo "<a href='https://www.google.co.th/'>";
						}
						?>
						<?php echo $_SESSION["emailorder"]; ?> </a>ค่ะ</h5>
						<?php unset($_SESSION["emailorder"]); 
						$number = 0;
						foreach ($_SESSION["cart_products"] as $cart_itm){
								$number++;
								unset($_SESSION["detail".$number.""]);	
							}
							unset($_SESSION["cart_products"]);

						?>
						</td>
					</tr>
					</table>
			</div>
		</div>
	</div>
	<div class="triangle-shadow endline-body"></div>
	<footer>
		<div id="footer-align">
			<div class="align-footerdetail">
				<h1>หมวดหมู่สินค้า</h1>
				<ul>
					<a href="#"><li class="f-detail">ต้มและแกง</li></a>
					<a href="#"><li class="f-detail">ผัดและทอด</li></a>
					<a href="#"><li class="f-detail">นึ่ง อบและย่าง</li></a>
					<a href="#"><li class="f-detail">เส้น ก๋วยเตี๋ยว</li></a>
					<a href="#"><li class="f-detail">ขนมและเครื่องดื่ม</li></a>
				</ul>
			</div>
			<div class="align-footerdetail">
				<h1>บัญชีของฉัน</h1>
				<ul>
					<a href="#"><li class="f-detail">เข้าสู่ระบบ</li></a>
					<a href="#"><li class="f-detail">ลงทะเบียน</li></a>
					<a href="#"><li class="f-detail">แก้ไขข้อมูลส่วนตัว</li></a>
					<a href="#"><li class="f-detail">ลืมรหัสผ่าน</li></a>
				</ul>
			</div>
			<div class="align-footerdetail">
				<h1>ติดต่อเรา</h1>
				<ul>
					<a href="#"><li class="f-detail">E-mail</li></a>
					<a href="#"><li class="f-detail">Facebook</li></a>
					<a href="#"><li class="f-detail">หมายเลขโทรศัพท์</li></a>
				</ul>
			</div>
			<div id = "logofooter">
				<h3>www.foodlanddalivery.com</h3>
			</div>
				<h4><i class="fa fa-copyright"></i> 2016 Food Land @ Silpakorn</h4>
		</div>
	</footer>
	<script type="text/javascript" src="js/dropdown.js"></script>
</body>
</html>