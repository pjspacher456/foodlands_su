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
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/stylesheet.css">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style-3.css">
	
	<script type="text/javascript">
		$(document).ready(function(){
			ajax();
			$('.input-filter').on('keypress keyup change',function(event){
				var food_name = $('#food_name').val();
				var select_typefood = $('#select_typefood').val();
				var select_met = $('#select_met').val();
				var select_cal = $('#select_cal').val();
				var type1 = $('#type1').val();
				var type2 = $('#type2').val();

				ajax(food_name,select_typefood,select_met,select_cal,type1,type2);
			});

			function ajax(food_name,select_typefood,select_met,select_cal,type1,type2){
				food_name = (food_name == undefined) ? '':food_name;
				select_typefood = (select_typefood == undefined) ? 'all':select_typefood;
				select_met = (select_met == undefined) ? 'all':select_met;
				select_cal = (select_cal == undefined) ? 'all':select_cal;
				type1 = (type1 == undefined) ? 'all':type1;
				type2 = (type2 == undefined) ? 'all':type2;

				var request = $.ajax({
					url:"filter.php",
					method:"GET",
					data:{food_name:food_name,select_typefood:select_typefood,select_met:select_met,select_cal:select_cal,type1:type1,type2:type2},
				});
				request.done(function(html){
					$('#show-data').html(html);
				});
				request.fail(function(jqXHR,textStatus){
					alert('Failed '+textStatus);
				}); 
			}
		});

	
	</script>
</head>
<body>
	<header class="header">
		<div id="box-header">
		<div id="menu-header">
		<ul>
			<a href="index.php"><li class="logo"></li></a>
			<a href="#"><li class="home activethis">
			<h3 style="    color: #0b0b0b;
    font-family: 'dk_dirrrtyregular';
    font-size: 20px;">HOME</h3>
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
		<div id="menu-sign" style="width: 253px;">
			<ul class="dd-menu">
			<form action="cart_update.php" method="POST">
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
				</form>
			</ul>

			<a href="register.php"><li class="sign">
				<h4><i class="fa fa-user-plus" style="font-size:20px; color:#ee4848; margin-right: 4px;"></i>SIGN UP</h4>
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
						<tr><td  style="padding-left: 24px;"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span><span id='login_username_errorloc' class='error'></span> <span id='login_password_errorloc' class='error'></span></td></tr>
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
		<div id="post-menu">
		<form action="cart_update.php" method="POST">
		 <?php
				 	$sql = "SELECT * FROM food ORDER BY f_id DESC LIMIT 1";
					$result = $conn->query($sql);

					if ($result -> num_rows >0) {
							while ($row = $result->fetch_assoc()) {
			echo '<div class="post-menu-detail" style="background-image:url('.$row["f_pic"].')">';
				echo '<div class="new-circle">New</div>';
				echo '<div class="blackbox-detail">';
				 echo '<div class="bb-grid">';
					
					echo '<h2 style="width: 100%;">'.$row["f_name"].'</h2>';
					echo '<h4>@ '.$row["res_name"].'</h4>';
					echo '<h3>'.$row["f_cal"].' กิโลแคลอรี่</h3>';
					echo '</div>';
					echo '<h1>'.$row["f_price"].'.-</h1>';
					echo '<input type="hidden" name="product_qty" value="1">';
					
					echo '<input type="hidden" name="product_code" value="'.$row["product_code"].'" />';
							}
					}
				 ?>
					<input type="hidden" name="type" value="add" />
					<?php
						$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
							echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
					?>
					<button id="post-menu-shop" type="submit">
							<i class="fa fa-shopping-basket"></i>
					</button>
				</div>
			</div>
			</form>
		</div>
	</div>
	<div id="box-recommend">
		<div class="recommend-logo">
			<h1>RECOMMENDED</h1>
			<h3>รายการแนะนำ</h3>
		</div>
		<div class="recommend-1">
		 <ul>
			<li class="rec">
				<h2>POPULAR</h2>
				<h4>รายการยอดนิยม</h4>
			</li>
			<li class="rec" onclick="click2()">
				<h2>SOUP/CURRY</h2>
				<h4>ต้ม / แกง</h4>
			</li>
			<li class="rec" onclick="click3()">
				<h2>STEAM/GRILL</h2>
				<h4>นึ่ง / อบ / ย่าง</h4>
			</li>
			
			</ul>
		</div>
		<div class="recommend-1">
		<ul class="recommend-2">
		 <div class="re1rec1C">
			<li class="rec fired">
				<h2>FRIED</h2>
				<h4>ผัด / ทอด</h4>
			</li>
			<li class="rec noodle">
				<h2>NOODLE</h2>
				<h4>เส้น / ก๋วยเตี๋ยว</h4>
			</li>
			<li class="rec dontrec">
				<h2>SWEETMEAT/DRINK</h2>
				<h4>ขนมและเครื่องดื่ม</h4>
			</li>
			</div>
			</ul>
		</div>
	</div>
	<!-- ------------------------------------------------------1 -->
	<div class="full-height">
	<div id="search">
		<form><input type="text" class="searchbox input-filter" placeholder="Search" id="food_name"><button class="b-search" disabled><i class="fa fa-search"></i></button>
		<div class="choice">
		<span class="choice-food">
    <select class="input-filter" id="select_typefood">
        <option value="all">ประเภททั้งหมด</option>
        <option value="ต้ม">ต้ม</option>  
        <option value="แกง">แกง</option>
        <option value="นึ่ง">นึ่ง</option>
        <option value="อบ">อบ</option>
        <option value="ย่าง">ย่าง</option>
        <option value="ทอด">ทอด</option>
        <option value="ผัด">ผัด</option>
        <option value="เส้น">เส้นก๋วยเตี๋ยว</option>
        <option value="ขนม">ขนมและเครื่องดื่ม</option>
    </select>
