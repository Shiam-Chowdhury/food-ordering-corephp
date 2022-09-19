<?php 
    include('../config/constants.php');
    echo "delete category";

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //get id of admin to be deleted
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){
            $path = "../images/category/".$image_name;
            $remove = unlink($path);

            if($remove == false)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
                header("location:".SITEURL."admin/manage-category.php");
                die(); //to stop the process
            }
        }

        //delete query
        $sql = "DELETE FROM tbl_category where id=$id";

        //query execution
        $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));
        if($res == TRUE){
            //adding success message in session
            $_SESSION['delete'] = '<div class="success">category deleted successfully!</div>';

            //redirect to manage admin page
            header("location:".SITEURL.'admin/manage-category.php');

        }else{
            $_SESSION['delete-failed'] = 'failed to delete category!';

            //redirect to manage admin page
            header("location:".SITEURL.'admin/manage-category.php');
        }
    }else{
        //redirect to manage category
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>