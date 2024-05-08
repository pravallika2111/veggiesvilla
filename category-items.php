<?php include('partials-front/menu.php'); ?>

<?php
//check whether id passed or not
    if(isset($_GET['category_id']))
    {
        $category_id = $_GET['category_id'];
        $sql = "SELECT title FROM tb_category WHERE id=$category_id";
        $risk=mysqli_query($conn, $sql);
        $row=mysqli_fetch_assoc($risk);
        $category_title=$row['title'];
    }
    else
    {
        //category not passed redirect
        header('LOCATION:'.SITEURL);
    }
?>
<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="co">
        <form action="<?php echo SITEURL;?>search-item.php" method="POST" style="display: flex; align-items: center; justify-content: center; ">
        <input type="search" name="search" style="width:40%" placeholder="Search for Food.." required>
        <input type="submit" name="submit" value="Search" style="width:10%"class="btn btn-primary" style="margin-left: 10px;">
    </form>
    </div>
</section>
<br><br>
<!-- fOOD sEARCH Section Ends Here -->


    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Items Menu</h2>
            <?php
                $sql2= "SELECT * FROM tb_veggies WHERE category_id=$category_id";
                $risk2=mysqli_query($conn, $sql2);
                $count2=mysqli_num_rows($risk2);
                //check whether food is available or not
                if($count2>0){
                    while($row2=mysqli_fetch_assoc($risk2))
                    {
                        $id = $row2['id'];
                        $title=$row2['title'];
                        $price=$row2['price'];
                        $description=$row2['description'];
                        $img_name=$row2['img_name'];
                        ?>
                        <div class="food-menu-box" style="display: flex; align-items: left; justify-content: left;">
                    <div class="food-menu-img">
                    <?php 
                    if($img_name == "") {
                        echo "<div class='error' style='color:white'>Image not available</div>";
                    } else {
                    ?>
                        <img src="<?php echo SITEURL;?>images/items/<?php echo $img_name;?>" class="img-responsive img-curve">
                    <?php
                    }
                    ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title;?></h4>
                        <p class="food-price">₹<?php echo $price;?></p>
                        <p class="food-detail"><?php echo $description;?></p>
                        <div class="order-label">Quantity: 
                            <input type="number" name="quantity" min="1" style="width:25%" class="form-control" value="1" min="1" required>
                            <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                        </div>
                        <br><br>
                        <button type="button" class="btn btn-primary addToCartButton" data-item-id="<?php echo $id; ?>"><i style='font-size:16px' class='fas'>&#xf217;</i> Add to cart</button>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='error' style='color:rgb(250,0,0)'>Items not available</div>";
        }
        ?>
        
        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(".addToCartButton").click(function(){
            var quantity = $(this).closest('.food-menu-desc').find("input[name='quantity']").val();
            var item_id = $(this).data("item-id");
            
            $.ajax({
                url: "<?php echo SITEURL; ?>addtocart.php",
                method: "POST",
                data: {
                    quantity: quantity,
                    item_id: item_id
                },
                success: function(response){
                    showNotification("Item added to cart");
                },
                error: function(){
                    showNotification("Error adding item to cart");
                }
            });
        });
        
        function showNotification(message) {
            var notification = `
                <div class="custom-notification">
                    <p>${message}</p>
                </div>
            `;
            
            $("body").append(notification);
            
            setTimeout(function(){
                $(".custom-notification").fadeOut("slow", function(){
                    $(this).remove();
                });
            }, 500); // 2000 milliseconds = 2 seconds
        }
    });
</script>

<style>
    .custom-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: rgba(0, 128, 0, 0.7);
        color: #fff;
        padding: 15px 20px;
        border-radius: 5px;
        z-index: 9999;
        animation: fadeInOut 0.5s;
    }

    @keyframes fadeInOut {
        0% { opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { opacity: 0; }
    }
</style>

<?php include('partials-front/footer.php'); ?>
