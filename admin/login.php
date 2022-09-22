<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
    <div class="login">
        <h1 class="text-center">Login</h1><br>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <form action="" method="POST" class="text-center">
            username: <br>
            <input type="text" name="username" placeholder="type username" class="input-text"> <br><br>
            password: <br>
            <input type="password" name="password" placeholder="type password" class="input-text"> <br><br>
            <input type="submit" name="submit" value="Login" class="btn-primary">
            <br>
        </form>
        <p></p>
    </div>
</body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        // $username = $_POST['username'];
        // $password = md5($_POST['password']);

        $username = mysqli_real_escape_string($connection,$_POST['username']);
        $password = md5($_POST['password']);

        // echo $username , $password;

        //sql query to check user existence
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        $res = mysqli_query($connection, $sql);

        $count = mysqli_num_rows($res);

        echo $count;

        if($count == 1){
            $_SESSION['login'] = "<div class='success'>Login successfully!</div>";
            $_SESSION['user'] = $username;
            //rediection to manage admin
            header("location:".SITEURL.'admin/dashboard');
        }else{
            $_SESSION['login'] = "<div class='error text-center'>username or password not matched!</div>";

            //rediection to manage admin
            header("location:".SITEURL.'admin/login');
        }
    }
?>