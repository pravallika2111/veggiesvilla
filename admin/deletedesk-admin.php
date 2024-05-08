<?php
//include constant.php file here
include('../config/constants.php');
    //get id to delete
    $id = $_GET['id'];
    //sql query to delete
    $sql = "DELETE FROM tb_admin WHERE id=$id";
    //execute query
    $risk = mysqli_query($conn, $sql);
    //check whether the query executed sauccessfull or not
    if ($risk==true){
        // query executed that admin deleted successfully
        session_start();
        $_SESSION['delete']="<div class='success' style='color:#5dac51;'>Admin Deleted successfully.</div>";
        //redirect page to manage admin
        header("Location: " . SITEURL . 'admin/managedesk-admin.php');
        exit();
    }
    else{
        //failed to delete admin
        session_start();
                $_SESSION['delete']="<div class='error' style='color:rgb(255,0,0)'>Failed to Deleted Admin, Try again..!</div>";
                //redirect page to manage admin
                header("Location: " . SITEURL . 'admin/managedesk-admin.php');
                exit();
    }
    //redirect to manage admin page msg success or error
    
?>
