<?php include('./partials/menu.php') ?>

    <!-- Main content starts -->
    <div class="main-content">
      <div class="wrapper">
        <h1>Dashboard</h1>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>
        <div class="col-4">
          <?php 
            $sql = "SELECT * from tbl_category";
            $res = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($res);
          ?>
          <h1><?php echo $count; ?></h1>
          <br />
          Categories
        </div>
        <div class="col-4">
          <?php 
            $sql = "SELECT * from tbl_food";
            $res = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($res);
          ?>
          <h1><?php echo $count; ?></h1>
          <br />
          Foods
        </div>
        <div class="col-4">
          <?php 
            $sql = "SELECT * from tbl_order";
            $res = mysqli_query($connection, $sql);
            $count = mysqli_num_rows($res);
          ?>
          <h1><?php echo $count; ?></h1>
          <br />
          Orders
        </div>
        <div class="col-4">
          <?php 
            $sql = "SELECT SUM(total) as Total from tbl_order WHERE status='Delivered'";
            $res = mysqli_query($connection, $sql);
            $row = mysqli_fetch_assoc($res);
            $Total = $row['Total'];
          ?>
          <h1><?php echo '$'.$Total; ?></h1>
          <br />
          Revenue
        </div>

        <div class="clearfix"></div>
      </div>
    </div>
    <!-- Main content ends -->

<?php include('./partials/footer.php') ?>
