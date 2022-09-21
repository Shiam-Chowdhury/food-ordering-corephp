<?php include('./partials-front/menu.php') ?>
<?php
    if(isset($_GET['category_id']))
    {
        $category_id = $_GET['category_id'];

        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
        $res = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($res);
        $category_title = $row['title'];
    }else{
        header('location:'.SITEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white"><?php echo $category_title; ?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
                $res2 = mysqli_query($connection, $sql2);
                $count2 = mysqli_num_rows($res2);

                if($count2 > 0){
                    while($rows2=mysqli_fetch_assoc($res2))
                    {
                        $id = $rows2['id'];
                        $title = $rows2['title'];
                        $price = $rows2['price'];
                        $description = $rows2['description'];
                        $image_name = $rows2['image_name'];
                        ?>
                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php 
                                        if($image_name != ""){
                                    ?>
                                        <img 
                                            src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" 
                                            alt="<?php echo $title; ?>" 
                                            class="img-responsive img-curve"
                                        >
                                    <?php
                                        }else{
                                            echo "<div class='error'>Image not available</div>";
                                        }
                                    ?>
                                </div>

                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price"><?php echo '$'.$price; ?></p>
                                    <p class="food-detail">
                                        <?php echo $description; ?>
                                    </p>
                                    <br>

                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>
                        <?php
                    }
                }
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <!-- social Section Starts Here -->
    <section class="social">
        <div class="container text-center">
            <ul>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
                </li>
                <li>
                    <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
                </li>
            </ul>
        </div>
    </section>
    <!-- social Section Ends Here -->

<?php include('./partials-front/footer.php') ?>
