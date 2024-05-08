<!--menu section start-->
<?php include("partials/menu.php");?>
<!--menu section ends-->
<style>
.tbl-30{
    width:30%;
}
</style>
<div class="main">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br>
        <?php 
        // get id of selected admin
        $id = $_GET['id'];
        //create sql query
        $sql = "SELECT * FROM tb_admin where id=$id";
        //execute query
        $risk = mysqli_query($conn, $sql);
        //check query executed or not
        if ($risk==true){
            //check whether data is available or not
            $count=mysqli_num_rows($risk);
            //check whether admin data is available or not
            if($count==1){
                //get the details
                //echo "Admin is availble";
                $row=mysqli_fetch_assoc($risk);
                $full_name = $row['Full_Name'];
                $user_name = $row['User_Name'];
                $phone_number = $row['Phone_Number'];
                $email = $row['Email'];
                $profession = $row['profession'];
            }
            
        }
        else{
                //redirect page to manage admin
                header("Location: " . SITEURL . 'admin/managedesk-admin.php');
        }
    
        ?>
        <form action="" method="post">
        <table class="tbl-30">
                <tr>
                    <td><lable>Full Name:</lable></td>
                    <td><input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>"></td>

                </tr>
                <tr>
                    <td><lable>User Name:</lable></td>
                    <td><input type="text" name="user_name" value="<?php echo htmlspecialchars($user_name)?>"></td>
                </tr>
                <tr>
                    <td><lable>Phone Number:</lable></td>
                    <td><input type="tel" name="phone_number" value="<?php echo htmlspecialchars($phone_number)?>"></td>
                </tr>
                <tr>
                    <td><lable>Email:</lable></td>
                    <td><input type="email" name="email" value="<?php echo htmlspecialchars($email)?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update-Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
    //check whether submit button clicked or not
    if(isset($_POST['submit'])){
        //get all the data form to update
        $id = $_POST['id'];
        $full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
        $user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
        $phone_number = mysqli_real_escape_string($conn,$_POST['phone_number']);
        $email = mysqli_real_escape_string($conn,$_POST['email']);
        
        //sql query to update database
        $sql = "UPDATE tb_admin SET 
        Full_Name = '$full_name', 
        User_Name = '$user_name',
        Phone_Number = '$phone_number',
        Email = '$Email'
        WHERE id = '$id'";

        //execute the query
        $risk =mysqli_query($conn, $sql);
        //check whether the query successfully executed or not
        if ($risk==true){
            // query executed that updated admin successfully
            session_start();
            $_SESSION['update']="<div class='success' style='color:#5dac51;'>Admin Updated successfully.</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
            exit();
        }
        else{
            //failed to update admin
            session_start();
            $_SESSION['update']="<div class='error' style='color:rgb(255,0,0)'>Failed to Update Admin, Try again..!</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
            exit();
        }
    }
?>
<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->
