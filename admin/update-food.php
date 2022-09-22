<?php include('./partials/menu.php') ?>

<?php
    $id = $_GET['id'];

    $sql = "SELECT * FROM tbl_food where id=$id";

    $res = mysqli_query($connection, $sql);

    if($res == TRUE){
        //check whether data is available or not
        $count = mysqli_num_rows($res);

        if($count == 1){
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $description = $row['description'];
            $price = $row['price'];
            $current_category = $row['category_id'];
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
                    <td><input type="text" name="title" value="<?php echo $title;?>" class="input-text"></td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5">
                            <?php echo $description;?>
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td><input type="number" name="price" value="<?php echo $price;?>" class="input-text"></td>
                </tr>
                <tr>
                    <td>Current Image:</td>
                    <td>
                        <?php
                            if($current_image != ''){
                                ?>
                                    <img 
                                        width="100px" 
                                        src="<?php echo SITEURL; ?>images/food/<?php echo $current_image;?>"
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
                    <td>Category:</td>  
                    <td>
                        <select name="category" class="input-text">
                            <?php
                                $sql2 = "SELECT * FROM tbl_category WHERE active='Yes'";

                                $res2 = mysqli_query($connection, $sql2);

                                $count = mysqli_num_rows($res2);

                                if($count > 0){
                                    while($row = mysqli_fetch_assoc($res2))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>
                                            <option <?php if($current_category == $id){echo "selected";} ?> value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $current_image = $_POST['current_image'];
        $category_id = $_POST['category'];
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
                $image_name = "Food_Name".rand(000, 999).'.'.$ext;
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/food/".$image_name;
                //upload
                $upload = move_uploaded_file($source_path, $destination_path);
                if($upload == false){
                    // adding session for showing admin insert failed message
                    $_SESSION['upload'] = '<div class="error">failed to upload image!</div>';
                    // rediection to add admin
                    header("location:".SITEURL.'admin/manage-food.php');
                    die();
                }
                if($current_image != "")
                {
                    //remove current image
                    $remove_path = "../images/food/".$current_image;
                    $remove = unlink($remove_path);
                    if($remove == false){
                        $_SESSION['failed-remove'] = '<div class="error">failed to remove current image!</div>';
                        header("location:".SITEURL.'admin/manage-food.php');
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
        $food_update_query = "UPDATE tbl_food SET
                title='$title',
                description='$description',
                price='$price',
                image_name='$image_name',
                category_id='$category_id',
                featured='$featured',
                active='$active'
                WHERE id=$id
                ";
        
        // echo $sql3;
        // print_r($connection) ;
        // die();

        //executing the query
        $res3 = mysqli_query($connection, $food_update_query);

        if($res3 == true){
            $_SESSION['update'] = "<div class='success'>Food updated successfully!</div>";
            header('location:'.SITEURL.'admin/manage-food');
        }else{
            $_SESSION['update'] = "<div class='error'>Food update failed!</div>";
            header('location:'.SITEURL.'admin/manage-food');
        }
    }
?>

<?php include('./partials/footer.php') ?>
