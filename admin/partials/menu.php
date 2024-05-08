<?php include("../config/constants.php");
include("login-check.php");
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min/js"></script>
<script>
setInterval(function(){
    check_user();
}, 5000);
function check_user(){
    jQuery.ajax({
        url:'login.php',
        type:'post',
        data: 'type=ajax',
        success: function(result){
            console.log(result);
            if(resut=='logout'){
                window.location.href='logout.php';
            }
        }
    });
}
</script>
<html>
    <head>
        <title>veggies order website</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <!--menu section start-->
        <div class="menu text-center">
            <div class="wrapper">
                <a href="#" title="Logo" class="logo">
                    <img src="../images/logo.gif" alt="Veggies Villa Logo" class="img-responsive">
                </a>
                <h3 class="vv" style="color:white;">Veggies Villa</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="managedesk-admin.php">Admin</a></li>
                    <li><a href="managedesk-category.php">Category</a></li>
                    <li><a href="managedesk-veggies.php">Veggies</a></li>
                    <li><a href="managedesk-orders.php">Orders</a></li>
                    <li><a href="logout.php">LogOut</a></li>
                </ul>

            </div>
            
        </div>
        <!--menu section ends-->
    </body>
</html>
