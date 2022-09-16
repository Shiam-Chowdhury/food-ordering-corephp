<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>
        <br>
        <p class="success">
            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }
                if(isset($_SESSION['update'])){
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                if(isset($_SESSION['user_not_found'])){
                    echo $_SESSION['user_not_found'];
                    unset($_SESSION['user_not_found']);
                }
                if(isset($_SESSION['password_update'])){
                    echo $_SESSION['password_update'];
                    unset($_SESSION['password_update']);
                }
            ?>
        </p>

        <p class="error">
            <?php
                if(isset($_SESSION['delete-failed'])){
                    echo $_SESSION['delete-failed'];
                    unset($_SESSION['delete-failed']);
                }
            ?>
        </p>
        
        <br>
        <a class="btn-primary" href="add-admin.php">Add New Admin</a>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>SL</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * from tbl_admin";
                $res = mysqli_query($connection, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count>0){
                        $sn = 1;
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            $id = $rows['id'];
                            $fullname = $rows['fullname'];
                            $username = $rows['username'];

                            ?>
                                <tr>
                                    <td><?php echo $sn++ ?></td>
                                    <td><?php echo $fullname ?></td>
                                    <td><?php echo $username ?></td>
                                    <td>
                                        <a 
                                            class="btn-primary mr-10" 
                                            href="<?php echo SITEURL;?>admin/update-password.php?id=<?php echo $id;?>" 
                                            >update password
                                        </a>
                                        <a 
                                            class="btn-secondary mr-10" 
                                            href="<?php echo SITEURL;?>admin/update-admin.php?id=<?php echo $id;?>" 
                                            >update
                                        </a>
                                        <a 
                                            href="<?php echo SITEURL;?>admin/delete-admin.php?id=<?php echo $id;?>" 
                                            class="btn-danger mr-10" href="#"
                                            >delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }else{

                    }
                }
            ?>
            
        </table>

        <div class="clearfix"></div>
      </div>
    </div>
    <!-- Main content ends -->

<?php include('./partials/footer.php') ?>

    