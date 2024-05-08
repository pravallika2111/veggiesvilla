<?php include("partials/menu.php"); ?>
<style>
.tbl-30{
    width:40%;
}
</style>

<div class="main">
    <div class="wrapper">
    <br> 
    <h1>Veggies</h1>
    <br>
    <?php
        
        if(isset($_SESSION['upload-img'])){
            echo $_SESSION['upload-img'];
            unset($_SESSION['upload-img']);
        }
        ?><br>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td><label>Title: </label></td>
                    <td><input type="text" name="title" placeholder="Item Name"></input></td>
                </tr>
                <tr>
                    <td><label>Description: </label></td>
                    <td><textarea cols="22" rows="3" name="description" placeholder="Description"></textarea></td>
                </tr>
                <tr>
                    <td><label>Price: </label></td>
                    <td><input type="number" name="price"></input></td>
                </tr>
                <tr>
                <td><label>Select Image: </label></td>
                    <td><input type="file" name="img" ></td>
                </tr>
                <tr>
                    <td><label>Category: </label></td>
                    <td>
                        <select name="category">
                            <?php
                            //create php code to display categories from db
                            //create sql to get all active categories from db
                            $sql = "SELECT * FROM tb_category WHERE active='yes'";
                            $risk = mysqli_query($conn, $sql);
                            //count rows to check whether we have categories or not
                            $count = mysqli_num_rows($risk);
                            //if count>0 then we have categories
                            if($count>0){
                                while($row=mysqli_fetch_assoc($risk)){
                                    //get the details of category
                                    $id = $row['id'];
                                    $title=$row['title'];
                                    ?>
                                        

                                        <option value="<?php echo $id;?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            }
                            //else we donot have categories
                            else{
                                ?>
                                <option class='error' style='color:rgb(255,0,0);' value="0">No category found</option>
                                <?php
                            }
                            //display on dropdown
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label>Feature</label></td>
                    <td><input type="radio" name="feature" value="yes">yes
                    <input type="radio" name="feature" value="no">no</td>
                </tr>
                <tr>
                    <td><label>Active: </label></td>
                    <td><input type="radio" name="active" value="yes">yes
                        <input type="radio" name="active" value="no">no</td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add-Items" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        if(isset($_POST['submit'])){
            //add the data
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $description = mysqli_real_escape_string($conn,$_POST['description']);
            $price = $_POST['price'];
            $category = $_POST['category'];
            //check radio buttons are working or not
            if (isset($_POST['feature'])){
                //if button selected get values from form or set default
                $feature = $_POST['feature'];
            }
            else{
                $feature = 'no';//default value no
            }
            if (isset($_POST['active'])){
                $active = $_POST['active'];
            }
            else{
                $active = 'no';//default value no
            }
            //check whether image is selected or not
            if(isset($_FILES['img']['name'])){
                //name have value then upload img
                //to upload image we need img name, source path and destination path
                $img_name=$_FILES['img']['name'];
                //upload img only img is selected
                if($img_name!="")
                {
                    //if two images have same name then we need to auto rename the file
                    //get extension of the image like .jpg, .png, eg "chicken.jpg" divides into to parts chicken-1 jpg-1
                    $parts = explode('.', $img_name);
                    $ext = end($parts);
                    //adding date and time at the end of the image because it is unique forever
                    $current_datetime = date("YmdHis");
                    //rename the img
                    $img_name = "item_". str_replace(' ', '_', strtolower(basename($img_name, '.' . $ext))) . "_".rand(000,99999)."_" . $current_datetime . '.'.$ext;
                    //here the output img name is item_randomnumber between 000 to 999 and our extension .jpg is added at end (item_(....).jpg) 
                    $source_path = $_FILES['img']['tmp_name'];
        
                    $destination_path="../images/items/".$img_name;
                    //upload img
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check whether the img is uploaded or not
                    //if img is not uploaded stop the process and redirect with a msg
                    if($upload==false){
                        $_SESSION['upload-img']="<div class=error style='color:rgb(250,0,0)'>Failed to upload image</div>";
                        header("LOCATION: ". SITEURL . "admin/addveggies.php");
                        //stop the process
                        die();
                    }            
                }
            }
            else{
                //if not clicked img button shows blank
                $img_name="";
            }
        
            //create sql query to insert into db
            $sql2 = "INSERT INTO tb_veggies SET 
            title='$title', 
            description='$description',
            price=$price,
            img_name='$img_name',
            category_id='$category',
            feature='$feature', 
            active='$active'";
            
            //execute the query and save in database
            $risk2 = mysqli_query($conn, $sql2);
            
            //check data is adding or not into the table
            if ($risk2==true){
                session_start();
                //query executing and category added
                $_SESSION['add-item'] = "<div class='success' style='color:#5dac51;'> Item added successfully</div>";
                //redirect to manage category page
                header("LOCATION: " . SITEURL . "admin/managedesk-veggies.php");
                exit();
            }
            else{
                //fail to add category
                session_start();
                $_SESSION['failed-add-item'] = "<div class='error' style='color:rgb(255,0,0);'>Failed to add item</div>";
                header("LOCATION: " . SITEURL . "admin/managedesk-veggies.php");
                exit();
            }
        }
        
        ?> 
    </div>
</div>
<!--footer section start-->
<?php include("partials/footer.php");?>
<!--footer section end-->