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
if (!isset($_POST["submit"])) {
	header("Location:login_success.php");
	unset($_SESSION["cart_products"]);
}
if(isset($_POST["submit"])){
	if (empty($_POST['check_add'])) {
		
					header("Location:shopping-backets-address.php");
							$_SESSION["no-ad"] = 'no';
	}
	if ($_POST['num_add']='') {
		
					header("Location:shopping-backets-address.php");
							$_SESSION["no-ad"] = 'no';
	}
	if ($_POST['room_add']='') {
		
					header("Location:shopping-backets-address.php");
							$_SESSION["no-ad"] = 'no';
	}
	if ($_POST['near_add']='') {
		
					header("Location:shopping-backets-address.php");
							$_SESSION["no-ad"] = 'no';
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Food Land @Silpakorn</title>
	 <link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="css/backets-submit-1.css">
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
				<div  class="step-1">2</div>
					<h3>จุดส่งอาหาร</h3></li>
				<li class="step-setting" style="margin-right:0;">
				<div  class="step-1 actives">3</div>
					<h3>ยืนยันการสั่งซื้อ</h3></li>
			</ul>
			<div id="h1-shoppingbackets">
				<ul>
					<li class="left-size"><i class="fa fa-archive"></i> <h1>ORDER CONFIRMATION</h1><br>
					<h2>ยืนยันการสั่งซื้อสินค้า</h2></li>
					<li class="bt-size">คุณมีรายการอาหาร <?php echo $_SESSION["number_cart"];?> รายการในตะกร้าสินค้า</li>
				</ul>
			</div>
	</div>
	<?php
		$space = (136*$_SESSION['number_cart'])+214;
		$space_bg = (136*$_SESSION['number_cart'])+740;
	?>
	<form action="order_api.php" method="POST">
	<div id="register" style="height:<?php echo $space_bg;?>px;">
		<div class="register-box" style="height:<?php echo $space;?>px;">
			<div class="inbox">
			<h1 class="td-head"><i class="fa fa-shopping-basket"></i>รายการอาหารในตะกร้าสินค้า</h1>
			<?php
			if(isset($_SESSION["cart_products"]) && count($_SESSION["cart_products"])>0){
					$total =0;
					$total_cal =0;
					$total_qty =0;
					$number = 0;

				?>
					<table style="border-spacing: 0 24px; position: absolute;">
						<tr class="tableinbox">
							<th>ลำดับที่</th>
							<th class="th-1"></th>
							<th class="th-2">รายการอาหาร</th>
							<th>แคลลอรี่</th>
							<th>ราคา</th>
							<th>จำนวน</th>
							<th>แคลลอรี่รวม</th>
							<th>ราคารวม</th>
							<th></th>
						</tr>
				<?php
					foreach ($_SESSION["cart_products"] as $cart_itm){
						$product_name = $cart_itm["f_name"];
						$product_qty = $cart_itm["product_qty"];
						$product_price = $cart_itm["f_price"];
						$product_code = $cart_itm["product_code"];
						$product_cal = $cart_itm["f_cal"];
						$product_res = $cart_itm["res_name"];
						$product_pic = $cart_itm["f_pic"];
						$number = ($number+1);

						$total_qty = ($total_qty + $product_qty);
						$subtotal = ($product_price * $product_qty);
						$total = ($total + $subtotal);
						$subtotal_cal = ($product_cal * $product_qty);
						$total_cal = ($total_cal + $subtotal_cal);
						?>
					<tr class="all-td">
						<th class="num-first" style="background-color:#fad062;">0<?php echo $number;?></th>
						<th class="img-td img-col-1" style="background-image:url(<?php echo $product_pic;?>);background-size: cover;"></th>
						<th class="menu-td"><h1><?php echo $product_name;?></h1>
							<h3><?php echo $product_res;?></h3>
						</th>
						<th class="detail-td" style="color:#898989;"><?php echo $product_cal;?><br>kcal</th>
						<th class="detail-td" style="color:#898989;"><?php echo $product_price;?><br>บาท</th>
						<th class="detail-td"><?php echo $product_qty;?></th>
						<th class="detail-td"><?php echo $subtotal_cal;?><br>kcal</th>
						<th class="detail-td"><?php echo $subtotal;?><br>บาท</th>
						<th class="send-detail-td">
							<h3>รายละเอียดเพิ่มเติม</h3>
						<input type="text" class="detail-std" placeholder="รายละเอียด" maxlength="255" name="product_detail" value="<?php echo $_SESSION["detail".$number.""]; ?>">
						</th>
					</tr>
					<?php
					} ?>


				<tr class="all-td td-yellow">
					<th></th>
					<th></th>
					<th class="menu-td total-td"><h1>รวม</h1></th>
					<th></th>
					<th></th>
					<th class="total-alltd"><?php echo $total_qty; ?></th>
					<th class="total-alltd"><?php echo $total_cal; ?> kcal</th>
					<th class="total-alltd"><?php echo $total; ?> บาท</th>
					</th>
				</tr>
				</table>
					<?php
				}

				?>
				<?php
					$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
				?>
				</table>
				<!-- -------------------------------------------------------------------------------------- -->
				<!-- <div class="bt-submit">
				<a href="index.html"><input type="submit" value="เลือกสินค้าเพิ่มเติม" class="submit-td"></a>
				<a href="index.html"><input type="submit" value="ยกเลิก" class="submit-td cancle-sub"></a>
				<a href="shopping-backets-address.html"><input type="submit" value="ยืนยัน" class="submit-td cancle-sub submit-sub"></a>
				</div> -->
				<!-- ----------------------------------------------------------------------------------------------- -->
			</div>
		</div>
		<div class="register-box-2">
			<div class="inbox-2">
			<h1 class="td-head"><i class="fa fa-map-marker"></i>สถานที่จัดส่งสินค้า</h1>	
				<div class="user-container">
					<div class="h1conn-left">
					<h1>สถานที่จัดส่งสินค้า</h1></div>
					<div class="conn-left">
						<?php
						if(isset($_POST["submit"])){

								if(!empty($_POST['check_add'])) {
						?>
						<h2><?php echo $_POST["check_add"];?></h2>
						<input type="hidden" value="<?php echo $_POST["check_add"];?>" name="address">
						<input type="hidden" value="<?= $fgmembersite->UserFullName(); ?>" name="usernamepost">
						
						<?php
							}else{
						?>
								<h2><?php echo $_POST["num_add"]."<br>เลขห้อง : ". $_POST["room_add"] ."<br>สถาที่ใกล้เคียง : ".$_POST["near_add"] ."<br>". $_POST["more_add"];?></h2>
								<input type="hidden" value="<?php echo $_POST["num_add"]." "." ".$_POST["room_add"]." "." ".$_POST["near_add"]." "." ".$_POST["more_add"];?>" name="address">
								<input type="hidden" value="<?= $fgmembersite->UserFullName(); ?>" name="usernamepost">
						<?php
							}
						}
						?>
					</div>
					<div class="conn-right">
						<h2>หลังจากการยืนยัน ลูกค้าสามารถตรวจสอบการสั่งอาหารได้ที่ประวัติการสั่งอาหาร </h2><p>
						<h2>ลูกค้าต้องชำระเงินที่พนักงานเมื่อพนักงานนำอาหารไปส่ง</h2><p>
						<h2>หลังได้รับสินค้ากรุณากดปุ่มได้รับสินค้าแล้ว เพื่อง่ายต่อการตรวจสอบ และป้องกันไม่ให้เกิดปัญหาในภายหลัง</h2>
					</div>
				</div>
				<div class="bt-submit">
				<a href="shopping-backets-address.php"><input type="button" value="ก่อนหน้า" class="submit-td"></a>
				<input type="submit" value="ยกเลิก" class="submit-td cancle-sub" name="cancle">
				<input type="submit" value="ยืนยัน" class="submit-td cancle-sub submit-sub" name="submit">
				</div>
			</div>
		</div>
		</form>
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