<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <p class="error">
            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
            ?>
        </p>
        <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <div class="clearfix"></div>
      </div>
    </div>
    <!-- Main content ends -->

<?php include('./partials/footer.php') ?>

<?php 
    //checking whether submit button is clicked or not

    if(isset($_POST['submit'])){
        $fullname = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $sql = "INSERT INTO tbl_admin SET 
        fullname = '$fullname',
        username = '$username',
        password = '$password'";

        $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        if($res == TRUE){
            // echo "data inserted";

            //adding session for showing admin insert message
            $_SESSION['add'] = 'Admin is added successfully!';

            //rediection to manage admin
            header("location:".SITEURL.'admin/manage-admin');
        }else{
            // echo "error inserting data";

            //adding session for showing admin insert failed message
            $_SESSION['add'] = 'failed to add admin';

            //rediection to add admin
            header("location:".SITEURL.'admin/add-admin');
        }
    }
?>
