<?php

    $total = 0;
    $ip = getIp();

    $sel_price = "SELECT * FROM cart WHERE ip_add='$ip'";
    $run_price = mysqli_query($con, $sel_price);

    while ($price = mysqli_fetch_array($run_price)) {
        $pro_id = $price['product_id'];
        $qty = $price['quantity'];

        $price_query = "SELECT * FROM products WHERE product_id=$pro_id";
        $run_pro_price = mysqli_query($con, $price_query);

        while ($pro_price = mysqli_fetch_array($run_pro_price)) {
            $product_price = array($pro_price['product_price']);
            $product_name = $pro_price['product_title'];
            $values = array_sum($product_price);

            $total += $values * $qty;
        }
    }

    $get_qty = "SELECT * FROM cart WHERE product_id=$product_id";
    $qty_query = mysqli_query($con,$get_qty);

    $row_qty = mysqli_fetch_array($qty_query);
    $qty = $row_qty['quantity'];

    if($qty == 0){
    	$qty = 1;
    }
?>
<div>
    <h2>Pay with PAYPAL</h2>
    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">

	    <!-- Identify your business so that you can collect the payments. -->
	  	<input type="hidden" name="business" value="sriniv_1293527277_biz@inbox.com">

	  	<!-- Specify a Buy Now button. -->
	  	<input type="hidden" name="cmd" value="_xclick">

	  	<!-- Specify details about the item that buyers will purchase. -->
	  	<input type="hidden" name="item_name" value="<?php echo $product_name; ?>">
	  	<input type="hidden" name="amount" value="<?php echo $total; ?>">
	  	<input type="hidden" name="currency_code" value="USD">

	  	<input type="hidden" name="return" value="http://60f55db6.ngrok.io/jiphp/ecommerce/paypal_success.php">
	  	<input type="hidden" name="cancel_return" value="http://60f55db6.ngrok.io/jiphp/ecommerce/paypal_cancel.php">

	  	<!-- Display the payment button. -->
	  	<input type="image" name="submit" border="0" src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_buynow_107x26.png" alt="Buy Now">
	  	<img alt="" border="0" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >

	</form>
</div>
