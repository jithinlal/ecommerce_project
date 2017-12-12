<!DOCTYPE html>
<?php
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
                            Items: <?php total_cart_items(); ?> Price: <?php total_price(); ?> <a href="cart.php" style="color:orange">Goto Cart</a>
                        </span>
                    </div>
                    <div class="products_box">
                        <?php
                            if (isset($_GET['pro_id'])) {
                                $product_id = $_GET['pro_id'];
                                $get_pro = "SELECT * FROM products WHERE product_id=$product_id";
                                $run_pro = mysqli_query($con, $get_pro);

                                while ($row_pro = mysqli_fetch_array($run_pro)) {
                                    $pro_id = $row_pro['product_id'];
                                    $pro_title = $row_pro['product_title'];
                                    $pro_price = $row_pro['product_price'];
                                    $pro_image = $row_pro['product_image'];
                                    $pro_desc = $row_pro['product_desc'];

                                    echo '
                                        <div id="single_product">
                                            <h3>'.$pro_title.'</h3>
                                            <img src="admin_area/product_images/'.$pro_image.'" width="400" height="300"/>
                                            <p><b>Rs : '.$pro_price.'</b></p>
                                            <p>'.$pro_desc.'</p>
                                            <a class="btn btn-warning" href="index.php" style="float:left">Go Back</a>
                                            <a class="btn btn-success" role="button" href="index.php?pro_id='.$pro_id.'" style="float:right">Add to Cart</a>
                                        </div>
                                    ';
                                }
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
