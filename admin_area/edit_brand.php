<?php 
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
		include('includes/db.php');
		if(isset($_GET['edit_brand'])){
			$get_id = $_GET['edit_brand'];

			$brand_get = "SELECT * FROM brands WHERE brand_id=$get_id";
			$run_brand = mysqli_query($con,$brand_get);

			$row_brand = mysqli_fetch_array($run_brand);
			$brand_title = $row_brand['brand_title'];
		}
?>

<form action="" method="POST" enctype="multipart/form-data" style="padding: 40px;">
	<b>Edit Brand</b>                       
    <input type="text" name="brand_title" value="<?php echo $brand_title; ?>" required>         
    <input style="color:red;" type="submit" name="change_title" value="Edit Brand" />            
</form>

<?php

	if(isset($_POST['change_title'])){
		$updated_brand_title = $_POST['brand_title'];
		if(preg_match("/^[a-zA-Z0-9 ']+$/", $updated_brand_title) != 1){
            echo '<script>alert("invalid brand name")</script>';
            echo "<script>window.open('edit_brand.php','_self')</script>"; 
            exit;
        }
        $updated_brand_title = mysqli_real_escape_string($con,$updated_brand_title);

		$up_brand = "UPDATE brands SET brand_title='$updated_brand_title' WHERE brand_id=$get_id";		
		$run_up = mysqli_query($con,$up_brand);

		if($run_up){
			echo '<script>alert("Updation is Successful")</script>';
            echo "<script>window.open('index.php?view_brands','_self')</script>";
		}
	}
}