<?php 
include("../config/constants.php");

// Update the logout time
if(isset($_SESSION['user'])){
    $user_name = $_SESSION['user'];
    $current_datetime = date("Y-m-d H:i:s");
    
    $update_sql = "UPDATE tb_admin SET logout_dt='$current_datetime' WHERE User_Name='$user_name'";
    $update_result = mysqli_query($conn, $update_sql);
    
    if($update_result){
        echo "Logout time updated successfully!";
    } else {
        echo "Error updating logout time: " . mysqli_error($conn);
    }
    
    unset($_SESSION['user']);
}

// Destroy the session and redirect to login page
session_destroy();
session_start();
unset($_SESSION['last_active_time']);

$_SESSION['logout']="<div class='error' style='color:rgb(250,0,0);'>): ...LogOut!</div>";

// Redirect to login page
header("Location: " . SITEURL . 'admin/login.php');
exit();
?>

