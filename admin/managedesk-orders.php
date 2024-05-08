<!--menu section start-->
<?php include("partials/menu.php")?>
<!--menu section ends-->
<style>
    .table-design {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table-design th{
        border-bottom:  1px solid black;
        padding: 8px;
        text-align: center;        
    }
    .table-design td {
        border:  rgb(206, 242, 254);
        padding: 8px;
        text-align: center;
    }
</style>
<!--main section starts-->
<div class="main">
    <div class="wrapper">
        <h1>Manage Orders</h1>
        <br><?php
        if(isset($_SESSION['update'])){
            echo ($_SESSION['update']);
            unset($_SESSION['update']);
        }
        
        ?>
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
            $sql5 = "SELECT * FROM tb_order WHERE status='shipped'";
            $risk5 = mysqli_query($conn, $sql5);
            $count5 = mysqli_num_rows($risk5);
            ?>
            <h1><?php echo $count5; ?></h1><br>
            <p>Total Shipped Orders</p>
        </div>

        <div class="code-4 text-center">
        <?php
            $sql4 = "SELECT * FROM tb_order WHERE status='delivered'";
            $risk4 = mysqli_query($conn, $sql4);
            $count4 = mysqli_num_rows($risk4);
            ?>
            <h1><?php echo $count4; ?></h1><br>
            <p>Total Delivered Orders</p>
        </div>

        <div class="code-4 text-center">
        <?php
            $sql6 = "SELECT * FROM tb_order WHERE status='cancelled'";
            $risk6 = mysqli_query($conn, $sql6);
            $count6 = mysqli_num_rows($risk6);
            ?>
            <h1><?php echo $count6; ?></h1><br>
            <p>Total Cancelled Orders</p>
        </div><br><br>
        <table class="table-design">
            <tr>
                <th>SI.NO</th>
                <th>Item</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            ini_set('display_errors',1);
            $sql = "SELECT * FROM tb_order ORDER BY id DESC";//latest order on top
            $risk = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($risk);
            $n=1;//to create serial number
            if ($count>0){
                while($row=mysqli_fetch_assoc($risk)){
                    $id = $row['id'];
                    $item=$row['item'];
                    $price=$row['price'];
                    $quantity=$row['quantity'];
                    $total=$row['total'];
                    $order_date=$row['order_date'];
                    $status=$row['status'];
                    $customer_name=$row['customer_name'];
                    $customer_contact=$row['customer_contact'];
                    $customer_email=$row['customer_email'];
                    $flat = $row['flat'];
                    $street = $row['street'];
                    $city = $row['city'];
                    $state = $row['state'];
                    $country = $row['country'];
                    $pin_code = $row['pin_code'];
                    $near_by = $row['near_by']; 
      
                    ?>
                    <tr>
                        <td><?php echo $n++;?></td>
                        <td><?php echo $item;?></td>
                        <td>₹<?php echo $price;?></td>
                        <td><?php echo $quantity;?></td>
                        <td>₹<?php echo $total;?></td>
                        <td><?php echo $order_date;?></td>
                        <td>
                            <?php if($status=="ordered"){echo "<label>$status</label>";}
                                  elseif($status=="shipped"){echo "<label style='color:orange'>$status</label>";}
                                  elseif($status=="delivered"){echo "<label style='color:green'>$status</label>";}
                                  elseif($status=="cancelled"){echo "<label style='color:red'>$status</label>";}
                            ?>
                        </td>
                        <td><?php echo $customer_name;?></td>
                        <td><?php echo $customer_contact;?></td>
                        <td><?php echo $customer_email;?></td>
                        <td><?php echo "<span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span>";?></td>
                        <td style="width:12%; text-align:right;">
                            <a href="<?php echo SITEURL;?>admin/updateorder.php?id=<?php echo $id;?>" class="btn-secondary">Update Orders</a>
                        </td>
                    </tr>
                            
                    <?php

                }
            }
            else{
                echo "<tr><td colspan='12' class='error' style='color:rgd(250,0,0)'>Order not Available</td></tr>";
            }

            ?>

        </table>
    </div>
</div>
<!--main section ends-->

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->
