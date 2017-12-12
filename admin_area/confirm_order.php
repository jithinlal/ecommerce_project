<?php 
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
		include('includes/db.php');
		if(isset($_GET['confirm_order'])){
			$order_id = $_GET['confirm_order'];

			$alter_status = "UPDATE orders SET status='completed' WHERE order_id=$order_id";
			$alter_run = mysqli_query($con,$alter_status);

			if($alter_run){
				echo '<script>alert("order is confirmed")</script>';
				echo "<script>window.open('index.php','_self')</script>";
			}
		}
	}

?>