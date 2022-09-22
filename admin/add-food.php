<?php include('./partials/menu.php') ?>
<!-- Main content starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
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
                    <td><input type="text" name="title" class="input-text"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5">
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" class="input-text"></td>
                </tr>
                <tr>
                    <td>Category:</td>  
                    <td>
                        <select name="category" class="input-text">
                            <?php
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res = mysqli_query($connection, $sql);

                                $count = mysqli_num_rows($res);

                                if($count > 0){
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>
                                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else{
                                    ?>
                                        <option value="0">No category found</option>
                                    <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td><input type="file" name="image" class="input-text"></td>
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
                        <input type="submit" name="submit" value="Add New Food" class="btn-secondary mt-10">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('./partials/footer.php') ?>

<?php 
    //checking whether submit button is clicked or not

    if(isset($_POST['submit'])){
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];

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
            //now to get the image name
            $image_name = $_FILES['image']['name']; 

            if($image_name != ""){
                //auto rename
                //get the extension first
                $ext = end(explode('.', $image_name));
                $image_name = "Food_Name".rand(000, 999).'.'.$ext;

                $source_path = $_FILES['image']['tmp_name'];

                $destination_path = "../images/food/".$image_name;

                //upload
                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload == false){
                    // adding session for showing admin insert failed message
                    $_SESSION['upload'] = '<div class="error">failed to upload image!</div>';

                    // rediection to add admin
                    header("location:".SITEURL.'admin/add-food');

                    die();
                }
            }

        }else{
            $image_name = '';
        }

        $sql = "INSERT INTO tbl_food SET 
        title = '$title',
        description = '$description',
        price = $price,
        category_id = $category,
        image_name = '$image_name',
        featured = '$featured',
        active = '$active'";

        $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));

        if($res == TRUE){
            // echo "data inserted";

            //adding session for showing admin insert message
            $_SESSION['add'] = '<div class="success">New Food is added successfully!</div>';

            //rediection to manage admin
            header("location:".SITEURL.'admin/manage-food.php');
        }else{
            // echo "error inserting data";

            // adding session for showing admin insert failed message
            $_SESSION['add'] = '<div class="error">failed to add Category</div>';

            // rediection to add admin
            header("location:".SITEURL.'admin/add-food.php');
        }
    }
?>
