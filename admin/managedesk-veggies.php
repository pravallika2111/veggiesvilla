<!--menu section start-->
<?php include("partials/menu.php")?>
<!--menu section ends-->

<!--main section starts-->
<div class="main">
    <div class="wrapper">
        <h1>Manage Veggies</h1>
        <br><br>
        <?php
        if(isset($_SESSION['add-item'])){
            echo $_SESSION['add-item'];
            unset($_SESSION['add-item']);
        }
        if(isset($_SESSION['failed-add-item'])){
            echo $_SESSION['failed-add-item'];
            unset($_SESSION['failed-add-item']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }
        if(isset($_SESSION['No-item-found'])){
            echo $_SESSION['No-item-found'];
            unset($_SESSION['No-item-found']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        if(isset($_SESSION['failed-remove'])){
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        if(isset($_SESSION['update1'])){
            echo $_SESSION['update1'];
            unset($_SESSION['update1']);
        }
        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        ?>
        <br><br>
                <a href="<?php echo SITEURL;?>admin/addveggies.php" class="btn-primary">Add Veggies</a>
                
                <br><br><br><br>
                <table class="table-design">
                    <tr>
                        <th>SI.NO</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Feature</th>
                        <th>Active</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    ini_set('display_errors',1);
                        $sql = "SELECT * FROM tb_veggies";
                        $risk = mysqli_query($conn, $sql);
                        if ($risk){
                            $count = mysqli_num_rows($risk);
                            if($count>0){
                                //hae data in data base
                                $n=1;
                                while($rows=mysqli_fetch_assoc($risk)){
                                
                                    $id=$rows['id'];
                                    $title=$rows['title'];
                                    $description = $rows['description'];
                                    $price = $rows['price'];
                                    $img_name=$rows['img_name'];
                                    $category_id = $rows['category_id'];
                                    $feature=$rows['feature'];
                                    $active=$rows['active'];

                                    // Fetch category details
                                    $sql_category = "SELECT title FROM tb_category WHERE id = $category_id";
                                    $result_category = mysqli_query($conn, $sql_category);
                                    $row_category = mysqli_fetch_assoc($result_category);
                                    $category_name = isset($row_category['title']) ? $row_category['title'] : 
                                    '<div class="error" style="color:rgb(250,0,0);">Category not found</div>';?>
                                    <tr>
                                    <td><?php echo $n++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo $description; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td>
                                        <?php 
                                        if($img_name!=""){
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/items/<?php echo $img_name?>" width="100px">
                                        <?php

                                        } 
                                        else{
                                            echo "<div class='error' style='color:rgb(250,0,0);'> Image not Added</div>";
                                        }?>
                                    </td>
                                    <td><?php echo $category_name; ?></td>
                                    <td><?php echo $feature; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/updateitems.php?id=<?php echo $id;?>" class="btn-secondary">Update Item</a>
                                        <a href="<?php echo SITEURL;?>admin/deleteitems.php?id=<?php echo $id; ?>&img_name=<?php echo $img_name; ?>"class='btn-danger'>Delete Item</a>
                                        
                                    </td>
                                    </tr>
                            
                                    <?php

                                }
                            }
                            else{
                                ?>
                                
                                <tr><td colspan='7'><div class="error" style='color:rgb(250,0,0);'> NO Item added</div></td></tr>
                                <?php
                            }

                        }
                        
        

                    ?>

                </table>
    </div>
</div>
<!--main section ends-->

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->