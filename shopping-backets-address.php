<?php
session_start();
include "config.php";
include "login_check.php";
$_SESSION["current_url"] = urldecode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Food Land @Silpakorn</title>
	 <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/backets-address-1.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<style>
	input:focus{
		outline: 0;
	}
	</style>
</head>
<body>
	<header class="header">
		<div id="box-header">
		<div id="menu-header">
		<ul>
			<a href="index.php"><li class="logo"></li></a>
			<a href="index.php"><li class="home">
			<h3>HOME</h3>
			<h4>หน้าแรก</h4>
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
			<li class="sign">

				<h4 style="font-family: 'dk_dirrrtyregular'; color:#ee4848;  font-weight:bold;"><i class="fa fa-shopping-basket" style="font-size:20px; color:#ee4848;"></i> <?php echo $_SESSION["number_cart"];?></h4>
			</li>
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
			<ul id="step-shop">
				<li class="step-setting">
					<div class="step-1">1</div>
					<h3>ตรวจสอบตะกร้าสินค้า</h3>
				</li>
				<li class="step-setting">
				<div  class="step-1  actives">2</div>
					<h3>จุดส่งอาหาร</h3></li>
				<li class="step-setting" style="margin-right:0;">
				<div  class="step-1">3</div>
					<h3>ยืนยันการสั่งซื้อ</h3></li>
			</ul>
			<div id="h1-shoppingbackets">
				<ul>
					<li class="left-size"><i class="fa fa-map-marker"></i> <h1>SHOPPING POINT</h1><br>
					<h2>รายการอาหารในตะกร้าสินค้า</h2></li>
					<li class="bt-size">คุณมีรายการอาหาร <?php echo $_SESSION["number_cart"];?> รายการในตะกร้าสินค้า</li>
				</ul>
			</div>
			<span><?php
					if ($_SESSION["no-ad"] == 'no') {
						echo "<script type='text/javascript'>window.setTimeout(function() {
    							$('.alert').fadeTo(500, 0).slideUp(500, function(){
        						$(this).remove(); 
    							});
								}, 4000);
							</script>";
						echo '<div class="alert" style="background-color: rgba(238, 72, 72,0.9);
    													color: #fff;
    													font-family: FontAwesome,supermarketregular;
    													width: 757px;
    													height: 57px;
    													margin: 0 auto;
    													border-radius: 10px;
    													z-index: 999999;
    													position: relative;
    													top: 223px;
    													line-height: 50px;
    													box-sizing: border-box;
    													text-align: center;">
    							<div style="position:absolute;left: 162px;">
  							   <button type="button" data-dismiss="alert" style="border-width:0; background-color:rgba(0,0,0,0); font-family:FontAwesome,"supermarketregular";"><i class="fa fa-close" style="color:rgba(255,255,255,0.7);"></i></button>
  								<strong>เรายังไม่มีที่อยู่ของคุณเลย !</strong> กรุณากรอกข้อมูลที่อยู่ให้ครบถ้วน หรือเลือก ใช้ที่อยู่นี้ (ถ้ามี)
								</div></div>';
							$_SESSION["no-ad"] = 'yes';
					}else{
						echo "";
					}
				?></span>
	</div>
	<div id="register">
		<div class="register-box">
			<div class="inbox">	
				<form method="POST" action="shopping-backets-submit.php">
				<div class="user-container">
					<div class="h1conn-left">
					<h1>ประเภทบุคคล : </h1><h1 style="color:#9595aa;">&nbsp <?= $fgmembersite->Usertype(); ?></h1></div>
					<div class="h1conn-right">
					<h1>สถานที่ที่ระบุล่าสุด</h1></div>
					<div class="conn-left">
					<input type="text" placeholder="บ้านเลขที่/ชื่ออาคาร" class="input-conn" name="num_add"> <i class="fa fa-asterisk" style="font-size:7px; color:#ee4848;"></i>
					<input type="text" placeholder="เลขห้อง" class="input-conn" name="room_add"> <i class="fa fa-asterisk" style="font-size:7px; color:#ee4848;"></i>
					<input type="text" placeholder="สถานที่ใกล้เคียง" class="input-conn" name="near_add"> <i class="fa fa-asterisk" style="font-size:7px; color:#ee4848;"></i>
					<h3>กรณีที่อยู่ไม่สามารถระบุและอาจทำให้สับสน</h3>
					<input type="text" placeholder="รายละเอียดอื่นๆ" class="input-conn" style="margin-top: 5px;" name="more_add">
					</div>
					<div class="conn-right">
						<?php				
						if ($fgmembersite->Useraddress() == '') {?>

							<div style="font-size: 15px;font-family: 'supermarketregular';font-weight: inherit;color: #959595;">คุณยังไม่มีที่อยู่ในส่วนนี้</div>	
						<?php
						}else{?>
						<div style="font-size: 15px;font-family: 'supermarketregular';font-weight: inherit;color: #959595;"><?= $fgmembersite->Useraddress(); ?></div>
						<div style="margin-top: 60px;position: absolute;bottom: 22px;">
						<input type="checkbox" checked="checked" class="checkbox" value="<?= $fgmembersite->Useraddress(); ?>" name="check_add"> <h4>ใช้ที่อยู่นี้</h4></div>

						<?php
						}
						?>						
					</div>
				</div>
				<div class="bt-submit">
				<a href="shopping-backets.php"><input type="button" value="ตรวจสอบตะกร้าสินค้า" class="submit-td"></a>
				<input type="submit" value="ยกเลิก" class="submit-td cancle-sub">
				<input type="submit" value="ยืนยัน" class="submit-td cancle-sub submit-sub" name="submit">
				</div>
				</form>
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