</span>
<span class="choice-food">
    <select class="input-filter" id="select_met">
        <option value="all">วัตถุดิบทั้งหมด</option>
        <option value="หมู">หมู</option>  
        <option value="หมึก">หมึก</option>
        <option value="กุ้ง">กุ้ง</option>
        <option value="ไก่">ไก่</option>
        <option value="ปลา">ปลา</option>
        <option value="เนื้อ">เนื้อ</option>
    </select>
</span>
<span class="choice-food">
    <select class="input-filter" id="select_cal">
        <option value="all">แคลลอรี่ทั้งหมด</option>
        <option value="200"> น้อยกว่า 200 kcal</option>  
        <option value="300"> น้อยกว่า 300 kcal</option>
        <option value="400"> น้อยกว่า 400 kcal</option>
        <option value="500"> น้อยกว่า 500 kcal</option>
        <option value="501"> มากกว่า 500 kcal</option>
    </select>
</span>
</div>
		</form>
	</div>

	<table class="body-group" id="show-data">
	
	</table>
	
<!-- ---------------------------------------------------------line more -->
	<!-- <div id="line-mores">
		<div id="line-more"></div>
		<div id="moremenubut">
		<button id="moremenu">+</button>
		</div>
		<h1>แสดงเพิ่ม</h1>
	</div> -->
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

	<script type="text/javascript" src="js/gen_validatorv31.js"></script>
	<script type="text/javascript" src="js/plus.js"></script>
	<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("login");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("username","req","กรุณากรอก Username");
    
    frmvalidator.addValidation("password","req","กรุณากรอก Password");

// ]]>
	// function click2() {
 //    document.getElementById("food_name").value = "ข้าว";   
	// }
	// function click3() {
 //    document.getElementById("select_typefood").value = "นึ่ง";
	// }
	$(window).scroll(function() {
  sessionStorage.scrollTop = $(this).scrollTop();
});

$(document).ready(function() {
  if (sessionStorage.scrollTop != "undefined") {
    $(window).scrollTop(sessionStorage.scrollTop);
  }
});


  

</script>
</body>
</html>