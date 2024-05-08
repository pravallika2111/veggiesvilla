<!--menu section start-->
<?php ob_start(); ?>
<?php include("partials/menu.php");?>
<!--menu section ends-->

<style>
.tbl-30{
    width:40%;
}
</style>
<div class="main">
    <div class="wrapper">
        <h1>Update Item</h1>
        <br>
        <?php 
        if(isset($_GET['id'])){
            // get id of selected admin
            $id = $_GET['id'];
            //create sql query
            $sql2 = "SELECT * FROM tb_veggies where id=$id";
            $risk2 = mysqli_query($conn, $sql2);

            //check whether the categeory is aailabe or not
            $row2 = mysqli_fetch_assoc($risk2);
            //get individual values
            $id = $row2['id'];
            $title = $row2['title'];
            $description = $row2['description'];
            $price = $row2['price'];
            $current_img = $row2['img_name'];
            $current_category = $row2['category_id'];
            $feature = $row2['feature'];
            $active = $row2['active'];
        }
        else{
            //redirect page to manage admin
            header("Location:".SITEURL.'admin/managedesk-veggies.php');
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td><lable>Title:</lable></td>
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>"></td>
                </tr>
                    <td><lable>Description:</lable></td>
                    <td><textarea cols="22" rows="3" name="description" ><?php echo htmlspecialchars($description); ?></textarea></td>
                </tr>
                <tr>
                <tr>
                    <td><lable>Price:</lable></td>
                    <td><input type="number" name="price" value="<?php echo htmlspecialchars($price); ?>"></td>
                </tr>
                <tr>
                    <td><lable>Current Image:</lable></td>
                    <td><?php
                        if($current_img != ""){
                            //display img
                        ?>
                            <img src="<?php echo SITEURL; ?>images/items/<?php echo $current_img; ?>" width="100px">
                        <?php
                        }
                        else{
                            //display msg
                            echo "<div class='error' style='color:rgb(255,0,0)'>Initially there is no image</div>";
                        }
                    ?></td>
                </tr>
                <tr>
                    <td><lable>New Image:</lable></td>
                    <td><input type="file" name="new_img"></td>
                </tr>
                
                <tr>
                    <td><label>Category: </label></td>
                    <td>
                        <select name="category">
                        <?php 
                                //create php code to display categories from db
                                //create sql to get all active categories from db
                                $sql1 = "SELECT * FROM tb_category WHERE active='yes'";
                                $risk1 = mysqli_query($conn, $sql1);
                                //count rows to check whether we have categories or not
                                $count1 = mysqli_num_rows($risk1);
                                //if count>0 then we have categories
                                if($count1>0)
                                {
                                    while($row=mysqli_fetch_assoc($risk1))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = $row['id'];
                                        ?>
                                        <option value='<?php echo $category_id;?>'><?php echo $category_title; ?></option>
                                        <?php
                                        
                                    }
                                }       
                                else{
                                    ?> <option class='error' style='color:rgb(255,0,0);' value='0'>No category found</option>"<?php
                                }                               
                            ?>
                            
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><lable>Feature:</lable></td>
                    <td><input type="radio" name="feature" value="yes" <?php if ($feature == 'yes') { echo "checked"; } ?>>yes
                    <input type="radio" name="feature" value="no" <?php if ($feature == 'no') { echo "checked"; } ?>>no</td>
                </tr>
                <tr>
                    <td><lable>Action:</lable></td>
                    <td><input type="radio" name="active" value="yes" <?php if ($active == 'yes') { echo "checked"; } ?>>yes
                    <input type="radio" name="active" value="no" <?php if ($active == 'no') { echo "checked"; } ?>>no</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="hidden" name="current_img" value="<?php echo $current_img;?>">
                        <input type="submit" name="submit" value="Update Item" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        //check whether submit button clicked or not
        if(isset($_POST['submit'])){
            //get all the data form to update
            $id = $_POST['id'];
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            $price = $_POST['price'];
            $current_img = $_POST['current_img'];
            $current_category=$_POST['category'];
            $feature = $_POST['feature'];
            $active = $_POST['active'];

            // Check if new image is selected
            if(isset($_FILES['new_img']['name'])){
                $new_img_name = $_FILES['new_img']['name'];

                // Check whether the file is selected or not
                if($new_img_name != ""){
                    // Upload the new image
                    $extArray = explode('.', $new_img_name);
                    $ext = end($extArray);

                    $new_img_name = "item_" . rand(000,99999) . "_" . date("YmdHis") . "." . $ext;

                    $source_path = $_FILES['new_img']['tmp_name'];
                    $destination_path = "../images/items/".$new_img_name;

                    $upload = move_uploaded_file($source_path, $destination_path);

                    if($upload == false){
                        $_SESSION['upload'] = "<div class='error' style='color:rgb(255,0,0)'>Failed to upload new image.</div>";
                        header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
                        exit();
                    }

                    // Remove current image if exists
                    if($current_img != ""){
                        $remove_path = "../images/items/".$current_img;
                        $remove = unlink($remove_path);

                        if($remove == false){
                            $_SESSION['failed-remove'] = "<div class='error' style='color:rgb(255,0,0)'>Failed to remove current image.</div>";
                            header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
                            exit();
                        }
                    }
                }
                else{
                    $new_img_name = $current_img;
                }
            }
            else{
                $new_img_name = $current_img;
            }

            //prepare the sql query
            $sql3 = "UPDATE tb_veggies SET 
            title ='$title',
            description = '$description',
            price = $price,
            img_name = '$new_img_name',
            category_id = '$current_category',
            feature ='$feature', 
            active='$active'
            WHERE id = $id";

            //execute the query
            $risk3 = mysqli_query($conn, $sql3);
            //check whether the query sucessfully executed or not
            if ($risk3==true){
                // query executed that updated admin successfully
                $_SESSION['update1']="<div class='success' style='color:#5dac51;'>Item Updated successfully.</div>";
                header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
                exit();
            }
            else{
                //failed to update admin
                session_start();
                $_SESSION['update']="<div class='error' style='color:rgb(255,0,0)'>Failed to Update Item, Try again..!</div>";
                //redirect page to manage admin
                header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
                exit();
            }
        } ob_end_flush();?>
    </div>
</div>

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->