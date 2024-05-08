<?php 
include("../config/constants.php");
?>

<html>
<head>
    <title>Login veggies villa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <!--menu section start-->
    <div class="login">
        <h1>Login</h1><br><br>
        <?php
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-msg'])){
                echo $_SESSION['no-login-msg'];
                unset($_SESSION['no-login-msg']);
            }
            if(isset($_SESSION['logout'])){
                echo $_SESSION['logout'];
                unset($_SESSION['logout']);
            }
        ?><br>
        <!--login form start here-->
        <form action="" method="POST">
            <label>Username</label><br>
            <input type="text" name="user_name" placeholder="Enter Username"><br><br>
            <label>Password</label><br>
            <input type="password" name="password" placeholder="Enter password"><br><br>
            <input type="submit" name="submit" value="Submit" class="btn-primary">
        </form>
        <!--login form end here--><br><br>
        <p>Welcome to <a href="#">Veggies.Villa</a></p>
    </div>
    <!--menu section ends-->
</body>
</html>

<?php
//check whether the submit button is clicked or not
if(isset($_POST['submit'])){
    //get data from login form
    $user_name_sec = $_POST['user_name'];
    $password_sec = $_POST['password'];

    // Make sure to escape the values properly
    $user_name = mysqli_real_escape_string($conn, $user_name_sec);
    $password = mysqli_real_escape_string($conn, $password_sec);

    //check with sql query if username is correct
    $sql = "SELECT * FROM tb_admin WHERE user_name='$user_name'";
    $result = mysqli_query($conn, $sql);

    if($result){
        $count = mysqli_num_rows($result);
        if($count == 1){
            $row = mysqli_fetch_assoc($result);
            if(md5($password, $row['password'])){ // verify password
                $id = $row['id']; // get the id from the database
                $sql1 = "UPDATE tb_admin SET login_dt=now() WHERE id=$id";
                $result1 = mysqli_query($conn, $sql1);

                $_SESSION['login'] = "<div class='success' style='color:#5dac51;'>Login Successfully</div>";
                $_SESSION['user'] = $user_name;
                $_SESSION['id'] = $id; // set the id in session

                //redirect page to manage admin
                header("Location: " . SITEURL . 'admin/index.php');
                exit(); 
            } else {
                $_SESSION['login'] = "<div class='error' style='color:rgb(250,0,0);'>Incorrect Password</div>";
                //redirect page to login
                header("Location: " . SITEURL . 'admin/login.php');
                exit();
            }
        } else {
            $_SESSION['login'] = "<div class='error' style='color:rgb(250,0,0);'>Incorrect Username</div>";
            //redirect page to login
            header("Location: " . SITEURL . 'admin/login.php');
            exit();
        }
    } else {
        // SQL query error
        echo "Query failed: " . mysqli_error($conn);
    }
}
?>
