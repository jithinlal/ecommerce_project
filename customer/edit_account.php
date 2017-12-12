<?php
    session_start();
    include('includes/db.php');
    
    if(!isset($_SESSION['customer_email'])){
     echo "<script>window.open('customer.php','_self')</script>";
    }else{
        $customer = $_SESSION['customer_email'];
        $customer_query = "SELECT * FROM customer WHERE customer_email='$customer'";
        $res_customer = mysqli_query($con,$customer_query);

        $res_row = mysqli_fetch_array($res_customer);

        $c_id = $res_row['customer_id'];
        $c_name = $res_row['customer_name'];
        $c_email = $customer;
        $c_address = $res_row['customer_address'];
        $c_city = $res_row['customer_city'];
        $custom_image = $res_row['customer_image'];
        $c_country = $res_row['customer_country'];
        $c_contact = $res_row['customer_contact'];
?>

    <form action="" method="post" enctype="multipart/form-data">
        <table align="center" width="750">
            <tr align="center">
                <td colspan="4"><h2>Update your Account</h2></td>
            </tr>

            <tr>
                <td align="right"><b>Name:</b></td>
                <td><input type="text" name="c_name" value="<?php echo $c_name; ?>" required></td>
            </tr>

            <tr>
                <td align="right"><b>Email:</b></td>
                <td><input type="text" name="c_email" value="<?php echo $c_email; ?>" required></td>
            </tr>

            <tr>
                <td align="right"><b>Address</b></td>
                <td><input type="text" name="c_address" value="<?php echo $c_address; ?>" required></td>
            </tr>

            <tr>
                <td align="right"><b>Image:</b></td>
                <td><input type="file" name="c_image"><img src="customer_images/<?php echo $custom_image; ?>" width="50" height="50" /></td>
            </tr>

            <tr>
                <td align="right"><b>Country</b></td>
                <td>
                    <select name="c_country" disabled>
                        <option><?php echo $c_country; ?></option>
                        <option value="Afganisthan">Afganisthan</option>
                        <option value="India">India</option>
                        <option value="Japan">Japan</option>
                        <option value="China">China</option>
                        <option value="Isreal">Isreal</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Bangladesh">Bangladesh</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td align="right"><b>City:</b></td>
                <td><input type="text" name="c_city" value="<?php echo $c_city; ?>" required></td>
            </tr>

            <tr>
                <td align="right"><b>Contact:</b></td>
                <td><input type="text" name="c_contact" value="<?php echo $c_contact; ?>" required></td>
            </tr>

            <tr align="center">
                <td colspan="4"><input type="submit" name="update" value="Update Account" /></td>
            </tr>

        </table>
    </form>

<?php
    if (isset($_POST['update'])) {
        $c_ip = getIp();
        $c_name = $_POST['c_name'];
        if(preg_match("/^[a-z A-Z]+$/", $c_name) != 1){
            echo '<script>alert("invalid symbol found")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>"; 
            exit;
        }

        $c_email = filter_input(INPUT_POST, 'c_email',FILTER_SANITIZE_EMAIL);
        if(!filter_var($c_email,FILTER_VALIDATE_EMAIL)){
            echo '<script>alert("not a  valid email")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>";  
            exit;          
        }
        $check_email = "SELECT * FROM customer WHERE customer_email='$c_email'";
        $check_run = mysqli_query($con,$check_email);
        $check_rows = mysqli_num_rows($check_run);
        if($check_rows != 0){
            echo '<script>alert("email already exists")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>";
            exit;
        }

        $c_address = $_POST['c_address'];
        if(preg_match("/^[a-zA-Z0-9 ']+$/", $c_address) != 1){
            echo '<script>alert("invalid address")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>"; 
            exit;
        }
        $c_address = mysqli_real_escape_string($con,$c_address);

        $c_image = $_FILES['c_image']['name'];
        $c_image_temp = $_FILES['c_image']['tmp_name'];
        $c_country = $_POST['c_country'];
        $c_city = $_POST['c_city'];
        if(preg_match("/^[a-zA-Z ']+$/", $c_name) != 1){
            echo '<script>alert("invalid city")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>"; 
            exit;
        }
        $c_city = mysqli_real_escape_string($con,$c_city);

        $c_contact = filter_input(INPUT_POST, 'c_contact',FILTER_SANITIZE_NUMBER_INT);
        if(!filter_var($c_contact,FILTER_VALIDATE_INT)){
            echo '<script>alert("not a  valid phone number")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>";   
            exit;
        }

        $check_image = getimagesize($c_image_temp);
        if($check_image == false){
            echo '<script>alert("not an image")</script>';
            echo "<script>window.open('edit_account.php','_self')</script>";
            exit;
        }

        move_uploaded_file($c_image_temp, "customer_images/$c_image");

        if($c_image == ''){
            $c_image = $custom_image;
        }

        $update_query = "UPDATE customer SET customer_name='$c_name', customer_email='$c_email',customer_address='$c_address',customer_city='$c_city',customer_contact='$c_contact',customer_image='$c_image' WHERE customer_id=$c_id";
        $run_update = mysqli_query($con, $update_query);

        if ($run_update) {
            echo '<script>alert("Updation is Successful")</script>';
            echo "<script>window.open('my_account.php','_self')</script>";
        }
    }
}
?>
