<?php 
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
		include('includes/db.php');
		if(isset($_GET['delete_cat'])){
			$get_id = $_GET['delete_cat'];

			$delete_query = "DELETE FROM categories WHERE cat_id=$get_id";
			$run_delete = mysqli_query($con,$delete_query);

			if($run_delete){
				echo '<script>alert("The category has been Deleted")</script>';
				echo "<script>window.open('index.php?view_categories','_self')</script>";
			}
		}
	}
?>