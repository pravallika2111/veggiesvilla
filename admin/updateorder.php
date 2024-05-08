<?php 
include("partials/menu.php");
// Check if form is submitted
if(isset($_POST['submit'])){
    $id=mysqli_real_escape_string($conn,$_POST['id']);
    $status=mysqli_real_escape_string($conn,$_POST['status']);
    $customer_name=mysqli_real_escape_string($conn,$_POST['customer_name']);
    $customer_contact=mysqli_real_escape_string($conn,$_POST['customer_contact']);
    $customer_email=mysqli_real_escape_string($conn,$_POST['customer_email']);
    $flat=mysqli_real_escape_string($conn,$_POST['flat']);
    $street=mysqli_real_escape_string($conn,$_POST['street']);
    $city=mysqli_real_escape_string($conn,$_POST['city']);
    $state=mysqli_real_escape_string($conn,$_POST['state']);
    $country=mysqli_real_escape_string($conn,$_POST['country']);
    $pin_code=mysqli_real_escape_string($conn,$_POST['pin_code']);
    $near_by=mysqli_real_escape_string($conn,$_POST['near_by']);
    
    // Update the order details
    $sql2="UPDATE tb_order SET
    status='$status',
    customer_name='$customer_name',
    customer_contact='$customer_contact',
    customer_email='$customer_email',
    flat = '$flat',
    street = '$street',
    city = '$city',
    state = '$state',
    country = '$country',
    pin_code = '$pin_code',
    near_by = '$near_by' WHERE id=$id";
    
    $risk2=mysqli_query($conn,$sql2);
    if($risk2==true){
        $_SESSION['update'] = "<div class='success' style='color:#5dac51;'>Successfully updated Order.</div>";
        header('LOCATION:'.SITEURL.'admin/managedesk-orders.php');
        exit; // Exit to prevent further execution
    }
    else{
        $_SESSION['update'] = "<div class='error' style='color:rgb(255,0,0)'>Failed to update Order.</div>";
        header('LOCATION:'.SITEURL.'admin/managedesk-orders.php');
        exit; // Exit to prevent further execution
    }
}

// Fetch order details
if(isset($_GET['id'])){
    $id=$_GET['id'];
    $sql="SELECT * FROM tb_order WHERE id=$id";
    $risk=mysqli_query($conn,$sql);
    $count=mysqli_num_rows($risk);
    if($count==1){
        $row=mysqli_fetch_assoc($risk);
        $item=$row['item'];
        $price=$row['price'];
        $quantity=$row['quantity'];
        $total=$row['total'];
        $status=$row['status'];
        $customer_name=$row['customer_name'];
        $customer_contact=$row['customer_contact'];
        $customer_email=$row['customer_email'];
        $flat = $row['flat'];
        $street = $row['street'];
        $city = $row['city'];
        $state = $row['state'];
        $country = $row['country'];
        $pin_code = $row['pin_code'];
        $near_by = $row['near_by']; 
    }
    else{
        $_SESSION['details']="<div class=error style='color:rgb(250,0,0)'>Details not available</div>";
        header("LOCATION: ". SITEURL . "admin/managedesk-orders.php");
        exit; // Exit to prevent further execution
    }
}
else{
    header('LOCATION:'.SITEURL.'admin/managedesk-orders.php');
    exit; // Exit to prevent further execution
}

?>

<style>
.tbl-30{
    width:30%;
}
</style>
<!--main section starts-->
<div class="main">
    <div class="wrapper">
        <h1>Update Orders</h1>
        <br><br>
        <?php
        if(isset($_SESSION['details'])){
            echo $_SESSION['details'];
            unset($_SESSION['details']);
        }
        ?>
        <br><br>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Item</td>
                    <td><b><?php echo $item;?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td><b>₹<?php echo $price;?></b></td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td><b><?php echo $quantity;?></b></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td><b><?php echo $total;?></b></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="ordered"){echo "selected";} ?> value="ordered">Ordered</option>
                            <option <?php if($status=="shipped"){echo "selected";} ?> value="shipped">Shipped</option>
                            <option <?php if($status=="delivered"){echo "selected";} ?> value="delivered">Delivered</option>
                            <option <?php if($status=="cancelled"){echo "selected";} ?> value="cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td><input type="text" name="customer_name" value="<?php echo htmlspecialchars($customer_name);?>"></td>
                </tr>
                <tr>
                    <td>Customer Number:</td>
                    <td><input type="text" name="customer_contact" value="<?php echo htmlspecialchars($customer_contact);?>"></td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td><input type="text" name="customer_email" value="<?php echo htmlspecialchars($customer_email);?>"></td>
                </tr>
                <tr>
                    <td>Flat:</td>
                    <td><textarea name="flat" rows='1' cols='22'><?php echo htmlspecialchars($flat);?></textarea></td>
                </tr>
                <tr>
                    <td>Street:</td>
                    <td><textarea name="street" rows='1' cols='22'><?php echo htmlspecialchars($street);?></textarea></td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td><textarea name="city" rows='1' cols='22'><?php echo htmlspecialchars($city);?></textarea></td>
                </tr>
                <tr>
                    <td>State:</td>
                    <td><textarea name="state" rows='1' cols='22'><?php echo htmlspecialchars($state);?></textarea></td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td><textarea name="country" rows='1' cols='22'><?php echo htmlspecialchars($country);?></textarea></td>
                </tr>
                <tr>
                    <td>Pin Code:</td>
                    <td><textarea name="pin_code" rows='1' cols='22'><?php echo htmlspecialchars($pin_code);?></textarea></td>
                </tr>
                <tr>
                    <td>Near by:</td>
                    <td><textarea name="near_by" rows='2' cols='22'><?php echo htmlspecialchars($near_by);?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="price" value="<?php echo $price;?>">
                        <input type="hidden" name="quantity" value="<?php echo $quantity;?>">
                        <input type="hidden" name="item" value="<?php echo htmlspecialchars($item);?>">
                        <input type="hidden" name="total" value="<?php echo $total;?>">
                        <input class="btn-secondary" type="submit" name="submit" value="Update Order">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<!--main section ends-->

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->
