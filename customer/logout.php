<?php

session_start();
if(!isset($_SESSION['customer_email'])){
     echo "<script>window.open('customer.php','_self')</script>";
}else{
	session_destroy();
	echo "<script>window.open('../index.php','_self')</script>";
}