<?php

$db_username = 'id11515450_foodslan_root';
$db_password = 'foodlandsu123';
$db_name = 'id11515450_foodslan_foodland';
$db_host = 'localhost';
					
$conn = new mysqli($db_host, $db_username, $db_password,$db_name);

if ($conn->connect_error) {
    die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
}
mysqli_set_charset($conn,"utf8");
?>