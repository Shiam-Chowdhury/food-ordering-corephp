<?php include('./partials/menu.php') ?>

<?php
    $id = $_GET['id'];

    $sql = "SELECT * FROM tbl_category where id=$id";

    $res = mysqli_query($connection, $sql);

    if($res == TRUE){
        //check whether data is available or not
        $count = mysqli_num_rows($res);

        if($count == 1){
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $current_image = $row['image_name'];
            $featured = $row['featured'];
            $active = $row['active'];
        }else{
            $_SESSION['no-category-found'] = "<div class='error'>no category found</div>";
            header("location:".SITEURL."admin/manage-category.php");
        }
    }
?>

<div class="main-content">
    <div class="wrapper">
    <h1>Update Category</h1>
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
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-40">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title" value="<?php echo $title;?>"></td>
                </tr>

                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != ''){
                                ?>
                                    <img width="100px" src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>">
                                <?php
                            }else{
                                echo "<div class='error'>Image not added</div>";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured:</td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
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
            header('location:'.SITEURL.'admin/manage-admin.php');
        }else{
            $_SESSION['update'] = "<div class='error'>Admin update failed!</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>

<?php include('./partials/footer.php') ?>
