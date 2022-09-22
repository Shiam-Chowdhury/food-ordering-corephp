<?php include('./partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br>
        <?php
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        <br>
        <?php
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                $sql = "SELECT * FROM tbl_order where id=$id";
                $res = mysqli_query($connection, $sql);
                if($res == TRUE){
                    //check whether data is available or not
                    $count = mysqli_num_rows($res);
                    if($count == 1){
                        $row = mysqli_fetch_assoc($res);
                        $food = $row['food'];
                        $price = $row['price'];
                        $quantity = $row['quantity'];
                        $status = $row['status'];
                        $customer_name = $row['customer_name'];
                        $customer_contact = $row['customer_contact'];
                        $customer_email = $row['customer_email'];
                        $customer_address = $row['customer_address'];
                    }else{
                        $_SESSION['no-category-found'] = "<div class='error'>no category found</div>";
                        header("location:".SITEURL."admin/manage-category.php");
                    }
                }
            }else{
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-40">
                <tr>
                    <td>Food:</td>
                    <td><?php echo $food; ?></td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><?php echo $price; ?></td>
                </tr>
                <tr>
                    <td>Quantity:</td>
                    <td><input type="number" name="quantity" value="<?php echo $quantity;?>" class="input-text"></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status == 'Ordered'){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status == 'On delivery'){echo "On delivery";} ?> value="On delivery">On delivery</option>
                            <option <?php if($status == 'Delivered'){echo "Delivered";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status == 'Cancelled'){echo "Cancelled";} ?> value="Cancelled">Cancel</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name;?>" class="input-text">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact;?>" class="input-text">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email;?>" class="input-text">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <input type="text" name="customer_address" value="<?php echo $customer_address;?>" class="input-text">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $total = $quantity*$price;
        $status = $_POST['status'];
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email= $_POST['customer_email'];
        $customer_address = $_POST['customer_address'];

        //update the database
        $sql2 = "UPDATE tbl_order SET
                quantity='$quantity',
                total='$total',
                status='$status',
                customer_name='$customer_name',
                customer_contact='$customer_contact',
                customer_email='$customer_email',
                customer_address='$customer_address'
                WHERE id=$id
                ";

        //executing the query
        $res2 = mysqli_query($connection, $sql2);

        if($res2 == true){
            $_SESSION['update'] = "<div class='success'>Order updated successfully!</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
        }else{
            $_SESSION['update'] = "<div class='error'>Order update failed!</div>";
            header('location:'.SITEURL.'admin/manage-order.php');
        }
    }
?>

<?php include('./partials/footer.php') ?>
