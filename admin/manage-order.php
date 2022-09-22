<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Manage Order</h1>

        <br>
        <?php
            if(isset($_SESSION['update'])){
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
        ?>
        <br>
        <table class="tbl-full">
            <tr>
                <th>SL</th>
                <th>Food</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th colspan="2">Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Customer Contact</th>
                <th>Customer Email</th>
                <th>Customer Address</th>
                <th>Actions</th>
            </tr>
            <?php 
                $sql = "SELECT * from tbl_order ORDER BY id DESC";
                $res = mysqli_query($connection, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count>0){
                        $sn = 1;
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            $id = $rows['id'];
                            $food = $rows['food'];
                            $price = $rows['price'];
                            $quantity = $rows['quantity'];
                            $total = $rows['total'];
                            $order_date = $rows['order_date'];
                            $status = $rows['status'];
                            $customer_name = $rows['customer_name'];
                            $customer_contact = $rows['customer_contact'];
                            $customer_email = $rows['customer_email'];
                            $customer_address = $rows['customer_address'];
                            ?>
                                <tr>
                                    <td><?php echo $sn++ ; ?></td>
                                    <td><?php echo $food ; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td><?php echo $quantity; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td colspan="2"><?php echo $order_date; ?></td>
                                    <td>
                                        <?php 
                                            if($status == 'Ordered'){ 
                                                echo "<label style='color: #eccc68;'>$status</label>";
                                            }
                                            elseif($status == 'On Delivery'){ 
                                                echo "<label style='color: orange;'>$status</label>";
                                            }
                                            elseif($status == 'Delivered'){ 
                                                echo "<label style='color: green;'>$status</label>";
                                            }
                                            elseif($status == 'Cancelled'){ 
                                                echo "<label style='color: red;'>$status</label>";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_contact; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td><?php echo $customer_address; ?></td>
                                    <td>
                                        <a 
                                            class="btn-secondary" 
                                            href="<?php echo SITEURL;?>admin/update-order.php?id=<?php echo $id;?>"
                                            >update
                                        </a>
                                    </td>
                                </tr>
                            <?php
                        }

                    }else{
                        echo "<tr><td class='error' colspan='12'>Order not available<td><tr>";
                    }
                }
            ?>
            
        </table>

        <div class="clearfix"></div>
      </div>
    </div>
    <!-- Main content ends -->

<?php include('./partials/footer.php') ?>