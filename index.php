<?php include('partials-front/menu.php'); ?>

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
<?php
if(isset($_SESSION['order'])){
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}
?>
<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>
        <?php
        $sql="SELECT * FROM tb_category WHERE active='yes' AND feature='yes' LIMIT 3";
        $risk = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($risk);
        if($count >0){
            while($row=mysqli_fetch_assoc($risk)){
                $id = $row['id'];
                $title = $row['title'];
                $img_name = $row['img_name'];
                ?>
                <a href="<?php echo SITEURL?>category-items.php?category_id=<?php echo $id;?>" class="text-black">
                    <div class="box-3 float-container">
                        <?php 
                        if($img_name!=""){
                            ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $img_name;?>" 
                            alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                        else{
                            echo "<div class='error' style='color: rgb(250,0,0);'>Image not available</div>";
                        } ?>
                        <h3 class="float-text text-black"><?php echo $title;?></h3>
                    </div>
                </a>
                <?php
            }
        }
        else{
            echo "<div class='error' style='color: rgb(250,0,0);'>not available</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu</h2>
        <?php
            $sql1="SELECT * FROM tb_veggies WHERE active='yes' AND feature='yes' LIMIT 6";
            $risk1=mysqli_query($conn, $sql1);
            $count1=mysqli_num_rows($risk1);
            if($count1>0){
                while($row=mysqli_fetch_assoc($risk1)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $price = $row['price'];
                    $description=$row['description'];
                    $img_name=$row['img_name'];
                    ?>
                    <div class="food-menu-box" style="display: flex; align-items: left; justify-content: left;">
                        <div class="food-menu-img">
                            <?php
                                if($img_name=="")
                                {
                                    echo "<div class='error' style='color:white'>Image not Available</div>"; 
                                }
                                else{
                                    echo "<img src='".SITEURL."images/items/".$img_name."' alt='$title' class='img-responsive img-curve'>";
                                }?> 
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">₹<?php echo $price; ?></p>
                            <p class="food-detail"><?php echo $description;?></p> 
                            <div class="order-label">Quantity: 
                                <input type="number" name="quantity" min="1" style="width:25%" class="form-control" value="1" min="1" required>
                                <input type="hidden" name="item_id" value="<?php echo $id; ?>">
                            </div>
                            <br>
                            <button type="button" class="btn btn-primary addToCartButton" data-item-id="<?php echo $id; ?>"><i style='font-size:16px' class='fas'>&#xf217;</i> Add to cart</button>
                        </div>
                    </div>
                <?php
                }
            }
            else{
                echo "<div class='error' style='color:rgb(250,0,0); text-align:center;'>Item not Available</div>";
            }
        ?>
        
        <div class="clearfix"></div>
    </div>

    <p class="text-center">
        <a href="<?php echo SITEURL; ?>items.php">See All Foods</a>
    </p>
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
            }, 500); // 500 milliseconds = 0.5 seconds
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
