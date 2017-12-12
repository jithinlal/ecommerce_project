<?php 

	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
?>

<form action="" method="POST" enctype="multipart/form-data" style="padding: 40px;">
	<b>Insert New Category :</b>
	<input name="new_cat" type="text" required />
	<input type="submit" name="add_cat" value="Add" style="color:green;" />
</form>

<?php 
	include('includes/db.php');
	if(isset($_POST['add_cat'])){
		$new_cat = $_POST['new_cat'];	
		if(preg_match("/^[a-zA-Z0-9 ']+$/", $new_cat) != 1){
            echo '<script>alert("invalid brand name")</script>';
            echo "<script>window.open('insert_category.php','_self')</script>"; 
            exit;
        }
        $new_cat = mysqli_real_escape_string($con,$new_cat);

		$new_query = "INSERT INTO categories (cat_title) VALUES ('$new_cat')";
		$run_new = mysqli_query($con,$new_query);

		if($run_new){
			echo "<script>alert('New Category has been Added')</script>";
            echo "<script>window.open('index.php?view_categories','_self')</script>";
		}
	}
}
	