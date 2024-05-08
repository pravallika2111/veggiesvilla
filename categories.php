<?php include('partials-front/menu.php'); ?>

    <!-- Categories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Items</h2> 
            <?php
            //to access categories
            $sql = "SELECT * FROM tb_category WHERE active='yes'";
            $risk = mysqli_query($conn, $sql);
            //count to show categories
            $count = mysqli_num_rows($risk);
            if ($count > 0) {
                while ($row = mysqli_fetch_assoc($risk)) {
                    //get the values like title image, name, id 
                    $id = $row['id'];
                    $title = htmlspecialchars($row['title']);
                    $img_name = $row['img_name'];
                    ?>
                    <a href="<?php echo htmlspecialchars(SITEURL); ?>category-items.php?category_id=<?php echo htmlspecialchars($id); ?>">
                        <div class="box-3 float-container">
                            <?php 
                            //check whether img is available or not
                            if ($img_name != "") {
                                ?>
                                <img src="<?php echo htmlspecialchars(SITEURL); ?>images/category/<?php echo htmlspecialchars($img_name); ?>" 
                                alt="<?php echo htmlspecialchars($title); ?>" class="img-responsive img-curve">
                                <?php
                            } else {
                                echo "<div class='error' style='color: rgb(250,0,0);'>Image not available</div>";
                            } ?>
                            
                            <h3 class="float-text text-black" ><?php echo $title; ?></h3>
                        </div>
                    </a>
                    <?php
                }
            } else {
                echo "<div class='error' style='color: rgb(250,0,0);'>Not available</div>";
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>
