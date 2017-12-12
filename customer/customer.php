<html>
	<head>
		<link href="styles/login_style.css" rel="stylesheet">
	</head>
	<body>
		<div class="login">
			<h2 style="color: red;text-align: center;"><?php echo @$_GET['not_admin']; ?></h2>
			<div class="login-triangle"></div>
		  
			<h2 class="login-header">Log in</h2>

			<form class="login-container" method="POST">
			  <p><input type="email" name="email" placeholder="Email" required></p>
			  <p><input type="password" name="pass" placeholder="Password" required></p>
			  <p><input type="submit" name="login" value="Log in"></p>
			</form>
		</div>
	</body>
</html>

<?php
	include('includes/db.php');
	session_start();
	if(isset($_POST['login'])){
		$email = mysqli_real_escape_string($con,$_POST['email']);
		$password = md5($_POST['pass']);

		$customer_query = "SELECT * FROM customer WHERE customer_email='$email' AND customer_pass='$password'";		
		$run_customer = mysqli_query($con,$customer_query);

		$customer_num = mysqli_num_rows($run_customer);

		if($customer_num == 0){
			echo '<script>alert("Your email or password is wrong")</script>';
			echo "<script>window.open('customer.php','_self')</script>";
		}
		else{
			$_SESSION['customer_email'] = $email;
			echo '<script>alert("Welcome customer")</script>';
			echo "<script>window.open('my_account.php','_self')</script>";
		}
	}
?>
