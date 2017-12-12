<?php 
	session_start();
	include('includes/db.php');
	include('functions/functions.php');
    $total = 0;
    $ip = getIp();

    $sel_price = "SELECT * FROM cart WHERE ip_add='$ip'";
    $run_price = mysqli_query($con, $sel_price);

    while ($price = mysqli_fetch_array($run_price)) {
        $pro_id = $price['product_id'];
        
        $price_query = "SELECT * FROM products WHERE product_id=$pro_id";
        $run_pro_price = mysqli_query($con, $price_query);

        while ($pro_price = mysqli_fetch_array($run_pro_price)) {
            $product_price = array($pro_price['product_price']);
            $product_id = $pro_price['product_id'];
            $values = array_sum($product_price);

            $total += $values;
        }
    }

    $get_qty = "SELECT * FROM cart WHERE product_id=$product_id";
    $qty_query = mysqli_query($con,$get_qty);

    $row_qty = mysqli_fetch_array($qty_query);
    $qty = $row_qty['quantity'];

    if($qty == 0){
    	$qty = 1;
    }else{
    	$total = $total*$qty;
    }

    $user_email = $_SESSION['customer_email'];
    $get_img = "SELECT * FROM customer WHERE customer_email='$user_email'";
    $run_img = mysqli_query($con,$get_img);
    $row_img = mysqli_fetch_array($run_img);
    $c_id = $row_img['customer_id'];

    $paypal_amount = $_GET['amt'];
    $paypal_amount= round($paypal_amount,0,PHP_ROUND_HALF_UP);
    if(!filter_var($paypal_amount,FILTER_VALIDATE_INT)){
        echo '<script>alert("not a  valid amount")</script>';
        echo "<script>window.open('index.php','_self')</script>";   
    }

    $paypal_curreny = $_GET['cc'];
    if(preg_match("/^[a-zA-Z]+$/", $paypal_curreny) != 1){
            echo '<script>alert("invalid currency")</script>';
            echo "<script>window.open('index.php','_self')</script>"; 
    }
    $paypal_curreny = mysqli_real_escape_string($con,$paypal_curreny);

    $trx_id = $_GET['tx'];
    if(preg_match("/^[a-zA-Z0-9]+$/", $trx_id) != 1){
            echo '<script>alert("invalid currency")</script>';
            echo "<script>window.open('index.php','_self')</script>"; 
    }
    $trx_id = mysqli_real_escape_string($con,$trx_id);

    $trx_name = $_GET['item_name'];
    if(preg_match("/^[a-z A-Z]+$/", $trx_name) != 1){
            echo '<script>alert("invalid transaction name")</script>';
            echo "<script>window.open('index.php','_self')</script>"; 
    }
    $trx_name = mysqli_real_escape_string($con,$trx_name);

    $trx_st = $_GET['st'];
    $invoice = mt_rand();

    $pay_query = "INSERT INTO payments (amount,customer_id,product_id,trx_id,currency,payment_date) VALUES ($paypal_amount,$c_id,$product_id,'$trx_id','$paypal_curreny',NOW())";
    $run_pay = mysqli_query($con,$pay_query);

    $order_query = "INSERT INTO orders (p_id,c_id,qty,order_date,status,invoice_no) VALUES ($product_id,$c_id,$qty,NOW(),'in progress',$invoice)";
    $run_order = mysqli_query($con,$order_query);

    $empty_cart = "DELETE FROM cart";
    $run_empty = mysqli_query($con,$empty_cart);
?>
<html>
	<head>
		<title>Payment Success</title>
	</head>
	<body>
		<h2>Welcome <?php echo $_SESSION['customer_email']; ?></h2>
    	<?php		
        	if($paypal_amount == $total){    		
        ?>
    
		<h2>Payment was successful</h2>
		<h3><a href="http://60f55db6.ngrok.io/jiphp/ecommerce/customer/my_account.php">Go to your account</a></h3>
	</body>
</html>
<?php }else{ ?>
    	<h2>Payment failed</h2>
		<h3><a href="http://60f55db6.ngrok.io/jiphp/ecommerce/customer/my_account.php">Go back to your account</a></h3>
	</body>
</html>
<?php } ?>
	
