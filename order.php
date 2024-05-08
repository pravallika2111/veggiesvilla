<style>
    
    .con{
        display:flex;
        align-items: left;
        justify-content: left;
        border:0.1px solid black;
    }
    .food-menu-container {
        display: flex;
        justify-content: space-between;
    }

    .food-menu-img {
        flex: 0 0 30%;
    }

    .food-menu-img img {
        max-width: 80%;
        border-radius: 10px;
    }

    .food-menu-desc {
        flex: 0 0 65%;
        float: right;
    }

    .food-price {
        color: #f44336;
        font-size: 24px;
        margin-top: 10px;
    }

    .order-label {
        margin-top: 10px;
    }

    .col-md-2 input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    @media (max-width: 768px) {
        .food-menu-container {
            flex-direction: column;
        }

        .food-menu-desc {
            float: none;
            margin-top: 20px;
        }

        .food-menu-img {
            margin-bottom: 20px;
        }
    }
.checkout-form {
    background-color: #DFDCDC;
    padding: 10px;
    border-radius: 8px;
    margin-left: 220px;
    margin-right: 220px;
}
.complete-order {
    margin-left: 10px;
    margin-right: 10px;
    padding-bottom:15px;
}
.heading {
    text-align: center;
    margin-bottom: 20px;
}

.flex {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.inputBox {
    flex-basis: 48%;
    margin-bottom: 15px;
}

.inputBox span {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

.inputBox input,
.inputBox select {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.btn {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #f44336;
    color: white;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-top: 20px;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #d32f2f;
}
.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}
</style>

<?php include('partials-front/menu.php'); ?>
<section class="checkout-form">
    <div class="container">
        <?php
        if(isset($_GET['item_id'])){
            $item_id=$_GET['item_id'];
            $sql="SELECT * FROM tb_veggies WHERE id=$item_id";
            $risk=mysqli_query($conn, $sql);
            $count=mysqli_num_rows($risk);
            if($count==1){
                $row=mysqli_fetch_assoc($risk);
                $title =$row['title'];
                $price=$row['price'];
                $img_name=$row['img_name'];

                // Fetch quantity from cart
                $quantity = isset($_SESSION['cart'][$item_id]['quantity']) ? $_SESSION['cart'][$item_id]['quantity'] : 1;
                $total = $price * $quantity;

            }
            else {
                header('LOCATION:'.SITEURL);
            }
        } else {
            header('LOCATION:'.SITEURL);
        }
        
        // Allow updating quantity
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['update_quantity'])) {
                $quantity = $_POST['quantity_' . $item_id];
                $total = $price * $quantity;
            } else {
                $quantity = 1;
                $total = $price;
            }
        }
        ?><br>
        <h2 class="text-center">Confirm your order</h2>

        <form action="" method="POST" class="order">
        <fieldset class="con">
            <legend >Selected Item</legend>
            <div class="food-menu-img">
                <?php
                if ($img_name==""){
                    echo "<div class='error'>Image not Available</div>";
                } else {
                    ?>
                    <img src="<?php echo SITEURL;?>images/items/<?php echo $img_name;?>" class="img-responsive img-curve">
                    <?php } ?>
            </div>
            <div class="food-menu-desc" style="float: right;">
                <h3><?php echo $title; ?></h3>
                <input type="hidden" name="item" value="<?php echo $title;?>">
                <p class="food-price">₹<?php echo $price; ?></p>
                <input type="hidden" name="price" value="<?php echo $price;?>">
                <div class="col-md-2" >
                    Quantity: 
                    <input type="number" class="form-control" min="1" name="quantity_<?php echo $item_id; ?>" 
                    style="width: 45%;"value="<?php echo $quantity; ?>" 
                    onchange="updateQuantity(<?php echo $item_id; ?>)">
                </div>

                <div class="order-label">Total Price: 
                    <span class="food-price" id="total" >₹<?php echo $total; ?></span>
                </div>
            </div>
            </form>

            </fieldset>


    <section class="complete-order">
      <!-- Ordered Items Section Ends Here -->
      <h1 class="heading">Complete Your Order</h1>
      <form action="process-checkout.php" method="post">

      <div class="flex">
            <div class="inputBox">
               <span>Your Name</span>
               <input type="text" placeholder="Enter your name" name="name" required>
            </div>
            <div class="inputBox">
               <span>Your Number</span>
               <input type="number" placeholder="Enter your number" name="number" required>
            </div>
            <div class="inputBox">
               <span>Your Email</span>
               <input type="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="inputBox">
               <span>Flat/Door No.</span>
               <input type="text" placeholder="e.g. Flat No. XXX" name="flat" required>
            </div>
            <div class="inputBox">
               <span>Street</span>
               <input type="text" placeholder="e.g. XYZ Street" name="street" required>
            </div>
            <div class="inputBox">
               <span>City</span>
               <input type="text" placeholder="e.g. Hyderabad" name="city" required>
            </div>
            <div class="inputBox">
               <span>State</span>
               <input type="text" placeholder="e.g. Telangana" name="state" required>
            </div>
            <div class="inputBox">
               <span>Country</span>
               <input type="text" placeholder="e.g. India" name="country" required>
            </div>
            <div class="inputBox">
               <span>Pin Code</span>
               <input type="text" placeholder="e.g. 5XXXXX" name="pin_code" required>
            </div>
            <div class="inputBox">
               <span>Near By</span>
               <input type="text" placeholder="e.g. nu" name="near_by" required>
            </div>
         </div>
         <input type="submit" value="Order Now" name="order_btn" class="btn">
      </form>
   </section>

    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#quantity_<?php echo $item_id; ?>').on('input', function() {
            var quantity = $(this).val();
            var total = <?php echo $price; ?> * quantity;
            $('#total').text('₹' + total.toFixed(2));
        });
    });

    function updateQuantity(item_id) {
        const quantity = document.querySelector(`input[name="quantity_${item_id}"]`).value;
        const total = <?php echo $price; ?> * quantity;
        document.getElementById('total').innerText = '₹' + total.toFixed(2);
    }
</script>

<?php include('partials-front/footer.php'); ?>
