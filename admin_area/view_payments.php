<table width="795" align="center" bgColor="pink" class="table table-hover">
	<thead>
		<tr align="center">
			<td colspan="7"><h2>View Payment Details</h2></td>
		</tr>

		<tr align="center" bgcolor="skyblue">
			<th>S.No.</th>
			<th>Customer Email</th>
			<th>Product(s)</th>
			<th>Amount</th>
			<th>Transaction ID</th>		
			<th>Payment Date</th>
			<th>Currency</th>
		</tr>
	</thead>
	<tbody>
		<?php
			session_start();
			include('includes/db.php');		

			$get_pay = "SELECT * FROM payments";
			$run_pay = mysqli_query($con,$get_pay);
			$i = 0;
			while($row_pay = mysqli_fetch_array($run_pay)){
				$pay_date = $row_pay['payment_date'];
				$pro_id = $row_pay['product_id'];			
				$c_id = $row_pay['customer_id'];
				$trx_id = $row_pay['trx_id'];
				$currency = $row_pay['currency'];			
				$amount = $row_pay['amount'];
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

		<tr align="center" class="table-success">
			<td><?php echo $i; ?></td>
			<td><?php echo $c_email; ?></td>
			<td><img src="../admin_area/product_images/<?php echo $pro_image; ?>" width="50" height="50" /><br/><?php echo $pro_name; ?></td>
			<td><?php echo $amount; ?></td>
			<td><?php echo $trx_id; ?></td>
			<td><?php echo $pay_date; ?></td>
			<td><?php echo $currency;?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>