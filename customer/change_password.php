<?php
    session_start();
    include('includes/db.php');
    if(!isset($_SESSION['customer_email'])){
        echo "<script>window.open('customer.php','_self')</script>";
    }else{
        $customer = $_SESSION['customer_email'];
        $customer_query = "SELECT * FROM customer WHERE customer_email='$customer'";
        $res_customer = mysqli_query($con,$customer_query);

        $res_row = mysqli_fetch_array($res_customer);

        $c_id = $res_row['customer_id'];
        $c_pass = $res_row['customer_pass'];
        $c_email = $customer;
?>

    <form action="" method="post" enctype="multipart/form-data">
        <table align="center" width="750">
            <tr align="center">
                <td colspan="4"><h2>Change your Password</h2></td>
            </tr>

            <tr>
                <td align="right"><b>Current Password</b></td>
                <td><input type="password" name="c_current_pass" required></td>
            </tr>

			<tr>
                <td align="right"><b>New Password</b></td>
                <td><input type="password" name="c_new_pass" required></td>
            </tr>

			<tr>
                <td align="right"><b>Confirm New Password</b></td>
                <td><input type="password" name="c_new_pass_confirm" required></td>
            </tr>

            <tr align="center">
                <td colspan="4"><input type="submit" name="change_password" value="Update Account" /></td>
            </tr>
        </table>
    </form>

<?php
    if (isset($_POST['change_password'])) {
        $c_ip = getIp();
        $c_current = md5($_POST['c_current_pass']);
        $c_new_pass = md5($_POST['c_new_pass']);
       	$c_new_pass_confirm = md5($_POST['c_new_pass_confirm']);

        if($c_pass != $c_current){
			echo '<script>alert("Password does not matched!")</script>';
			echo "<script>window.open('my_account.php','_self')</script>";
		}else if($c_new_pass == $c_new_pass_confirm){
			$update_pass = "UPDATE customer SET customer_pass='$c_new_pass' WHERE customer_id=$c_id";
			$update_query = mysqli_query($con,$update_pass);

			if($update_query){
				echo '<script>alert("Password Changed!")</script>';
				echo "<script>window.open('my_account.php','_self')</script>";
			}
		}else{
			echo '<script>alert("Password mismatch!")</script>';
			echo "<script>window.open('my_account.php','_self')</script>";
		}


        if ($run_update) {
            echo '<script>alert("Updation is Successful")</script>';
            echo "<script>window.open('my_account.php','_self')</script>";
        }
    }
}
?>
