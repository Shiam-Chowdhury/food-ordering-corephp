<?php 
    // echo "delete food";
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //get id of admin to be deleted
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        if($image_name != ""){
            $path = "../images/category/".$image_name;
            $remove = unlink($path);

            if($remove == false)
            {
                $_SESSION['remove'] = "<div class='error'>Failed to remove food image</div>";
                header("location:".SITEURL."admin/manage-food.php");
                die(); //to stop the process
            }
        }

        //delete query
        $sql = "DELETE FROM tbl_food where id=$id";

        //query execution
        $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));
        if($res == TRUE){
            //adding success message in session
            $_SESSION['delete'] = '<div class="success">food deleted successfully!</div>';

            //redirect to manage admin page
            header("location:".SITEURL.'admin/manage-food.php');

        }else{
            $_SESSION['delete-failed'] = 'failed to delete food!';

            //redirect to manage admin page
            header("location:".SITEURL.'admin/manage-food.php');
        }
    }else{
        $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>