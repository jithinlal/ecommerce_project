<!DOCTYPE html>
<?php
    session_start();
    include('functions/functions.php');
    if(!isset($_SESSION['customer_email'])){
        echo "<script>window.open('customer.php','_self')</script>";
    }else{
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>e-Commerce</title>
        <link rel="stylesheet" href="styles/styles.css">
        <link rel="stylesheet" href="styles/mystyles.css">
    </head>
    <body>
        <div class="main_wrapper">
            <div class="header_wrapper">
                <a href="index.php">
                    <img src="images/logo.png" id="logo">
                </a>
                <img src="images/banner.png" id="banner">
            </div>
            <div class="menubar">
                <ul id="menu">
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="my_account.php">My Account</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>

                <div id="form">
                    <form action="results.php" method="get" enctype="multipart/form-data">
                        <input type="text" name="user_query" placeholder="Search a Product">
                        <input type="submit" name="search" value="Search">
                    </form>
                </div>
            </div>
            <div class="content_wrapper">
                <div id="sidebar">
                    <div id="sidebar_title">
                        My Account
                    </div>

                    <ul id="sidebar_contents">
                        <ul id="cats">
                            <?php
                                $user_email = $_SESSION['customer_email'];

                                $get_img = "SELECT * FROM customer WHERE customer_email='$user_email'";
                                $run_img = mysqli_query($con,$get_img);

                                $row_img = mysqli_fetch_array($run_img);
                                $c_img = $row_img['customer_image'];
                                $c_name = $row_img['customer_name'];

                                echo "<p style='text-align:center;'><img src='customer_images/$c_img' width='150' height='150' /></p>";
                            ?>
                            <li><a href="my_account.php?my_orders">My Orders</a></li>
                            <li><a href="my_account.php?edit_account">Edit Account</a></li>
                            <li><a href="my_account.php?change_pass">Change Password</a></li>
                            <li><a href="my_account.php?delete_account">Delete Account</a></li>
                        </ul>
                    </ul>
                </div>

                <div id="content_area">
                    <?php cart(); ?>
                    <div id="shopping_cart">
                        <span style="float:right;font-size:18px;padding:5px;line-height:40px;">
                            <?php
                            if (isset($_SESSION['customer_email'])) {
                                echo 'Welcome <b>'.$_SESSION['customer_email'].'</b>';
                            } else {
                                echo 'Welcome Guest';
                            }
                            ?>
                            <?php
                            if (!isset($_SESSION['customer_email'])) {
                                echo '<a href="#" style="color:green;">Login</a>';
                            } else {
                                echo '<a href="logout.php" style="color:red;">Logout</a>';
                            }
                            ?>
                        </span>
                    </div>
                    <div class="products_box">
						<?php
							if(!isset($_GET['my_orders']) && !isset($_GET['edit_account']) && !isset($_GET['change_pass']) && !isset($_GET['delete_account'])){
                                echo '<h2 style="padding:20px;color:green;">Welcome '.$c_name.'</h2><br />';
								echo '<h3>You can view your orders status from <a href="my_account.php?my_orders" style="text-decoration:none;">here</a></h3><br>';
							}

							if(isset($_GET['edit_account'])){
								include('edit_account.php');
							}

                            if(isset($_GET['change_pass'])){
                                include('change_password.php');
                            }

                            if(isset($_GET['delete_account'])){
                                include('delete_account.php');
                            }
                            
                             if(isset($_GET['my_orders'])){
                                include('my_orders.php');
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

<?php } ?>
