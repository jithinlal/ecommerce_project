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
                            Items:<?php total_cart_items(); ?> Price:<?php total_price(); ?> <a class="btn btn-outline-warning" href="cart.php">Goto Cart</a>
                        </span>
                    </div>
                    <div class="products_box">
                        <?php
                        if (!isset($_SESSION['customer_email'])) {
                            include('customer_login.php');
                        } else {
                            include('payment.php');
                        }
                        ?>
                    </div>
                    <div id="footer">
                        <h2 style="text-align:center;padding-top:30px;">&copy;</h2>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
