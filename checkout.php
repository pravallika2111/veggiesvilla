<?php 
include('partials-front/menu.php'); 
?>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.checkout-form {
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
    margin-top: 50px;
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

.display-order {
    margin-bottom: 20px;
}

.display-order span {
    display: block;
    margin-bottom: 10px;
}

.grand-total {
    font-weight: 600;
    font-size: 18px;
    display: block;
    margin-top: 10px;
}

.order-message-container {
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 8px;
    margin-top: 50px;
}

.message-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.order-detail,
.customer-details {
    margin-bottom: 20px;
}

.total {
    font-weight: 600;
}

.customer-details p {
    margin-bottom: 10px;
}

.customer-details span {
    font-weight: 500;
}

.error {
    background-color: #f44336;
    color: white;
    padding: 10px;
    border-radius: 4px;
    margin-bottom: 20px;
    text-align: center;
}

@media (max-width: 768px) {
    .inputBox {
        flex-basis: 100%;
    }
}
.ord{
   text-align:center;
}
table{
    text-align: center;
    justify:center;
    padding: 10px;
}

th{
   border-bottom: 0.1px solid black;
}
td {
    border-bottom: 0.1px solid black;
    text-align: center;
    justify:center;
    padding: 8px;
}

.th_img {
   text-align:left;
    justify:left;
    padding: 8px;
    width: 1%; /* Decreased image column size */
}

.th_name, .th_price, .th_quantity, .th_total {
    text-align: center;
    justify:center;
    padding: 8px;
    width: 30%; /* Increased other columns' sizes */
}
.complete-order {
   margin-left: 120px;
   margin-right: 120px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<div class="container">

<section class="checkout-form">

   <!-- Ordered Items Section Starts Here -->
   <section class="ordered-items">
      <div class="container">
         <h3 class="ord">Ordered Items</h3>
         <table class="table table-bordered">
               <thead>
                  <tr>
                     <th class="th_img">Image</th>
                     <th>Item Name</th>
                     <th>Price</th>
                     <th>Quantity</th>
                     <th>Total</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                  if(isset($_SESSION['cart'])) {
                     $total = 0;
                     foreach($_SESSION['cart'] as $key => $value) {
                           $sql = "SELECT * FROM tb_veggies WHERE id='$key'";
                           $result = mysqli_query($conn, $sql);
                           $row = mysqli_fetch_assoc($result);
                           $img_name=$row['img_name'];
                           $itemName = $row['title'];
                           $itemPrice = $row['price'];
                           $itemQuantity = $value['quantity'];
                           $itemTotal = $itemPrice * $itemQuantity;
                           
                           $total += $itemTotal;?>
                           <tr>
                              <td>
                                 <div class="food-menu-img" style="display: flex; align-items: left; justify-content: left; width: 70px;">
                                    <?php 
                                       if($img_name == "") {
                                             echo "<div class='error' style='color:white'>Image not available</div>";
                                       } 
                                       else {
                                       ?>
                                          <img src="<?php echo SITEURL;?>images/items/<?php echo $img_name;?>" 
                                          alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                       <?php
                                       }
                                       ?>
                                    </div>
                              </td>
                              <td><?php echo $itemName; ?></td>
                              <td>₹<?php echo $itemPrice; ?></td>
                              <td><?php echo $itemQuantity; ?></td>
                              <td>₹<?php echo $itemTotal; ?>/-</td>
                           </tr>
                  <?php
                     }
                  ?>
                     <tr>
                           <td colspan="4" class="text-right"><strong>Total:</strong></td>
                           <td><strong>₹<?php echo $total; ?>/-</strong></td>
                     </tr>
                  <?php
                  } else {
                  ?>
                     <tr>
                           <td colspan="5" class="text-center">No items in cart</td>
                     </tr>
                  <?php
                  }
                  ?>
               </tbody>
         </table>
      </div>
   </section><br>
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
</section>
</div>
<!-- custom js file link  -->
<script src="js/script.js"></script>
<?php include('partials-front/footer.php'); ?>

</body>
</html>
