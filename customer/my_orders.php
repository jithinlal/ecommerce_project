<?php
	session_start();
	include('includes/db.php');

	if(!isset($_SESSION['customer_email'])){
     echo "<script>window.open('customer.php','_self')</script>";
	}else{
?>
<table width="795" align="center" bgColor="pink">
	<tr align="center">
		<td colspan="6"><h2>Your Order Details</h2></td>
	</tr>

	<tr align="center" bgcolor="skyblue">
		<th>S.No.</th>
		<th>Product(s)</th>
		<th>Quantity</th>
		<th>Invoice Number</th>
		<th>Order Date</th>
		<th>Status</th>
	</tr>

	<?php
	
		$user_email = $_SESSION['customer_email'];
	    $get_img = "SELECT * FROM customer WHERE customer_email='$user_email'";
	    $run_img = mysqli_query($con,$get_img);
	    $row_img = mysqli_fetch_array($run_img);
	    $c_id = $row_img['customer_id'];

		$get_order = "SELECT * FROM orders WHERE c_id=$c_id";
		$run_order = mysqli_query($con,$get_order);
		$i = 0;
		while($row_order = mysqli_fetch_array($run_order)){
			$order_date = $row_order['order_date'];
			$pro_id = $row_order['p_id'];
			$order_qty = $row_order['qty'];
			$order_invoice = $row_order['invoice_no'];
			$order_status = $row_order['status'];
			$i++;

			$pro_query = "SELECT * FROM products WHERE product_id=$pro_id";
			$pro_run = mysqli_query($con,$pro_query);

			$row_pro = mysqli_fetch_array($pro_run);
			$pro_name = $row_pro['product_title'];
			$pro_image = $row_pro['product_image'];
	?>

	<tr align="center">
		<td><?php echo $i; ?></td>
		<td><img src="../admin_area/product_images/<?php echo $pro_image; ?>" width="50" height="50" /><br/><?php echo $pro_name; ?></td>
		<td><?php echo $order_qty; ?></td>
		<td><?php echo $order_invoice; ?></td>
		<td><?php echo $order_date; ?></td>
		<td><?php echo $order_status; ?></td>
	</tr>
	<?php } ?>
</table>

<?php } ?>