<?php
include('partials-front/menu.php');  // Include the database connection file

if(isset($_POST['order_btn']))
{

    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];
    $near_by = $_POST['near_by'];

    $total = 0;  // Initialize total variable
    $itemsList = [];  // Initialize array to store items
    $pricesList = [];  // Initialize array to store prices
    $quantityList = [];  // Initialize array to store quantity

    if(isset($_SESSION['cart'])) 
    {
        foreach($_SESSION['cart'] as $key => $value) 
        {
            $sql = "SELECT * FROM tb_veggies WHERE id='$key'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $itemName = $row['title'];
            $itemPrice = $row['price'];
            $itemQuantity = $value['quantity'];
            $itemTotal = $itemPrice * $itemQuantity;
            
            $itemsList[] = $itemName;
            $pricesList[] = $itemTotal;
            $quantityList[] = $itemQuantity;
            
            $total += $itemTotal;
        }

        $itemsJson = json_encode($itemsList);  
        $priceJson = json_encode($pricesList);
        $quantityJson = json_encode($quantityList);

        $order_date = date("Y-m-d H:i:s");  // Set current date and time
        $status = 'ordered';  // Set default status

        $sqlInsert = "INSERT INTO tb_order SET 
                      item = '$itemsJson',
                      price = '$priceJson',
                      quantity = '$quantityJson',
                      total = '$total',
                      order_date = '$order_date',
                      status = '$status',
                      customer_name = '$name',
                      customer_contact = '$number',
                      customer_email = '$email',
                      flat = '$flat',
                      street = '$street',
                      city = '$city',
                      state = '$state',
                      country = '$country',
                      pin_code = '$pin_code',
                      near_by = '$near_by'"; 

        $res = mysqli_query($conn, $sqlInsert) or die(mysqli_error($conn));

        if($res)
        {
            echo "
            <div class='order-message-container'>
                <div class='message-container'>
                   <h3>Thank you for shopping!</h3>
                   <div class='order-detail'>
                      <span>Total : ₹".$total."/-  </span>
                   </div>
                   <div class='customer-details'>
                      <p>Your Name: <span>".$name."</span></p>
                      <p>Your Number: <span>".$number."</span></p>
                      <p>Your Email: <span>".$email."</span></p>
                      <p>Your Address: <span>".$flat.", ".$street.", ".$city.", ".$state.", ".$country." - ".$pin_code."</span></p>
                      <p>Near By: <span>".$near_by."</span></p>
                   </div>
                </div>
            </div>
            ";
            echo "<div class='error'>cart is empty.</div>";
            unset($_SESSION['cart']); // Clear the cart after order is placed
        } 
        else 
        {
            echo "<div class='error'>Failed to place order.</div>";
        }
    }
}
?>