<!DOCTYPE html>
<?php
    session_start();
    include('functions/functions.php');
    include('includes/db.php');
    include('includes/view.php');
?>
                <div id="content_area">
                    <?php cart(); ?>
                    <div id="shopping_cart">
                        <span style="float:right;font-size:18px;padding:5px;line-height:40px;">
                            <?php
                            if (isset($_SESSION['customer_email'])) {
                                echo 'Welcome <b>'.$_SESSION['customer_email'].'</b> <b style="color:yellow">Shopping Cart</b>';
                            } else {
                                echo 'Welcome Guest <b style="color:yellow">Shopping Cart</b>';
                            }
                            ?>
                            Items:<?php total_cart_items(); ?> Price:<?php total_price(); ?> <a href="cart.php" style="color:orange">Goto Cart</a>
                        </span>
                    </div>

                    <form action="customer_register.php" method="post" enctype="multipart/form-data">
                        <table align="center" width="750">
                            <tr align="center">
                                <td colspan="4"><h2>Create an Account</h2></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Name:</b></td>
                                <td><input type="text" name="c_name" required></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Email:</b></td>
                                <td><input type="email" name="c_email" required></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Password:</b></td>
                                <td><input type="password" name="c_pass" required></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Address</b></td>
                                <td><input type="text" name="c_address" required></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Image:</b></td>
                                <td><input type="file" name="c_image"></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Country</b></td>
                                <td>
                                    <select name="c_country">
                                        <option>Select a Country</option>
                                        <option>Afganisthan</option>
                                        <option>India</option>
                                        <option>Japan</option>
                                        <option>China</option>
                                        <option>Isreal</option>
                                        <option>Myanmar</option>
                                        <option>Nepal</option>
                                        <option>Bangladesh</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td align="right"><b>City:</b></td>
                                <td><input type="text" name="c_city" required></td>
                            </tr>

                            <tr>
                                <td align="right"><b>Contact:</b></td>
                                <td><input type="text" name="c_contact" required></td>
                            </tr>

                            <tr align="center">
                                <td colspan="4"><input class="btn btn-primary" type="submit" name="register" value="Create Account" /></td>
                            </tr>

                        </table>
                    </form>

                    <div id="footer">
                        <h2 style="text-align:center;padding-top:30px;">&copy;</h2>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


<?php
    if (isset($_POST['register'])) {
        $c_ip = getIp();

        $c_name = $_POST['c_name']; 
        if(preg_match("/^[a-z A-Z]+$/", $c_name) != 1){
            echo '<script>alert("invalid symbol found")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>"; 
            exit;
        }

        $c_email = filter_input(INPUT_POST, 'c_email',FILTER_SANITIZE_EMAIL);
        if(!filter_var($c_email,FILTER_VALIDATE_EMAIL)){
            echo '<script>alert("not a  valid email")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>";  
            exit;          
        }
        $check_email = "SELECT * FROM customer WHERE customer_email='$c_email'";
        $check_run = mysqli_query($con,$check_email);
        $check_rows = mysqli_num_rows($check_run);
        if($check_rows != 0){
            echo '<script>alert("email already exists")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>";
            exit;
        }

        $c_pass = md5($_POST['c_pass']);

        $c_address = $_POST['c_address'];
        if(preg_match("/^[a-zA-Z0-9 ']+$/", $c_address) != 1){
            echo '<script>alert("invalid address")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>"; 
            exit;
        }
        $c_address = mysqli_real_escape_string($con,$c_address);

        $c_image = $_FILES['c_image']['name'];
        $c_image_temp = $_FILES['c_image']['tmp_name'];
        $c_country = $_POST['c_country'];

        $c_city = $_POST['c_city'];
        if(preg_match("/^[a-zA-Z ']+$/", $c_name) != 1){
            echo '<script>alert("invalid city")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>"; 
            exit;
        }
        $c_city = mysqli_real_escape_string($con,$c_city);

        $c_contact = filter_input(INPUT_POST, 'c_contact',FILTER_SANITIZE_NUMBER_INT);
        if(!filter_var($c_contact,FILTER_VALIDATE_INT)){
            echo '<script>alert("not a  valid phone number")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>";   
            exit;
        }

        $check_image = getimagesize($c_image_temp);
        if($check_image == false){
            echo '<script>alert("not an image")</script>';
            echo "<script>window.open('customer_register.php','_self')</script>";
            exit;
        }

        move_uploaded_file($c_image_temp, "customer/customer_images/$c_image");

        $insert_query = "INSERT INTO customer (customer_ip,customer_name,customer_email,customer_pass,customer_address,customer_country,customer_city,customer_contact,customer_image) VALUES ('$c_ip','$c_name','$c_email','$c_pass','$c_address','$c_country','$c_city','$c_contact','$c_image')";
        $run_insert = mysqli_query($con, $insert_query);

        $select_cart = "SELECT * FROM cart WHERE ip_add='$c_ip'";
        $run_cart = mysqli_query($con, $select_cart);

        $check_cart = mysqli_num_rows($run_cart);

        if ($check_cart == 0) {
            $_SESSION['customer_email'] = $c_email;
            echo '<script>alert("Registration is Successful")</script>';
            echo "<script>window.open('customer/my_account.php','_self')</script>";
        } else {
            $_SESSION['customer_email'] = $c_email;
            echo '<script>alert("Registration is Successful")</script>';
            echo "<script>window.open('checkout.php','_self')</script>";
        }
    }
?>
