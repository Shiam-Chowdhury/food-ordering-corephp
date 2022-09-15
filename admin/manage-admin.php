<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>
        <br>
        <p class="success-message">
            <?php
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
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
                                        <a class="btn-secondary" href="#">update</a>
                                        <a class="btn-danger" href="#">delete</a>
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

    