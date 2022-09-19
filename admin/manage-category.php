<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Manage Category</h1>
        <br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
            if(isset($_SESSION['remove'])){
                echo $_SESSION['remove'];
                unset($_SESSION['remove']);
            }
            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if(isset($_SESSION['no-category-found'])){
                echo $_SESSION['no-category-found'];
                unset($_SESSION['no-category-found']);
            }
        ?>
        <br>
        <!-- <a class="btn-primary" href="add-category.php">Add New Category</a> -->
        <a class="btn-primary" href="<?php echo SITEURL;?>admin/add-category.php">Add New Category</a>
        <br>
        <br>
        <table class="tbl-full">
            <tr>
                <th>SL</th>
                <th>Title</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php
                $sql = "SELECT * from tbl_category";
                $res = mysqli_query($connection, $sql);

                if($res == TRUE){
                    $count = mysqli_num_rows($res);

                    if($count>0){
                        $sn = 1;
                        while($rows=mysqli_fetch_assoc($res))
                        {
                            $id = $rows['id'];
                            $title = $rows['title'];
                            $image_name = $rows['image_name'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];
                            ?>
                            <tr>
                                <td><?php echo $sn++ ; ?></td>
                                <td><?php echo $title; ?></td>
                                <td>
                                    <?php 
                                        if($image_name != ''){
                                            ?>
                                            <img width="100px" src="<?php echo SITEURL; ?>images/category/<?php echo $image_name;?>">
                                            <?php
                                        }else{
                                            echo '<div class="error">image not added</div>';
                                        }
                                    ?>
                                </td>
                                <td><?php echo $featured; ?></td>
                                <td><?php echo $active; ?></td>
                                <td>
                                    <a class="btn-secondary"
                                        href="<?php echo SITEURL;?>admin/update-category.php?id=<?php echo $id;?>">update</a>
                                    <a class="btn-danger" 
                                        href="<?php echo SITEURL;?>admin/delete-category.php?id=<?php echo $id;?>&image_name=<?php echo $image_name;?>"
                                    >delete</a>
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