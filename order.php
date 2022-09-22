<?php include('./partials-front/menu.php') ?>

    <?php 
        if(isset($_GET['food_id']))
        {
            $food_id = $_GET['food_id'];
    
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            $res = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($res);
            if($count == 1){
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }else{
                header('location:'.SITEURL);
            }
            $category_title = $row['title'];
        }else{
            header('location:'.SITEURL);
        }
    ?>


    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="quantity" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                if(isset($_POST['submit'])){
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $quantity = $_POST['quantity'];

                    $total = $price*$quantity;
                    $order_date = date("Y-m-d h:i:sa");
                    $status = "Ordered"; //On Delivery, Delivered, Cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = '$price',
                        quantity = '$quantity',
                        total = '$total',
                        order_date = '$order_date',
                        status = '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'
                    ";

                    $res2 = mysqli_query($connection, $sql2);

                    if($res2 == true)
                    {
                        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully.</div>";
                        header('location:'.SITEURL);
                    }
                }

                
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

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
