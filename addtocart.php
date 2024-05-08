<?php 
include('partials-front/menu.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT * FROM tb_veggies WHERE id = '$item_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $item = array(
            "id" => $row['id'],
            "title" => $row['title'],
            "price" => $row['price'],
            "quantity" => $quantity,
            "total_price" => $row['price'] * $quantity
        );

        // Check if the session cart exists, if not, create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Check if the item is already in the cart, if so, update the quantity
        if (array_key_exists($item_id, $_SESSION['cart'])) {
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
            $_SESSION['cart'][$item_id]['total_price'] += $item['total_price'];
        } else {
            $_SESSION['cart'][$item_id] = $item;
        }

        $_SESSION['addtocart'] = "<div class='success' style='color:rgb(0,128,0); text-align:center;'>Item added to cart successfully.</div>";
        header('location:' . SITEURL.'items.php');
    } else {
        $_SESSION['addtocart'] = "<div class='error' style='color:rgb(250,0,0); text-align:center;'>Failed to add item to cart.</div>";
        header('location:' . SITEURL.'items.php');
    }
}
?>


<?php include('partials-front/footer.php'); ?>
