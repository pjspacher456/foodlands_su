<?php
	session_start();
	include "config.php";
if(isset($_POST["type"]) && $_POST["type"]=='add' && $_POST["product_qty"]>0)
{
	foreach($_POST as $key => $value){ //add all post vars to new_product array
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
	//remove unecessary vars
	unset($new_product['type']);
	unset($new_product['return_url']); 
	
 	//we need to get product name and price from database.
    $statement = $conn->prepare("SELECT f_name, f_price, f_cal, res_name, f_pic FROM food WHERE product_code=? LIMIT 1");
    $statement->bind_param('s', $new_product['product_code']);
    $statement->execute();
    $statement->bind_result($f_name, $f_price, $f_cal, $res_name, $f_pic);
	
	while($statement->fetch()){
		
		//fetch product name, price from db and add to new_product array
        $new_product["f_name"] = $f_name; 
        $new_product["f_price"] = $f_price;
        $new_product["f_cal"] = $f_cal;
        $new_product["res_name"] = $res_name;
        $new_product["f_pic"] = $f_pic;
        
        if(isset($_SESSION["cart_products"])){  //if session var already exist
            if(isset($_SESSION["cart_products"][$new_product['product_code']])) //check item exist in products array
            {
                unset($_SESSION["cart_products"][$new_product['product_code']]); //unset old array item
            }           
        }
        $_SESSION["cart_products"][$new_product['product_code']] = $new_product; //update or create product session with new item  
    } 
}

//update or remove items 
if(isset($_POST["product_qty"]) || isset($_POST["remove_code"]))
{
	//update item quantity in product session
	if(isset($_POST["product_qty"]) && is_array($_POST["product_qty"])){
		foreach($_POST["product_qty"] as $key => $value){
			if(is_numeric($value)){
				$_SESSION["cart_products"][$key]["product_qty"] = $value;
			}
		}
	}
	//remove an item from product session
	if(isset($_POST["remove_code"]) && is_array($_POST["remove_code"])){
		foreach($_POST["remove_code"] as $key){
			unset($_SESSION["cart_products"][$key]);
	}
}
}

$_SESSION["number_cart"] = count($_SESSION["cart_products"]);

//back to return url
$return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
header('Location:'.$return_url);

?>