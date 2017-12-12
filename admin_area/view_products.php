<?php 

	session_start();
	if(!isset($_SESSION['user_email'])){
		echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
	}
	else{
?>

<table width="795" align="center" bgColor="pink" class="table table-hover">
	<thead>
		<tr align="center">
			<td colspan="6"><h2>View All Products</h2></td>
		</tr>

		<tr align="center" bgcolor="skyblue">
			<th>S.No.</th>
			<th>Title</th>
			<th>Image</th>
			<th>Price</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include('includes/db.php');
			$get_pro = "SELECT * FROM products";
			$run_get = mysqli_query($con,$get_pro);
			$i = 0;
			while($row_pro = mysqli_fetch_array($run_get)){
				$pro_id = $row_pro['product_id'];
				$pro_title = $row_pro['product_title'];
				$pro_image = $row_pro['product_image'];
				$pro_price = $row_pro['product_price'];
				$i++;
		?>

		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $pro_title; ?></td>
			<td><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60" /></td>
			<td><?php echo $pro_price; ?></td>
			<td><a class="btn btn-warning" role="button" href="index.php?edit_pro=<?php echo $pro_id; ?>">Edit</a></td>
			<td><a class="btn btn-danger" role="button" href="delete_pro.php?delete_pro=<?php echo $pro_id; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php } ?>