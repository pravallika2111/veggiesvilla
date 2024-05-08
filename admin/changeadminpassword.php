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
        <h1>Change Password</h1>
        <br>
        <?php
            if(isset($_GET['id'])){
                $id = $_GET['id'];
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td><lable>Current Password:</lable></td>
                    <td><input type="password" name="current_password" placeholder="Current Password"></td>
                </tr>
                <tr>
                    <td><lable>New Password:</lable></td>
                    <td><input type="password" name="new_password" placeholder="New Password"></td>
                </tr>
                <tr>
                    <td><lable>Confirm Password:</lable></td>
                    <td><input type="password" name="confirm_password" placeholder="Confirm New Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
    //Check whether submit button clicked or not
    if(isset($_POST['submit'])){
        //echo "Button Clicked";
        //get all the alues from form to update
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);
        
        //sql query to update database
        $sql = "SELECT * FROM tb_admin WHERE id = $id AND password='$current_password'";

        //execute the query
        $risk =mysqli_query($conn, $sql);
        //check whether the data is available or not
        if ($risk==true){
            //check whether data is available or not
            $count=mysqli_num_rows($risk);
            //check whether admin data is available or not
            if($count==1){
                //user exsist passward can change
                //check new password and confirm password or not
                if($new_password==$confirm_password){
                    //new password need to match to confirm password
                    if($current_password!=$new_password){
                        //update password
                        $sql1 = "UPDATE tb_admin SET password = '$new_password' where id=$id";
                        $risk1 = mysqli_query($conn, $sql1);
                        if ($risk1==true){
                            // query executed that admin deleted successfully
                            session_start();
                            $_SESSION['pass-change']="<div class='success' style='color:#5dac51;'>Password Changed successfully.</div>";
                            //redirect page to manage admin
                            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                            exit();
                        }
                        else{
                            //failed to delete admin
                            session_start();
                            $_SESSION['pass-change']="<div class='error' style='color:rgb(255,0,0)'>Failed to Change Password, Try again..!</div>";
                            //redirect page to manage admin
                            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                            exit();
                        }

                    }
                    else{
                        session_start();
                        $_SESSION['pass-not-matched']="<div class='error' style='color:rgb(255,0,0)'>Current password and New password are matched, Try again..!</div>";
                        //redirect page to manage admin
                        header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                        exit();
                    }
                }
                else{
                    session_start();
                    $_SESSION['curr-new-pass-matched']="<div class='error' style='color:rgb(255,0,0)'>New password and confirm password are not matched, Try again..!</div>";
                    //redirect page to manage admin
                    header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                    exit();
                }
            }
            else{
                session_start();
                $_SESSION['user-not-found']="<div class='error' style='color:rgb(255,0,0)'>Failed to change password, Try again..!</div>";
                //redirect page to manage admin
                header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                exit();
            }
            
        }
        
    }
?>


<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->