<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Add Category</h1>
        <br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>
        <br>
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-40">
                <tr>
                    <td>Title:</td>
                    <td><input type="text" name="title"></td>
                </tr>

                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image"></td>
                </tr>
                <tr>
                    <td>Featured:</td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>
                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
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
        $title = $_POST['title'];

        if(isset($_POST['featured'])){
            $featured = $_POST['featured'];
        }else{
            $featured = 'No';
        }

        if(isset($_POST['active'])){
            $active = $_POST['active'];
        }else{
            $active = 'No';
        }

        if(isset($_FILES['image']['name']))
        {
            //upload the image
            //to upload image we need image name, source path, destination path
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
                    header("location:".SITEURL.'admin/add-category.php');

                    die();
                }
            }

        }else{
            $image_name = '';
        }

        $sql = "INSERT INTO tbl_category SET 
        title = '$title',
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'";

        $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        if($res == TRUE){
            // echo "data inserted";

            //adding session for showing admin insert message
            $_SESSION['add'] = '<div class="success">Category is added successfully!</div>';

            //rediection to manage admin
            header("location:".SITEURL.'admin/manage-category.php');
        }else{
            // echo "error inserting data";

            // adding session for showing admin insert failed message
            $_SESSION['add'] = '<div class="error">failed to add Category</div>';

            // rediection to add admin
            header("location:".SITEURL.'admin/add-category.php');
        }
    }
?>
