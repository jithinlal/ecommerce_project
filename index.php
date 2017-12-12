<!DOCTYPE html>
<?php
    session_start();
    include('functions/functions.php');
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
                             Items:<?php total_cart_items(); ?> Price:<?php total_price(); ?> <a href="cart.php" class="btn btn-outline-primary">Goto Cart</a>
                            <?php
                            if (!isset($_SESSION['customer_email'])) {
                                echo '<a class="btn btn-success" role="button" href="checkout.php">Login</a>';
                            } else {
                                echo '<a href="logout.php" class="btn btn-danger" role="button">Logout</a>';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="products_box">
                        <?php getProducts(); ?>
                        <?php getCategoryProducts(); ?>
                        <?php getBrandProducts() ?>
                    </div>
                    <div id="footer">
                        <h2 style="text-align:center;padding-top:30px;">&copy;</h2>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
