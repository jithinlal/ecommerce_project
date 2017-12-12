<?php
    
    session_start();
    if(!isset($_SESSION['user_email'])){
        echo "<script>window.open('admin_login.php?not_admin=YOU ARE NOT ADMIN!','_self')</script>";
    }
    else{
        include('includes/db.php');
        if(isset($_GET['edit_pro'])){
            $get_id = $_GET['edit_pro'];

            $get_pro = "SELECT * FROM products WHERE product_id=$get_id";
            $run_pro = mysqli_query($con,$get_pro);
            $row_pro = mysqli_fetch_array($run_pro);

            $pro_id = $row_pro['product_id'];
            $pro_cat = $row_pro['product_cat'];
            $pro_brand = $row_pro['product_brand'];
            $pro_title = $row_pro['product_title'];
            $pro_price = $row_pro['product_price'];
            $pro_desc = $row_pro['product_desc'];
            $pro_image = $row_pro['product_image'];
            $pro_keywords = $row_pro['product_keywords'];

            $brand_query ="SELECT * FROM brands WHERE brand_id=$pro_brand";
            $run_brand = mysqli_query($con,$brand_query);
            $row_brand = mysqli_fetch_array($run_brand);
            $brand_name = $row_brand['brand_title'];

            $cat_query ="SELECT * FROM categories WHERE cat_id=$pro_cat";
            $run_cat = mysqli_query($con,$cat_query);
            $row_cat = mysqli_fetch_array($run_cat);
            $cat_name = $row_cat['cat_title'];
        }
?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Edit a Product</title>
        <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
        <script>tinymce.init({ selector:'textarea' });</script>
    </head>
    <body bgColor="skyblue">
        <form action="" method="post" enctype="multipart/form-data">
            <table align="center" width="795" height="600" border="2px" bgColor="white">
                <tr align="center">
                    <td colspan="8"><h2>EDIT</h2></td>
                </tr>

                <tr align="left">
                    <td><b>Product Title:</b></td>
                    <td>
                        <input type="text" name="product_title" size="50" value="<?php echo $pro_title; ?>" required>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Category:</b></td>
                    <td>
                        <select name="product_cat" required>
                            <option><?php echo $cat_name; ?></option>
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
                            <option><?php echo $brand_name; ?></option>
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
                        <input type="file" name="product_image"><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60" />
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Description:</b></td>
                    <td>
                        <textarea name="product_desc" rows="2" cols="30"><?php echo $pro_desc; ?></textarea>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Price:</b></td>
                    <td>
                        <input type="number" name="product_price" value="<?php echo $pro_price; ?>" required>
                    </td>
                </tr>
                <tr align="left">
                    <td><b>Product Keywords:</b></td>
                    <td>
                        <input type="text" name="product_keywords" size="50" value="<?php echo $pro_keywords; ?>" required>
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="8px">
                        <input type="submit" name="update_product" value="Update Product">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>


<?php

    if (isset($_POST['update_product'])) {
        $product_title=$_POST['product_title'];
        if(preg_match("/^[a-zA-Z0-9 ']+$/", $product_title) != 1){
            echo '<script>alert("invalid title name")</script>';
            echo "<script>window.open('pro_edit.php','_self')</script>"; 
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
            echo "<script>window.open('pro_edit.php','_self')</script>";
            exit;            
        }

        $product_keywords=$_POST['product_keywords'];
        if(preg_match("/^[a-zA-Z0-9 ,.']+$/", $product_keywords) != 1){
            echo '<script>alert("invalid keyword insertion")</script>';
            echo "<script>window.open('pro_edit.php','_self')</script>"; 
            exit;
        }
        $product_keywords = mysqli_real_escape_string($con,$product_keywords);

        $product_image=$_FILES['product_image']['name'];
        $product_image_tmp=$_FILES['product_image']['tmp_name'];
        $check_image = getimagesize($product_image_tmp);
        if($check_image == false){
            echo '<script>alert("not an image")</script>';
            echo "<script>window.open('pro_edit.php','_self')</script>";
            exit;
        }

        move_uploaded_file($product_image_tmp, __DIR__."/product_images/$product_image");

        if($product_image == ''){
            $product_image = $pro_image;
        }
        if(!is_int($product_cat)){
            $product_cat = $pro_cat;
        }
        if(!is_int($product_brand)){
            $product_brand = $pro_brand;
        }

        $update_product = "UPDATE products SET product_cat=$product_cat, product_brand=$product_brand, product_title='$product_title', product_price=$product_price, product_desc='$pro_desc', product_image='$product_image',product_keywords='$product_keywords' WHERE product_id=$pro_id";
        $update_pro = mysqli_query($con, $update_product);

        if ($update_pro) {
            echo "<script>alert('Product have been updated')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }
    }
}
 ?>
