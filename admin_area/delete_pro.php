<?php 
	
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
		include('includes/db.php');
		if(isset($_GET['delete_pro'])){
			$get_id = $_GET['delete_pro'];

			$delete_query = "DELETE FROM products WHERE product_id=$get_id";
			$run_delete = mysqli_query($con,$delete_query);

			if($run_delete){
				echo '<script>alert("The Product has been Deleted")</script>';
				echo "<script>window.open('index.php','_self')</script>";
			}
		}
	}

?>