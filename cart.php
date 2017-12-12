<!DOCTYPE html>
<?php
    session_start();
    include('functions/functions.php');
    include('includes/view.php');
?>
                <div id="content_area">
                    <div id="shopping_cart">
                        <span style="float:right;font-size:18px;padding:5px;line-height:40px;">
                            <?php
                            if (isset($_SESSION['customer_email'])) {
                                echo 'Welcome <b>'.$_SESSION['customer_email'].'</b> <b style="color:yellow">Shopping Cart</b>';
                            } else {
                                echo 'Welcome Guest <b style="color:yellow">Shopping Cart</b>';
                            }
                            ?>
                            Items:<?php total_cart_items(); ?> Price:<?php total_price(); ?> <a href="index.php" class="btn btn-outline-primary">Back to Shop</a>
                            <?php
                            if (!isset($_SESSION['customer_email'])) {
                                echo '<a class="btn btn-success" role="button" href="checkout.php">Login</a>';
                            } else {
                                echo '<a class="btn btn-danger" role="button" href="logout.php">Logout</a>';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="products_box">
                        <br>
                        <form action="" method="post" enctype="multipart/form-data">
                            <table align="center" width="800" class="table table-hover">
                                <thead>
                                    <tr align="center" bgcolor="skyblue">
                                        <th>Remove</th>
                                        <th>Product(s)</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                                $values = array_sum($product_price);

                                                $product_title = $pro_price['product_title'];
                                                $product_image = $pro_price['product_image'];
                                                $single_price = $pro_price['product_price'];
                                                $total += $values * $qty;

                                    ?>

                                    <tr align="center">
                                        <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>"></td>
                                        <td>
                                            <?php echo $product_title; ?><br>
                                            <img src="admin_area/product_images/<?php echo $product_image; ?>" width="60" height="60">
                                        </td>
                                        <td><input type="text" name="qty[]" size="6" value="<?php echo $qty; ?>"></td>
                                        <input type="hidden" name="productId[]" size="6" value="<?php echo $pro_id; ?>">
                                        <td><?php echo "USD ".$single_price; ?></td>
                                    </tr>
                                        <?php } ?>                                            
                                    <?php } ?>                                    

                                        <tr align="right">
                                            <td><input class="btn btn-warning" type="submit" name="update_cart" value="Update Cart"></td>
                                            <td><input class="btn btn-primary" type="submit" name="continue" value="Continue Shopping" /></td>
                                            <td><a class="btn btn-success" role="button" href="checkout.php">Checkout</a></td>
                                            <td><b>Sub Total: <mark><?php echo $total; ?></mark></b></td>
                                        </tr>
                                    </tbody>
                            </table>
                        </form>
                        <?php                            

                            function updateCart()
                            {
                                global $con;
                                $ip = getIp();
                                if (isset($_POST['update_cart'])) {
                                    foreach ($_POST['remove'] as $remove_id) {
                                        $delete_product = "DELETE FROM cart WHERE product_id=$remove_id AND ip_add='$ip'";
                                        $run_delete = mysqli_query($con, $delete_product);

                                        if ($run_delete) {
                                            echo "<script>window.open('cart.php','_self')</script>";
                                        }
                                    }

                                    $i = 0;    
                                    foreach ($_POST['qty'] as $qty) {
                                        $ids = $_POST['productId'][$i];
                                        $update_query = "UPDATE cart SET quantity=$qty WHERE product_id=$ids";
                                        $run_update = mysqli_query($con,$update_query);
                                        $i++;
                                    }

                                    echo "<script>window.open('cart.php','_self')</script>";
                                }

                                if (isset($_POST['continue'])) {
                                    echo "<script>window.open('index.php','_self')</script>";
                                }
                            }
                                echo @$up_cart = updateCart();
                        ?>
                    </div>
                </div>
                <div id="footer">
                    <h2 style="text-align:center;padding-top:30px;">&copy;</h2>
                </div>
            </div>
        </div>
    </body>
</html>
