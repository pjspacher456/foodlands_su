<?php
include "config.php";
include "login_check.php";
$fgmembersite->LogOut();
header("location:index.php");
?>