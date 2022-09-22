<?php include('./partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Update Password</h1>
    <br>
    <?php
        if(isset($_SESSION['password_not_matched'])){
            echo $_SESSION['password_not_matched'];
            unset($_SESSION['password_not_matched']);
        }
    ?>
    <?php
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
    ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password:</td>
                    <td><input type="password" name="current_password" placeholder="current password" class="input-text"></td>
                </tr>
                <tr>
                    <td>New password:</td>
                    <td><input type="password" name="new_password" placeholder="new password" class="input-text"></td>
                </tr>
                <tr>
                    <td>Confirm password:</td>
                    <td><input type="password" name="confirm_password" class="input-text"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //check if the submit button is pressed or not
    if(isset($_POST['submit']) == TRUE){
        //get form data
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //check if the id and current password matches
        $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

        //execute the query
        $res = mysqli_query($connection, $sql);

        if($res == true){
            $count = mysqli_num_rows($res);

            if($count == 1){

                if($new_password == $confirm_password){
                    $update_sql = "UPDATE tbl_admin SET password='$new_password' WHERE id='$id'";
                    $res = mysqli_query($connection, $update_sql);
                    if($res == TRUE) {
                        $_SESSION['password_update'] = "<div class='success'>password updated successfully!</div>";
                        header('location:'.SITEURL.'admin/manage-admin');
                    }else{
                        $_SESSION['password_update'] = "<div class='error'>password updated failed!</div>";
                        header('location:'.SITEURL.'admin/manage-admin');
                    }
                }else{
                    $_SESSION['password_not_matched'] = "<div class='error'>password not matched!</div>";
                    header('location:'.SITEURL.'admin/update-password');
                }

            }else{
                $_SESSION['user_not_found'] = "<div class='error'>user not found</div>";
                header('location:'.SITEURL.'admin/manage-admin');
            }
        }


    }

    


    //check if the new password and confirm password matches

    //save new password if all above is true
?>

<?php include('./partials/footer.php') ?>