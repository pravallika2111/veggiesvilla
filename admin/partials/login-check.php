<?php
if(isset($_POST['type']) && $_POST['type'] == 'ajax'){
    if (isset($_SESSION['last_active_time'])){
        if ((time()-$_SESSION['last_active_time'])>2000){
            echo "logout";    
        }
    }

}
else{
    
    if (isset($_SESSION['last_active_time'])){
        if ((time()-$_SESSION['last_active_time'])>2000){
            header("Location: " . SITEURL . 'admin/logout.php');
            die();    
        }
    }
}
$_SESSION['last_active_time']= time();
    //authorization and access contol
    //check whether user login or not
    if(!isset($_SESSION['user'])){
        // if user session is not set then user is not login redirect to login page
        $_SESSION['no-login-msg'] = "<div class='error' style='color:rgb(250,0,0);'>please login to access admin panel.</div>";
        //redirect page to manage admin
    header("Location: " . SITEURL . 'admin/login.php');
    }

?>
