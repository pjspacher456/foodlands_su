<?php
	session_start();
	require_once ('db.php');
	$current_url = $_SESSION["current_url"];
	$Db = new Db;

	$food_name = $_GET['food_name'];
	$select_typefood = $_GET['select_typefood'];
	$select_met = $_GET['select_met'];
	$select_cal = $_GET['select_cal'];
	// $type1 = $_GET['type1'];
	// $type2 = $_GET['type2'];

	$sql = "SELECT * FROM food WHERE 1";

	if (!empty($food_name)) {
		$sql.=' AND f_name LIKE "'.$food_name.'%"';
	}
	if ($select_typefood !='all') {
		
		$sql.=' AND f_type LIKE "%'.$select_typefood.'%"';
	}
	// if ($type1 !='all') {
	// 	$sql.=' AND product_code LIKE "%'.$type1.'%"';
	// }
	// if ($type2 !='all') {
	// 	$sql.=' AND f_id LIKE "%'.$type2.'%"';
	// }
	if ($select_met !='all') {
		
		$sql.=' AND f_met LIKE "%'.$select_met.'%"';
	}
	if ($select_cal !='all' && $select_cal <= '500') {
		
		$sql.=' AND f_cal < "'.$select_cal.'" ORDER BY f_cal';
	}else{
		$sql.=' AND f_cal > "'.$select_cal.'" ORDER BY f_cal';
	}


	

	$result = $Db->select($sql);
	
	if (!empty($result['items']))
	{
		// print_r($result['items']);
		foreach ($result['items'] as $key => $value) 
		{
			if ($key==0) {
				echo "<tr>";
			}elseif ($key%4==0) {
				echo "<tr>";
			}
?>
				<td>
		<form action="cart_update.php" method="POST">
		<div class="group-food">
			<div class="pic-food" style="background-image:url('<?php echo $value['f_pic'];?>')"></div>
			<li class="cost-food">
				<h3>ราคา</h3>
				<h1><?php echo $value['f_price'];?></h1>
				<h3>บาท</h3>
			</li>
		<div class="group-detail">
			<h2><?php echo $value['f_name'];?></h2>
			<h4> @<?php echo $value['res_name'];?></h4>
			<h3><?php echo $value['f_cal'];?> kcal</h3>
			<div class="total-select"></div>
			<div class="triangle tri2"></div>
			<div class="triangle-shadow shtri"></div>
		</div>
		<div class="quantity" style="font-family:FontAwesome,'supermarketregular'; ">
		<input type="number" min="1" max="99" step="1" value="1" name="product_qty" style="    font-family: 'supermarketregular';font-size: 16px;padding-top: 2px">
		<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="fa fa-plus" style="font-size:10px;"></i></div><div class="quantity-button quantity-down"><i class="fa fa-minus" style="font-size:10px;"></i></div></div>
		</div>
		<input type="hidden" name="product_code" value="<?php echo $value["product_code"];?>" />
		<input type="hidden" name="type" value="add" />
		<input type="hidden" name="return_url" value="<?php echo $current_url; ?>" />
		<button class="add-store add_to_cart" type="submit">
			<i class="fa fa-shopping-basket"></i>
		</button>
		</div></form></td>

<?php
				}
				?>
				<script type="text/javascript">    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.click(function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });</script>
				<?php
		}
?>