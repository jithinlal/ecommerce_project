<?php

    session_start();
    if(!isset($_SESSION['user_email'])){
        echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
    }
    else{
?>
<!DOCTYPE html>
<?php include 'includes/db.php'; ?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Inserting Product</title>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    </head>
    <body bgColor="skyblue">
        <form action="insert_product.php" method="post" enctype="multipart/form-data">
            <table align="center" width="795" height="600" border="2px" bgColor="white">
                <tr align="center">
                    <td colspan="8"><h2>INSERT</h2></td>
                </tr>

                <tr align="left">
                    <td><b>Product Title:</b></td>
                    <td>
                        <input type="text" name="product_title" size="50" required>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Category:</b></td>
                    <td>
                        <select name="product_cat" required>
                            <option>Select Category</option>
                            <?php
                                $get_cats = "SELECT * FROM categories";
                                $run_cats = mysqli_query($con, $get_cats);

                                while ($row_cats = mysqli_fetch_array($run_cats)) {
                                    $cat_id = $row_cats['cat_id'];
                                    $cat_title = $row_cats['cat_title'];

                                    echo "<option value='$cat_id'>$cat_title</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Brand:</b></td>
                    <td>
                        <select name="product_brand" required>
                            <option>Select Brand</option>
                            <?php
                                $get_brands = "SELECT * FROM brands";
                                $run_brands = mysqli_query($con, $get_brands);

                                while ($row_brands = mysqli_fetch_array($run_brands)) {
                                    $brand_id = $row_brands['brand_id'];
                                    $brand_title = $row_brands['brand_title'];

                                    echo "<option value='$brand_id'>$brand_title</option>";
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Image:</b></td>
                    <td>
                        <input type="file" name="product_image" required>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Description:</b></td>
                    <td>
                        <textarea name="product_desc" rows="2" cols="30"></textarea>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Price:</b></td>
                    <td>
                        <input type="number" name="product_price" required>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Keywords:</b></td>
                    <td>
                        <input type="text" name="product_keywords" size="50" required>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="8px">
                        <input type="submit" name="insert_post" value="Insert New">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>


<?php

    if (isset($_POST['insert_post'])) {
        $product_title=$_POST['product_title'];
        if(preg_match("/^[a-zA-Z0-9 ']+$/", $product_title) != 1){
            echo '<script>alert("invalid title name")</script>';
            echo "<script>window.open('insert_product.php','_self')</script>"; 
            exit;
        }
        $product_title = mysqli_real_escape_string($con,$product_title);

        $product_cat=$_POST['product_cat'];
        $product_brand=$_POST['product_brand'];
        $product_desc=$_POST['product_desc'];        
        $product_desc = mysqli_real_escape_string($con,$product_desc);

        $product_price=$_POST['product_price'];
        if(!filter_var($product_price,FILTER_VALIDATE_INT)){
            echo '<script>alert("not a  valid number")</script>';
            echo "<script>window.open('insert_product.php','_self')</script>";
            exit;            
        }

        $product_keywords=$_POST['product_keywords'];
        if(preg_match("/^[a-zA-Z0-9 ,.']+$/", $product_keywords) != 1){
            echo '<script>alert("invalid keyword insertion")</script>';
            echo "<script>window.open('insert_product.php','_self')</script>"; 
            exit;
        }
        $product_keywords = mysqli_real_escape_string($con,$product_keywords);

        $product_image=$_FILES['product_image']['name'];
        $product_image_tmp=$_FILES['product_image']['tmp_name'];

        $check_image = getimagesize($product_image_tmp);
        if($check_image == false){
            echo '<script>alert("not an image")</script>';
            echo "<script>window.open('insert_product.php','_self')</script>";
            exit;
        }

        move_uploaded_file($product_image_tmp, __DIR__."/product_images/$product_image");

        $insert_product = "INSERT INTO products (product_cat,product_brand,product_title,product_price,product_desc,product_image,product_keywords) VALUES ('$product_cat','$product_brand','$product_title',$product_price,'$product_desc','$product_image','$product_keywords')";
        echo $insert_product;exit;
        $insert_pro = mysqli_query($con, $insert_product);

        if ($insert_pro) {
            echo "<script>alert('Product have been inserted')</script>";
            echo "<script>window.open('index.php?insert_product','_self')</script>";
        }
    }
}
 ?>
