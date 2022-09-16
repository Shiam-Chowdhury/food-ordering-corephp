<?php 
    include('../config/constants.php');
    echo "delete admin";

    //get id of admin to be deleted
    $id = $_GET['id'];

    // echo $id;
    //delete query
    $sql = "DELETE FROM tbl_admin where id=$id";

    //query execution
    $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));
    if($res == TRUE){
        //adding success message in session
        $_SESSION['delete'] = 'admin deleted successfully!';

        //redirect to manage admin page
        header("location:".SITEURL.'admin/manage-admin.php');

    }else{
        $_SESSION['delete-failed'] = 'failed to delete admin!';

        //redirect to manage admin page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
?>