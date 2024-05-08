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
        <h1>Add Admin</h1>
        <br>
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];//display session message 
            unset($_SESSION['add']);//remove session message
        }
        ?>
        <br>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td><lable>Full Name:</lable></td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></input></td>
                </tr>
                <tr>
                    <td><lable>User Name:</lable></td>
                    <td><input type="text" name="user_name" placeholder="Enter User Name"></input></td>
                </tr>
                <tr>
                    <td><lable>Phone Number:</lable></td>
                    <td><input type="tel" name="phone_number" placeholder="987XXXXXXX"></input></td>
                </tr>
                <tr>
                    <td><lable>Mail:</lable></td>
                    <td><input type="email" name="email" placeholder="Enter your mail id"></input></td>
                </tr>
                <tr>
                    <td><lable>Password:</lable></td>
                    <td><input type="password" name="password" placeholder="Enter Password"></input></td>
                </tr>
                <tr>
                    <td><lable>Profession:</lable></td>
                    <td><input type="text" name="profession" placeholder="Enter your Job Role"></input></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add-Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->

<?php
    //process the value and save in database
    //check wheather the button is clicked or not
    if(isset($_POST['submit']))
    {
        //button clicked
        // obtain values of the form

        $full_name = mysqli_real_escape_string($conn,$_POST['full_name']);
        $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = md5($_POST['password']); //password encrypted with md5 function
        $profession = mysqli_real_escape_string($conn, $_POST['profession']);

        //sql query to save data into database
        $sql = "INSERT INTO tb_admin SET 
        full_name = '$full_name', 
        user_name = '$user_name',
        phone_number = '$phone_number',
        email = '$email', 
        password = '$password',
        profession = '$profession'"; // added a missing comma here

        //execute query and save into db
        $risk = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //check whether the data is executed or not and display msg
        if ($risk){
            //insert data
            //echo "data inserted";
            //create session to display message where we want
            session_start();
            $_SESSION['add']="<div class='success' style='color:#5dac51;'>Admin added successfully.</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
            exit();
        }
        else{
            //error fail to insert data
            //echo "failed to insert data";
            //create session to display message where we want
            session_start();
            $_SESSION['add']="<div class='error' style='color:rgb(255,0,0)'>Failed to Add Admin, Try again..!</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-admin.php');
            exit();
        }
    }
?>
