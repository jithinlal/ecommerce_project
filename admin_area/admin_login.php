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

		$admin_query = "SELECT * FROM admins WHERE user_email='$email' AND user_pass='$password'";		
		$run_admin = mysqli_query($con,$admin_query);

		$admin_num = mysqli_num_rows($run_admin);

		if($admin_num == 0){
			echo '<script>alert("You are not an Admin")</script>';
			echo "<script>window.open('admin_login.php','_self')</script>";
		}
		else{
			$_SESSION['user_email'] = $email;
			echo '<script>alert("Welcome Admin")</script>';
			echo "<script>window.open('index.php','_self')</script>";
		}
	}
?>
