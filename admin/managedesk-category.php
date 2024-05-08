<!--menu section start-->
<?php include("partials/menu.php");?>
<!--menu section ends-->

<!--main section starts-->
<div class="main">
    <div class="wrapper">
        <h1>Category</h1>
        <br>
        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['No-category-found'])){
            echo $_SESSION['No-category-found'];
            unset($_SESSION['No-category-found']);
        }
        if(isset($_SESSION['remove'])){
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }
        if(isset($_SESSION['delete'])){
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);}

        if(isset($_SESSION['update'])){
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }
        if(isset($_SESSION['failed-remove'])){
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?><br><br>
                <a href="<?php echo SITEURL;?>admin/adddesk-category.php" class="btn-primary">Add Category</a>
                
                <br><br><br><br>
                <table class="table-design">
                    <tr>
                        <th>SI.NO</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Feature</th>
                        <th>Active</th>
                        <th>Actions<th>
                    </tr>
                    
                    <?php
                    ini_set('display_errors',1);
                        $sql = "SELECT * FROM tb_category";
                        $risk = mysqli_query($conn, $sql);
                        if ($risk){
                            $count = mysqli_num_rows($risk);
                            if($count>0){
                                //hae data in data base
                                $n=1;
                                while($rows=mysqli_fetch_assoc($risk)){
                                
                                    $id=$rows['id'];
                                    $title=$rows['title'];
                                    $img_name=$rows['img_name'];
                                    $feature=$rows['feature'];
                                    $active=$rows['active'];
                                    ?>
                                    <tr>
                                    <td><?php echo $n++; ?></td>
                                    <td><?php echo $title ?></td>
                                    <td>
                                        <?php 
                                        if($img_name!=""){
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $img_name?>" width="100px">
                                        <?php

                                        } 
                                        else{
                                            echo "<div class='error' style='color:rgb(250,0,0);'> Image not Added</div>";
                                        }?>
                                    </td>
                                    <td><?php echo $feature ?></td>
                                    <td><?php echo $active?></td>
                                    <td>
                                        <a href="<?php echo SITEURL;?>admin/updatecategory.php?id=<?php echo $id;?>" class="btn-secondary">Update Category</a>
                                        <a href="deletedesk-category.php?id=<?php echo $id; ?>&img_name=<?php echo $img_name; ?>"class="btn-danger">Delete Category</a>
                                        
                                    </td>
                                    </tr>
                            
                                    <?php

                                }
                            }
                            else{
                                ?>
                                
                                <tr><td colspan='4'><div class="error" style='color:rgb(250,0,0);'> NO Category added</div></td></tr>
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