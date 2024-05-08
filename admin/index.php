<!--menu section start-->
<?php include("partials/menu.php");?>
<!--menu section ends-->

    <!--main content section start-->
        <div class="main">
            <div class="wrapper">
                <h1>DashBoard</h1><br>
                <?php
                if(isset($_SESSION['login'])){
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                ?><br>
                <div class="code-4 text-center">
                    <?php
                    $sql="SELECT * FROM tb_category";
                    $risk=mysqli_query($conn,$sql);
                    $count=mysqli_num_rows($risk);
                    ?>
                    <h1><?php echo $count;?></h1><br>
                    Categories
                </div>
                <div class="code-4 text-center">
                <?php
                    $sql1="SELECT * FROM tb_veggies";
                    $risk1=mysqli_query($conn,$sql1);
                    $count1=mysqli_num_rows($risk1);
                    ?>
                    <h1><?php echo $count1;?></h1><br>
                    Items
                </div>
                <div class="code-4 text-center">
                <?php
                    $sql2 = "SELECT * FROM tb_order";
                    $risk2 = mysqli_query($conn, $sql2);
                    $count2 = mysqli_num_rows($risk2);
                    ?>
                    <h1><?php echo $count2; ?></h1><br>
                    <p>Total Orders</p>
                </div>

                <div class="code-4 text-center">
                <?php
                    $sql3="SELECT SUM(total) AS total FROM tb_order WHERE status='delivered'";
                    $risk3=mysqli_query($conn,$sql3);
                    $row3=mysqli_fetch_assoc($risk3);
                    $total_revenue = $row3['total'];
                    ?>
                    <h1>₹<?php echo $total_revenue;?></h1><br>
                    Revenue Generated
                </div>
                <div class="clear-fix"></div>
                
            </div>            
        </div>
    <!--main content section end-->

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->

