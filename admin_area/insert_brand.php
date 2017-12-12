<?php

	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
?>

<form action="" method="POST" enctype="multipart/form-data" style="padding: 40px;">
	<b>Insert New Brand :</b>
	<input name="new_brand" type="text" required />
	<input type="submit" name="add_brand" value="Add" style="color:green;" />
</form>

<?php 
	include('includes/db.php');
	if(isset($_POST['add_brand'])){
		$new_brand = $_POST['new_brand'];	
		if(preg_match("/^[a-zA-Z0-9 ']+$/", $new_brand) != 1){
            echo '<script>alert("invalid brand name")</script>';
            echo "<script>window.open('insert_brand.php','_self')</script>"; 
            exit;
        }
        $new_brand = mysqli_real_escape_string($con,$new_brand);

		$new_query = "INSERT INTO brands (brand_title) VALUES ('$new_brand')";
		$run_new = mysqli_query($con,$new_query);

		if($run_new){
			echo "<script>alert('New Brand has been Added')</script>";
            echo "<script>window.open('index.php?view_brands','_self')</script>";
		}
	}
}
	