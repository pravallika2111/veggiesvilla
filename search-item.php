<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            
            <h2>Item on Your Search <a href="#" class="text-white"><?php echo $search;?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php 
                //get search key word
                //sql query to get food based on search
                $sql = "SELECT * FROM tb_veggies WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
                //execute the query
                $risk = mysqli_query($conn, $sql);
                //count rows
                $count=mysqli_num_rows($risk);
                if($count>0){
                    while($row=mysqli_fetch_assoc($risk))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $img_name = $row['img_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    //chech whether the image is available or not
                                    if ($img_name==""){
                                        //
                                        echo "<div class='error' style='color:rgb(250,0,0)'>Image not Available</di>";
                                    }
                                    else{
                                    ?>
                                    <img src="<?php echo SITEURL;?>images/items/<?php echo $img_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                    <?php
                                    } 
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title;?></h4>
                                <p class="food-price">₹<?php echo $price;?></p>
                                <p class="food-detail"><?php echo $description;?></p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?item_id=<?php echo $id;?>" class="btn btn-primary">Order Now</a>
                                <a href="<?php echo SITEURL; ?>addtocart.php?item_id=<?php echo $id;?>" class="btn btn-primary"><i style='font-size:16px' class='fas'>&#xf217; Add to cart</i></a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    echo "<div class='error' style='color: rgb(250,0,0);'> Item not found </div>";
                }
            ?>

            

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>