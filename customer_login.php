<?php
    include('includes/db.php');
?>
<div>
    <form method="post">
        <table width="500" align="center">
            <tr align="center">
                <td colspan="4"><h2>Login/Register to BUY!</h2></td>
            </tr>

            <tr>
                <td align="right"><b>Email:</b></td>
                <td><input type="text" name="email" placeholder="Enter email" required></td>
            </tr>

            <tr>
                <td align="right"><b>Password:</b></td>
                <td><input type="password" name="pass" placeholder="Enter password" required/></td>
            </tr>

            <!-- <tr align="center">
                <td colspan="3"><a href="checkout.php?forgot_pass">Forgot password</a></td>
            </tr> -->

            <tr align="center">
                <td colspan="4"><input class="btn btn-success" type="submit" name="login" value="Login" /></td>
            </tr>
        </table>
        <h2 style="float:right;padding:5px;"><a class="btn btn-outline-primary" href="customer_register.php" style="text-decoration:none;">New Registration</a></h2>
    </form>
    <?php
    if (isset($_POST['login'])) {
        $c_email = $_POST['email'];
        $c_pass = md5($_POST['pass']);

        $select_customer = "SELECT * FROM customer WHERE customer_email='$c_email' AND customer_pass='$c_pass'";
        $select_query = mysqli_query($con, $select_customer);

        $check_customer = mysqli_num_rows($select_query);
        if ($check_customer == 0) {
            echo '<script>alert("Email or Password is incorrect. Please try again!")</script>';            
            exit;
        }

        $ip = getIp();
        $select_cart = "SELECT * FROM cart WHERE ip_add='$ip'";
        $run_cart = mysqli_query($con, $select_cart);
        $check_cart = mysqli_num_rows($run_cart);

        if ($check_customer > 0 && $check_cart == 0) {
            $_SESSION['customer_email'] = $c_email;
            echo '<script>alert("Logged in successfully!")</script>';
            echo '<script>window.open("customer/my_account.php","_self")</script>';
        } else {
            $_SESSION['customer_email'] = $c_email;
            echo '<script>alert("Logged in successfully!")</script>';
            echo '<script>window.open("checkout.php","_self")</script>';
        }
    }
    ?>
</div>
