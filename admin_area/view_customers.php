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
			<td colspan="6"><h2>View All Customers</h2></td>
		</tr>

		<tr align="center" bgcolor="skyblue">
			<th>S.No.</th>
			<th>Name</th>
			<th>Email</th>
			<th>Image</th>		
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include('includes/db.php');
			$get_custom = "SELECT * FROM customer";
			$run_get = mysqli_query($con,$get_custom);
			$i = 0;
			while($row_pro = mysqli_fetch_array($run_get)){
				$cus_id = $row_pro['customer_id'];
				$cus_name = $row_pro['customer_name'];
				$cus_image = $row_pro['customer_image'];
				$cus_email = $row_pro['customer_email'];
				$i++;
		?>

		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $cus_name; ?></td>		
			<td><?php echo $cus_email; ?></td>
			<td><img src="../customer/customer_images/<?php echo $cus_image; ?>" width="60" height="60" /></td>		
			<td><a class="btn btn-outline-danger" role="button" href="delete_customer.php?delete_cus=<?php echo $cus_id; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php } ?>