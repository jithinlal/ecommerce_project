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
			<td colspan="6"><h2>View All Brands</h2></td>
		</tr>

		<tr align="center" bgcolor="skyblue">
			<th>S.No.</th>
			<th>Title</th>
			<th>ID</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php
			include('includes/db.php');
			$get_brand = "SELECT * FROM brands";
			$run_brand = mysqli_query($con,$get_brand);

			$i = 0;
			while($row_brand = mysqli_fetch_array($run_brand)){
				$brand_id = $row_brand['brand_id'];
				$brand_title = $row_brand['brand_title'];			
				$i++;
		?>

		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $brand_id; ?></td>
			<td><?php echo $brand_title; ?></td>
			<td><a class="btn btn-warning" role="button" href="index.php?edit_brand=<?php echo $brand_id; ?>">Edit</a></td>
			<td><a class="btn btn-danger" role="button" href="delete_brand.php?delete_brand=<?php echo $brand_id; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php } ?>