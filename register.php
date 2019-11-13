<?php
session_start();
include "config.php";
include "login_check.php";
$_SESSION["current_url"] = urldecode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
if(isset($_POST['submitted']))
{
   if($fgmembersite->Login())
   {
        $fgmembersite->RedirectToURL("register.php");
   }
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
							echo '<td colspan="5"><button type="submit" class="bt-update">ลบ</button></td><td><a href="shopping-backets.php"><input type="button" class="bt-update" value="สั่งซื้อ"></a></td>';
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
			<script type='text/javascript' src='js/gen_validatorv31.js'></script>
			<?php
					if(!$fgmembersite->CheckLogin())
						{ ?>
			<a href="register.php"><li class="sign">
				<h4 style="font-family: 'dk_dirrrtyregular'; color:#ee4848;  font-weight:normal;"><i class="fa fa-user-plus" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN UP</h4>
			</li></a>
			<li class="sign endsign" onclick="ff()">
				<h4><i class="fa fa-user" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN IN</h4></li>
				<div class="arrow-dropdown dropdown-menu arroww"><i class="fa fa-caret-up"></i></div>
				<ul class="dropdown-menu dropdown-box dropdownn">
				<form id='login' action='login.php' method='post'>
					<table class="signin-tb">
						<tr>
						<td><h3 class="login">เข้าสู่ระบบ</h3></td>
						</tr>
						<tr>
							<td><input type='hidden' name='submitted' id='submitted' value='1'/></td>
						</tr>
						<tr><td  style="padding-left: 24px;"><span id='login_username_errorloc' class='error' style="color:#fff; font-size:14px;"></span> <span id='login_password_errorloc' class='error' style="color:#fff; font-size:14px;"></span></td></tr>
						<tr>
							<td><div style="text-align: center;"><input type="text" name="username" id="username" placeholder="&#xf007; &nbsp Username" style="font-family:FontAwesome,'supermarketregular'; " class="ip-signin" maxlength="50" value="<?php echo $fgmembersite->SafeDisplay('username') ?>"></div></td>
						</tr>
						<tr>
							<td><div style="text-align: center;"><input type="password" name="password" id="password" placeholder="&#xf023; &nbsp Password" style="font-family:FontAwesome,'supermarketregular'; " class="ip-signin" maxlength="50"></div></td>
						</tr>
						<tr>
							<td><div style="text-align: center;"><input type="submit" name="submit" value="Sign in" class="ip-signinbtsi"></div></td>	
						</tr>
						<tr>
							<td><div style="text-align: center;"><a href="nore-pass.php" class="nore-pass">ลืมรหัสผ่าน</a></div></td>
						</tr>
					</table>

				</form>
				<div class="end-ddbox dropdown-menu"></div>
				</ul>
				<script type="text/javascript">
					var frmvalidator  = new Validator("login");
    				frmvalidator.EnableOnPageErrorDisplay();
   				 	frmvalidator.EnableMsgsTogether();

   					 frmvalidator.addValidation("username","req","กรุณากรอก Username");
    
    				frmvalidator.addValidation("password","req","กรุณากรอก Password");
				</script>
				<?php
		}else{
			?>
			<a href="register.php"><li class="sign">
				<h4 style="font-family: 'dk_dirrrtyregular'; color:#ee4848;  font-weight:normal;"><i class="fa fa-user-plus" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN UP</h4>
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
		<?php
		}	?>
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
		<span><?php
			if (isset($_SESSION["check"])) {
				# code...
			
					if ($_SESSION["check"] == 0) {
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
    													top: 77px;
    													line-height: 50px;
    													box-sizing: border-box;
    													text-align: center;">
  							   <button type="button" data-dismiss="alert" style="border-width:0; background-color:rgba(0,0,0,0); font-family:FontAwesome,"supermarketregular";"><i class="fa fa-close" style="color:rgba(255,255,255,0.7);"></i></button>
  								<strong>แย่แล้ว !</strong> ดูเหมือนว่า Username ของคุณจะมีผู้ใช้งานแล้ว
								</div>';
							$_SESSION["check"] = 2;
					}else{
						echo "";
					}
					}else{
						echo "";
					}
				?></span>
	</div>
	<div id="register" >
		<div class="register-box">
			<div class="inbox">
			<h1>REGISTER</h1>
			<a href="index.php"><button id="cancle"><h1><i class="fa fa-close"></i></h1></button></a>
			<div id="registerfield-box">
			<form id="registerform" action="update_api.php" method="POST">
				<h2>ข้อมูลส่วนตัว</h2>
				<div class="field-text">
					<input type="text" class="input-c" placeholder="ชื่อ - นามกุล" name="name"> <i class="fa fa-asterisk" style="font-size:7px; color:#ee4848;"></i> <span id='registerform_name_errorloc' class='error' style="font-size:11px; color:#ee4848"></span><br>
					
					<input type="text" class="input-c" placeholder="หมายเลขโทรศัพท์" name="tel"> <i class="fa fa-asterisk" style="font-size:7px;color:#ee4848;"></i> <span id='registerform_tel_errorloc' class='error'></span><br>
					
					<input type="text" class="input-c" placeholder="E-mail" name="email"> <i class="fa fa-asterisk" style="font-size:7px;color:#ee4848;"></i> <span id='registerform_email_errorloc' class='error'></span><br>
					

				</div>
				<h2>บัญชีผู้ใช้</h2>
				<div class="field-text">
					<input type="text" class="input-c" placeholder="Username" name="username"> <i class="fa fa-asterisk" style="font-size:7px;color:#ee4848;"> </i> <span id='registerform_username_errorloc' class='error'></span><br>
					
					<input type="password" class="input-c" placeholder="Password" name="password" id="repassword"> <i class="fa fa-asterisk" style="font-size:7px;color:#ee4848;"> </i> <span id='registerform_password_errorloc' class='error' style='clear:both'></span><br>
					
					<input type="password" class="input-c" placeholder="Confirm Password" name="passwordconfirm" id="passwordconfirm"> <i class="fa fa-asterisk" style="font-size:7px;color:#ee4848;"></i> <span id='registerform_passwordconfirm_errorloc' class='error' style='clear:both'></span><br>
					
				</div>
				<div class="registerfieldbox-right">
					<h2>ประเภทบุคคล</h2>
				<div class="alignradio">
      			<input type="radio" value="บุคคลทั่วไป" id="radio1" name="f_type" checked><label for="radio1" checked><h3 class="checklisting"> 
      			บุคคลทั่วไป</h3></label>
      			</div><br>
      			<div class="alignradio">
      			 <input type="radio" id="radio2" name="f_type" value="บุคลากร"><label for="radio2"><h3 class="checklisting"> 
      			บุคลากร</h3></label></div><br>
      			<div class="alignradio">
      			 <input type="radio" id="radio3" name="f_type" value="นักศึกษา"><label for="radio3"><h3 class="checklisting">
      			นักศึกษา</h3></label>
      			</div>
      			<br>

				</div>

				<input type="submit" class="accept" value="ยืนยัน" style="top: 269px;" id="accept">
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
	<script type="text/javascript" src="js/dropdown.js"></script>
	<script type='text/javascript'>
// <![CDATA[
    
    var frmvalidator  = new Validator("registerform");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("name","req","กรุณากรอกชื่อ นามกุล");

    frmvalidator.addValidation("tel","req","กรณากรอกหมายเลขโทรศัพท์");
    frmvalidator.addValidation("tel","num","ต้องเป็นตัวเลขเท่านั้น (ไม่ต้องมี - )");
    frmvalidator.addValidation("tel","maxlen=10","เบอร์โทรศัพท์ต้องมี 9-10 ตัว");
    frmvalidator.addValidation("tel","minlen=9","เบอร์โทรศัพท์ต้องมี 9-10 ตัว");

    frmvalidator.addValidation("email","req","กรณากรอก E-mail");

    frmvalidator.addValidation("email","email","รูปแบบ E-mail ของคุณไม่ถูกต้อง");

    frmvalidator.addValidation("username","req","กรุณากรอก Username");
	
	frmvalidator.addValidation("username","alnum","a-z,A-z,0-9 เท่านั้น ห้ามเว้นวรรค");    
	frmvalidator.addValidation("username","maxlen=20","username ต้องไม่เกิน 20 ตัว");
    frmvalidator.addValidation("password","req","กรุณากรอก Password");
    frmvalidator.addValidation("password","alnum","a-z,A-z,0-9 เท่านั้น ห้ามเว้นวรรค");
    frmvalidator.addValidation("password","maxlen=13","Password ต้องไม่เกิน 13 ตัว");
    frmvalidator.addValidation("passwordconfirm","eqelmnt=password","Password ไม่เหมือนกัน");
    
    // frmvalidator.addValidation("password","eqelmnt=passwordconfirm", "The confirmed password is not same as password"); 
    // frmvalidator.addValidation("confpassword","eqelmnt=password","The confirmed password is not same as password");

// ]]>

// 	$('#accept').click(function () {
// 	if ($('#passwordconfirm').val() == ""){
// 		$('#message').html('กรอก Password ซ้ำอีกครั้ง').css('color', '#ee4848');
// 		event.preventDefault();
//     }
// 	else if ($('#passwordconfirm').val() != $('#repassword').val()) {
//     	$('#message').html('Password ไม่เหมือนกัน').css('color', '#ee4848');
//     	event.preventDefault();
//     }else{
//     	$('#message').html('Password เหมือนกันแล้ว').css('color', '#a7dc0b');
//     }
// });
</script>

</body>
</html>