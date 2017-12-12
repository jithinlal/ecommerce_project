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
			<td colspan="6"><h2>View All Categories</h2></td>
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
			$get_cat = "SELECT * FROM categories";
			$run_cat = mysqli_query($con,$get_cat);

			$i = 0;
			while($row_cat = mysqli_fetch_array($run_cat)){
				$cat_id = $row_cat['cat_id'];
				$cat_title = $row_cat['cat_title'];			
				$i++;
		?>

		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $cat_id; ?></td>
			<td><?php echo $cat_title; ?></td>
			<td><a class="btn btn-warning" role="button" href="index.php?edit_cat=<?php echo $cat_id; ?>">Edit</a></td>
			<td><a  class="btn btn-danger" role="button" href="delete_cat.php?delete_cat=<?php echo $cat_id; ?>">Delete</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<?php } ?>