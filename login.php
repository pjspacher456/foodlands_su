<?php
session_start();
include "config.php";
include "login_check.php";
$_SESSION["current_url"] = urldecode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("login_success.php");
   }
}
if($fgmembersite->CheckLogin()){
	header("Location:login_success.php");
}
?>
<!DOCTYPE html>

<html>
<head>
	<meta charset="UTF-8">
	<title>Food Land @Silpakorn</title>
	 <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/login.css">
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
			<a href="#"><li class="home">
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
				<h4><i class="fa fa-shopping-basket" style="font-size:20px; color:#ee4848;"></i> <?php 
				if(!isset($_SESSION["cart_products"])){
					echo "0";

				}else{
					echo count($_SESSION["cart_products"]);
					}?></h4>
			</li></a>
				<div class="arrow-dropdown dropdown-menu arrow"><i class="fa fa-caret-up"></i></div>
				<ul class="dropdown-menu dropdown-box dropdown">
				<?php
					    if(!isset($_SESSION["cart_products"]) || count($_SESSION["cart_products"])==0){
							echo '<div class="cart-view-table-front" id="view-cart" style="padding:20px; text-align:center; box-sizing:border-box;">';
							echo '<h3>ไม่มีสินค้าของคุณ</h3>';

							echo '</div>';	
						}
						else if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0)
						{
							echo '<div class="cart-view-table-front" id="view-cart">';
							echo '<h3>สินค้าของคุณ</h3>';
							echo '<form method="post" action="cart_update.php">';
							echo '<table width="100%"  cellpadding="6" cellspacing="0">';
							echo '<tbody>';
							echo '<tr><td style="text-align: center;">จำนวน</td><td style="min-width: 87px;">รายการ</td><td style="min-width: 60px;  text-align:center;">ราคา</td><td style="min-width: 60px;  text-align:center;">แคลลอรี่</td><td style="min-width: 60px;" >ร้านอาหาร</td><td style="text-align: center;">ลบรายการ</td></tr>';

							$total =0;
							$total_cal =0;
							foreach ($_SESSION["cart_products"] as $cart_itm)
							{
								$product_name = $cart_itm["f_name"];
								$product_qty = $cart_itm["product_qty"];
								$product_price = $cart_itm["f_price"];
								$product_code = $cart_itm["product_code"];
								$product_cal = $cart_itm["f_cal"];
								$product_res = $cart_itm["res_name"];
								echo '<td style="text-align: center;">'.$product_qty.'</td>';
								echo '<td>'.$product_name.'</td>';
								echo '<td style="text-align: center;">'.$product_price.' บาท</td>';
								echo '<td style="text-align: center;">'.$product_cal.' kcal</td>';
								echo '<td>@ '.$product_res.'</td>';
								echo '<td><div style="text-align: center;"><input type="checkbox" name="remove_code[]" value="'.$product_code.'" /></div></td>';
								echo '</tr>';
								$subtotal = ($product_price * $product_qty);
								$total = ($total + $subtotal);
								$subtotal_cal = ($product_cal * $product_qty);
								$total_cal = ($total_cal + $subtotal_cal);
							}
							echo "<tr><td colspan='6' style='border-bottom: 1px solid #fff;'></td></tr>";
							echo '<tr>';
							echo "<td colspan='2' style='text-align:center;'>Total</td>";
							echo '<td style="text-align: center;">'.$total.' บาท</td>';
							echo '<td style="text-align: center;">'.$total_cal.' kcal</td>';
							echo "</tr>";
							echo "<tr>";
							echo '<td colspan="5"><button type="submit" class="bt-update">ลบ</button></td><td><input type="button" onclick="redirect()" class="bt-update" value="สั่งซื้อ"></td>';
							echo "</tr>";
							echo '</tbody>';
							echo '</table>';
							
							$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
							echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
							echo '</form>';
							echo '</div>';

						}
						?>
						<div class="end-ddbox dropdown-menu"></div>
					</ul>
				<!-- </form> -->
			</ul>

			<a href="register.php"><li class="sign">
				<h4><i class="fa fa-user-plus" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN UP</h4>
			</li></a>
			<li class="sign endsign">
				<h4 style="font-family: 'dk_dirrrtyregular'; color:#ee4848;  font-weight:normal;"><i class="fa fa-user" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN IN</h4></li>
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
	<div id="register" >
		<div class="register-box">
			<div class="inbox">
			<h1>Login</h1>
			<a href="index.php"><button id="cancle"><h1><i class="fa fa-close"></i></h1></button></a>
			<div id="registerfield-box">
				<form id='login' action='?php echo $fgmembersite->GetSelfScript(); ?>' method='post'>
					<div id="loginwithpage">
						<span class='error' style="font-weight:bold;"><?php echo $fgmembersite->GetErrorMessage(); ?></span>
						<input type='hidden' name='submitted' id='submitted' value='1'/>
						<input type="text" name="username" id="username" placeholder="&#xf007; &nbsp Username" style="font-family:FontAwesome,'supermarketregular'; ">
						<span id='login_username_errorloc' class='error'></span>
						<input type="password" name="password" id="password" placeholder="&#xf023; &nbsp Password" style="font-family:FontAwesome,'supermarketregular'; ">
						<span id='login_password_errorloc' class='error'></span>
						<input type="submit" name="submit" value="Sign in" class="ip-signinbtsi">
						<div id="end-liner"><a href="#">ลืมรหัสผ่าน</a> | <a href="register.php">สมัครสมาชิก</a></div>
					</div>
				</form>
				<div id="slideshow"></div>
			</div>
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
	<script type="text/javascript" src="js/gen_validatorv31.js"></script>
	<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","กรุณากรอก Username");
    
    frmvalidator.addValidation("password","req","กรุณากรอก Password");

</script>
	
</body>
</html>