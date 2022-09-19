<?php
    //Authorization access control
    //check if user is logged in or not
    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message'] = "<div class='error text-center'>please login to access admin panel</div>";

        header('location:'.SITEURL.'admin/login.php');
    }
?>