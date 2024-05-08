<!--menu section start-->
<?php include("partials/menu.php");?>
<!--menu section ends-->


    <!--main content section start-->
        <div class="main">
            <div class="wrapper">
                <h1>Manage Admin</h1>
                <br>
                <?php 
                    if(isset($_SESSION['add'])){
                        echo $_SESSION['add'];//display session message
                        unset($_SESSION['add']);//remove session message
                    }
                    if(isset($_SESSION['delete'])){
                        echo $_SESSION['delete'];//display session message
                        unset($_SESSION['delete']);//remove session message
                    }
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];//display session message
                        unset($_SESSION['update']);//remove session message
                    }
                    if(isset($_SESSION['curr-new-pass-matched'])){
                        echo $_SESSION['curr-new-pass-matched'];//display session message
                        unset($_SESSION['curr-new-pass-matched']);//remove session message
                    }
                    if(isset($_SESSION['pass-not-matched'])){
                        echo $_SESSION['pass-not-matched'];//display session message
                        unset($_SESSION['pass-not-matched']);//remove session message
                    }
                    if(isset($_SESSION['user-not-found'])){
                        echo $_SESSION['user-not-found'];//display session message
                        unset($_SESSION['user-not-found']);//remove session message
                    }
                    if(isset($_SESSION['pass-change'])){
                        echo $_SESSION['pass-change'];//display session message
                        unset($_SESSION['pass-change']);//remove session message
                    }
                ?><br><br><br>
                <a href="adddesk-admin.php" class="btn-primary">Add Admin</a>
                
                <br><br><br><br>
                <table class="table-design">
                    <tr>
                        <th>SI.NO</th>
                        <th>Full Name</th>
                        <th>User Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                    error_reporting(E_ALL);
                    ini_set('display_errors',1);
                    //get all admins
                        $sql = "SELECT * FROM tb_admin";
                        $risk = mysqli_query($conn, $sql);
                        if ($risk){
                            $count = mysqli_num_rows($risk);
                            if($count>0){
                                //have data in data base
                                $n=1;
                                while($rows=mysqli_fetch_assoc($risk)){
                                
                                    $id=$rows['id'];
                                    $full_name=isset($rows['Full_Name']) ? $rows['Full_Name']: '';
                                    $user_name=isset($rows['User_Name']) ? $rows['User_Name']: '';
                                    $phone_number=isset($rows['Phone_Number']) ? $rows['Phone_Number']: '';
                                    $email=isset($rows['Email']) ? $rows['Email']: '';
                                    $profession =isset($rows['profession']) ? $rows['profession']: '';
                                    ?>
                                    <tr>
                                    <td><?php echo $n++; ?></td>
                                    <td><?php echo $rows['Full_Name']; ?></td>
                                    <td><?php echo $rows['User_Name']; ?></td>
                                    <td><?php echo $rows['Phone_Number']; ?></td>
                                    <td><?php echo $rows['Email']; ?></td>
                                    <td><?php echo $rows['profession']; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/changeadminpassword.php?id=<?php echo $id;?>" class="btn-warning">Change Password</a>
                                        <a href="<?php echo SITEURL;?>admin/updateadmin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a>
                                        <a href="<?php echo SITEURL;?>admin/deletedesk-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                    </tr>
                            
                                    <?php

                                }
                            }
                            else{
                                echo "<tr><td colspan='4'> <div class='error' style='color:rgb(255,0,0)'>No admin Found</div></td></tr>";
                            }
                        }
                    ?>
                    
                </table>
            </div>            
        </div>
    <!--main content section end-->

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->
