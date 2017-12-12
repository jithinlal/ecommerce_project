<table width="795" align="center" bgColor="pink" class="table table-hover">
	<thead>
		<tr align="center">
			<td colspan="7"><h2>View All Order Details</h2></td>
		</tr>

		<tr align="center" bgcolor="skyblue">
			<th>S.No.</th>
			<th>Customer Email</th>
			<th>Product(s)</th>
			<th>Quantity</th>
			<th>Invoice Number</th>
			<th>Order Date</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php
			session_start();
			include('includes/db.php');		

			$get_order = "SELECT * FROM orders WHERE status='in progress'";
			$run_order = mysqli_query($con,$get_order);
			$i = 0;
			while($row_order = mysqli_fetch_array($run_order)){
				$order_date = $row_order['order_date'];
				$pro_id = $row_order['p_id'];
				$order_id = $row_order['order_id'];
				$c_id = $row_order['c_id'];
				$order_qty = $row_order['qty'];
				$order_invoice = $row_order['invoice_no'];
				$order_status = $row_order['status'];
				$i++;

				$pro_query = "SELECT * FROM products WHERE product_id=$pro_id";
				$pro_run = mysqli_query($con,$pro_query);

				$row_pro = mysqli_fetch_array($pro_run);
				$pro_name = $row_pro['product_title'];
				$pro_image = $row_pro['product_image'];

				$get_c = "SELECT * FROM customer WHERE customer_id=$c_id";
				$run_c = mysqli_query($con,$get_c);

				$row_c = mysqli_fetch_array($run_c);
				$c_email = $row_c['customer_email'];

		?>

		<tr align="center">
			<td><?php echo $i; ?></td>
			<td><?php echo $c_email; ?></td>
			<td><img src="../admin_area/product_images/<?php echo $pro_image; ?>" width="50" height="50" /><br/><?php echo $pro_name; ?></td>
			<td><?php echo $order_qty; ?></td>
			<td><?php echo $order_invoice; ?></td>
			<td><?php echo $order_date; ?></td>
			<td><a class="btn btn-outline-primary" role="button" href="index.php?confirm_order=<?php echo $order_id;?>">Complete Order</a></td>
		</tr>
		<?php } ?>
	</tbody>
</table>