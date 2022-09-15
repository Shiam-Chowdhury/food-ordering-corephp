<?php
    session_start();

    define('SITEURL', 'http://localhost/php-project/food-order/');
    define('LOCALHOST','localhost');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','food-order');

    $connection = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
    $db_select = mysqli_select_db($connection, DB_NAME) or die(mysqli_error($connection));
?>