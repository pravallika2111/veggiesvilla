<?php include('config/constants.php'); ?>
<style>
    .navbar{
        background-color:#00193A;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Veggies Villa Website</title>
    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/logo.gif" alt="Veggies Villa Logo" class="img-responsive">
                </a>
            </div>
            <div class="vv" style="color:white;">Veggies Villa</div>
            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>items.php">Items</a>
                    </li>
                    <li>
                        <a href="#contacts">Contact</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>account.php">My account</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>cart.php"><i style='font-size:24px' class='fas'>&#xf217;</i></a>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->

    <!-- Content Start -->
    <!-- Your content goes here -->

    <!-- Content End -->
