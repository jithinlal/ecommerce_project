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
                            Items:<?php total_cart_items(); ?> Price:<?php total_price(); ?> <a href="cart.php" style="color:orange">Goto Cart</a>
                        </span>
                    </div>
                    <div class="products_box">
                        <?php
                            $get_pro = "SELECT * FROM products";
                            $run_pro = mysqli_query($con, $get_pro);

                            while ($row_pro = mysqli_fetch_array($run_pro)) {
                                $pro_id = $row_pro['product_id'];
                                $pro_cat = $row_pro['product_cat'];
                                $pro_brand = $row_pro['product_brand'];
                                $pro_title = $row_pro['product_title'];
                                $pro_price = $row_pro['product_price'];
                                $pro_image = $row_pro['product_image'];

                                echo '
                                    <div id="single_product">
                                        <h3>'.$pro_title.'</h3>
                                        <img src="admin_area/product_images/'.$pro_image.'" width="180" height="180"/>
                                        <p><b>USD : <mark>'.$pro_price.'</mark></b></p>
                                        <a class="btn btn-info btn-sm" href="details.php?pro_id='.$pro_id.'" style="float:left">Details</a>
                                        <a class="btn btn-success btn-sm" href="index.php?add_cart='.$pro_id.'" style="float:right">Add to Cart</a>
                                    </div>
                                ';
                            }
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
