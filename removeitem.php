<?php
include('config/constants.php');

if(isset($_POST['item_id']) && !empty($_POST['item_id'])){
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'][array_search($item_id, array_keys($_SESSION['cart']))];
    
    // Remove item from cart
    if(isset($_SESSION['cart'][$item_id])){
        unset($_SESSION['cart'][$item_id]);
        $_SESSION['remove'] = "<div class='success' style='color:rgb(0,128,0)'>Item removed from cart.</div>";
        header('location:' . SITEURL . 'cart.php');
    } else {
        $_SESSION['remove'] = "<div class='error' style='color:rgb(250,0,0)'>Failed to remove item from cart.</div>";
        header('location:' . SITEURL . 'cart.php');
    }
} else {
    $_SESSION['remove'] = "<div class='error' style='color:rgb(250,0,0)'>Invalid item ID.</div>";
    header('location:' . SITEURL . 'cart.php');
}
?>
