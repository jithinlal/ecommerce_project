<?php 
	session_start();
	include('includes/db.php');

	if(!isset($_SESSION['customer_email'])){
        echo "<script>window.open('customer.php','_self')</script>";
    }else{
?>
<h2 style="text-align: center;">Do you really want to <span style="color:red;">DELETE</span> your account?</h2>
<form style="text-align: center;" action="" method="POST">
	<input type="submit" name="yes" value="YES, Delete my Account" />
	<input type="submit" name="no" value="NO, please don't!" />
</form>

<?php
	
	$user_email = $_SESSION['customer_email'];

	if(isset($_POST['yes'])){
		$delete_customer = "DELETE FROM customer WHERE customer_email='$user_email'";
		$run_delete = mysqli_query($con,$delete_customer);

		if($run_delete){
			echo '<script>alert("Your Account has been Deactivated, See you on the other side!")</script>';
			echo "window.open('../index.php','_self')";
		}
	}

	if(isset($_POST['no'])){
		echo '<script>alert("That is a close call!")</script>';
		echo "<script>window.open('my_account.php','_self')</script>";
	}
}
?>