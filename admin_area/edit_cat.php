<?php 
	
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
		include('includes/db.php');
		if(isset($_GET['edit_cat'])){
			$get_id = $_GET['edit_cat'];

			$cat_get = "SELECT * FROM categories WHERE cat_id=$get_id";
			$run_cat = mysqli_query($con,$cat_get);

			$row_cat = mysqli_fetch_array($run_cat);
			$cat_title = $row_cat['cat_title'];
		}
?>

<form action="" method="POST" enctype="multipart/form-data" style="padding: 40px;">
	<b>Edit Category</b>                       
    <input type="text" name="cat_title" value="<?php echo $cat_title; ?>" required>         
    <input style="color:red;" type="submit" name="change_title" value="Edit Category" />            
</form>

<?php

	if(isset($_POST['change_title'])){
		$updated_cat_title = $_POST['cat_title'];
		if(preg_match("/^[a-zA-Z0-9 ']+$/", $updated_cat_title) != 1){
            echo '<script>alert("invalid brand name")</script>';
            echo "<script>window.open('edit_cat.php','_self')</script>"; 
            exit;
        }
        $updated_cat_title = mysqli_real_escape_string($con,$updated_cat_title);

		$up_cat = "UPDATE categories SET cat_title='$updated_cat_title' WHERE cat_id=$get_id";
		$run_up = mysqli_query($con,$up_cat);

		if($run_up){
			echo '<script>alert("Updation is Successful")</script>';
            echo "<script>window.open('index.php?view_categories','_self')</script>";
		}
	}
}