<?php include('./partials/menu.php') ?>

<?php
    $id = $_GET['id'];

    $sql = "SELECT * FROM tbl_admin where id=$id";

    $res = mysqli_query($connection, $sql);

    if($res == TRUE){
        //check whether data is available or not
        $count = mysqli_num_rows($res);

        if($count == 1){
            $row = mysqli_fetch_assoc($res);
            $fullname = $row['fullname'];
            $username = $row['username'];
        }
    }
?>

<div class="main-content">
    <div class="wrapper">
    <h1>Update Admin</h1>
        <br>
        <p class="error">
            <?php
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
            ?>
        </p>
        <br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="fullname" class="input-text" value="<?php echo $fullname;?>"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" class="input-text" value="<?php echo $username;?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <div class="clearfix"></div>
    </div>
</div>

<?php 
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $fullname = $_POST['fullname'];
        $username = $_POST['username'];

        $sql = "UPDATE tbl_admin SET fullname='$fullname', username='$username' WHERE id='$id'";

        $res = mysqli_query($connection, $sql);

        if($res == true){
            $_SESSION['update'] = "<div class='success'>Admin updated successfully!</div>";
            header('location:'.SITEURL.'admin/manage-admin');
        }else{
            $_SESSION['update'] = "<div class='error'>Admin update failed!</div>";
            header('location:'.SITEURL.'admin/manage-admin');
        }
    }
?>

<?php include('./partials/footer.php') ?>
