<?php
	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
?>

<!DOCTYPE html>
<html>
	<head>
		<title>e-Commerce Admin</title>
		<link rel="stylesheet" href="styles/style.css">
		<link rel="stylesheet" href="styles/mystyles.css">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
	</head>

	<body>
		<div class="main_wrapper">
			<div id="header"></div>
			<div id="right">
				<h2 style="text-align: center;">Manage Content</h2>
				<a href="index.php?insert_product">Insert New Product</a>
				<a href="index.php?view_products">View All Products</a>
				<a href="index.php?insert_category">Insert New Category</a>
				<a href="index.php?view_categories">View All Categories</a>
				<a href="index.php?insert_brand">Insert New Brands</a>
				<a href="index.php?view_brands">View All Brands</a>
				<a href="index.php?view_customers">View Customers</a>
				<a href="index.php?view_orders">View Orders</a>
				<a href="index.php?view_payments">View Payments</a>
				<a href="admin_logout.php">LogOut</a>
			</div>
			<div id="left">
				<?php
					if(isset($_GET['insert_product'])){
						include('insert_product.php');
					}
					if(isset($_GET['view_products'])){
						include('view_products.php');
					}
					if(isset($_GET['edit_pro'])){						
						include('pro_edit.php');					
					}
					if(isset($_GET['insert_category'])){
						include('insert_category.php');
					}
					if(isset($_GET['view_categories'])){
						include('view_categories.php');
					}
					if(isset($_GET['edit_cat'])){
						include('edit_cat.php');
					}
					if(isset($_GET['insert_brand'])){
						include('insert_brand.php');
					}
					if(isset($_GET['view_brands'])){
						include('view_brands.php');
					}
					if(isset($_GET['edit_brand'])){
						include('edit_brand.php');
					}
					if(isset($_GET['view_customers'])){
						include('view_customers.php');
					}
					if(isset($_GET['view_orders'])){
						include('view_orders.php');
					}
					if(isset($_GET['view_payments'])){
						include('view_payments.php');
					}
					if(isset($_GET['confirm_order'])){
						include('confirm_order.php');
					}
				?>
			</div>
		</div>
	</body>
</html>
<?php } ?>