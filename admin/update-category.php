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
                                    <img 
                                        width="100px" 
                                        src="<?php echo SITEURL; ?>images/category/<?php echo $current_image;?>"
                                    >
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
        $title = $_POST['title'];
        $current_image = $_POST['current_image'];
        $featured = $_POST['featured'];
        $active = $_POST['active'];

        //update new image if selected
        if(isset($_FILES['image']['name']))
        {
            $image_name = $_FILES['image']['name']; 

            if($image_name != ""){
                //auto rename
                //get the extension first
                $ext = end(explode('.', $image_name));
                $image_name = "Food_Category".rand(000, 999).'.'.$ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/".$image_name;
                //upload
                $upload = move_uploaded_file($source_path, $destination_path);
                if($upload == false){
                    // adding session for showing admin insert failed message
                    $_SESSION['upload'] = '<div class="error">failed to upload image!</div>';
                    // rediection to add admin
                    header("location:".SITEURL.'admin/manage-category.php');
                    die();
                }
                if($current_image != "")
                {
                    //remove current image
                    $remove_path = "../images/category/".$current_image;
                    $remove = unlink($remove_path);
                    if($remove == false){
                        $_SESSION['failed-remove'] = '<div class="error">failed to remove current image!</div>';
                        header("location:".SITEURL.'admin/manage-category.php');
                        die();
                    }
                }
            }else{
                $image_name = $current_image;
            }
        }else{
            $image_name = $current_image;
        }

        //update the database
        $sql2 = "UPDATE tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";

        //executing the query
        $res2 = mysqli_query($connection, $sql2);

        if($res2 == true){
            $_SESSION['update'] = "<div class='success'>Category updated successfully!</div>";
            header('location:'.SITEURL.'admin/manage-category');
        }else{
            $_SESSION['update'] = "<div class='error'>Category update failed!</div>";
            header('location:'.SITEURL.'admin/manage-category');
        }
    }
?>

<?php include('./partials/footer.php') ?>
