<?php 
include('partials-front/menu.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id']) && isset($_POST['quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    
    // Update item quantity in cart
    if(isset($_SESSION['cart'][$item_id])){
        $_SESSION['cart'][$item_id]['quantity'] = $quantity;
        $_SESSION['order'] = "<div class='success' style='color:rgb(0,128,0)'>Quantity updated successfully.</div>";
        header('location:' . SITEURL . 'cart.php');
        exit();
    } else {
        $_SESSION['order'] = "<div class='error' style='color:rgb(250,0,0)'>Failed to update quantity.</div>";
        header('location:' . SITEURL . 'cart.php');
        exit();
    }
}
if(isset($_SESSION['checkout'])){
    echo $_SESSION['checkout'];//display session message
    unset($_SESSION['checkout']);//remove session message
}
?>

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">My Cart</h2>
        <?php
        if(isset($_SESSION['order'])){
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
	if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        ?>
        <form action="" method="POST">
        <?php
        $totalPrice = 0;
        if(isset($_SESSION['cart']) && is_array($_SESSION['cart']) && !empty($_SESSION['cart'])){
            foreach($_SESSION['cart'] as $item_id => $item){
                $sql = "SELECT * FROM tb_veggies WHERE id = '$item_id'";
                $result = mysqli_query($conn, $sql);
                if($result){
                    $row = mysqli_fetch_assoc($result);
                    if($row){
                        $img_name = $row['img_name'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $quantity = $item['quantity'];
                        $itemTotal = $price * $quantity;
                        $totalPrice += $itemTotal;
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($img_name=="")
                                    {
                                        echo "<div class='error' style='color:rgb(250,0,0)'>Image not Available</div>"; 
                                    }
                                    else{
                                        echo "<img src='".SITEURL."images/items/".$img_name."' alt='$title' class='img-responsive img-curve'>";
                                    }?> 
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">₹<?php echo $price; ?></p>
                                <p class="food-detail"><?php echo $description;?></p>
                                <div class="col-md-2">Quantity: 
                                    <form action="<?php echo SITEURL; ?>cart.php" method="post" style="display: inline;">
                                        <input type="number" style="width:25%" class="form-control" name="quantity" value="<?php echo $quantity; ?>" onchange="this.form.submit()">
                                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                                    </form>
                                </div>
                                <p>Total: <span style='color:blue'>₹<?php echo $itemTotal; ?></span></p><br>
                                
                                <div class="d-flex align-items-center">
                                    <form action="<?php echo SITEURL; ?>removeitem.php" method="post" class="mr-2">
                                        <a href="<?php echo SITEURL;?>order.php?item_id=<?php echo $item_id;?>" class="btn btn-primary">Order Now</a>
                                        <input type="hidden" name="item_id" value="<?php echo $item_id; ?>">
                                        <button type="submit" class="btn btn-primary" style="float:right;">X Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        // If the item does not exist in the database, remove it from the cart
                        unset($_SESSION['cart'][$item_id]);
                        echo "<div class='error' style='color:rgb(250,0,0)'>Item with ID $item_id is no longer available and has been removed from your cart.</div>";
                    }
                }
            }
            ?>
            <div class="text-right" >
            <h4 style="display: inline-block;">Total Price: ₹<span id="totalPrice"><?php echo $totalPrice; ?></span></h4><br><br>
            <a href="<?php echo SITEURL;?>checkout.php" class="btn btn-primary" >Check Out</a>
            </div>

            <?php
        } else {
            echo "<div class='error' style='color:rgb(250,0,0)'>Cart is empty</div>";
        }
        ?>
        </form>
        
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById('totalPrice').innerText = <?php echo $totalPrice; ?>;
            });
        </script>

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
