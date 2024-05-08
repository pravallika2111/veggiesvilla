<!--menu section start-->
<?php include("partials/menu.php");?>
<!--menu section ends-->
<style>
.tbl-30{
    width:30%;
}
</style>
<div class="main">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br>
        <?php 
        if(isset($_GET['id'])){
            // get id of selected admin
            $id = $_GET['id'];
            //create sql query
            $sql = "SELECT * FROM tb_category where id=?";
            //prepare the query
            $stmt = mysqli_prepare($conn, $sql);
            //bind the parameters
            mysqli_stmt_bind_param($stmt, 'i', $id);
            //execute query
            mysqli_stmt_execute($stmt);
            //get the result
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            
            if($row){
                $title = $row['title'];
                $current_img = $row['img_name'];
                $feature = $row['feature'];
                $active = $row['active'];
            }
            else{
                $_SESSION['No-category-found'] = "<div class='error' style='color:rgb(250,0,0);'>Category Not Found</div>";
                header("Location: " . SITEURL . 'admin/managedesk-caregory.php');
            }
        }
        else{
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-caregory.php');
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
        <table class="tbl-30">
                <tr>
                    <td><lable>Title:</lable></td>
                    <td><input type="text" name="title" value="<?php echo htmlspecialchars($title);?>"></td>
                </tr>
                <tr>
                    <td><lable>Current Image:</lable></td>
                    <td><?php
                        if($current_img != ""){
                            //display img
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_img; ?>" width="100px">
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
                        <input type="submit" name="submit" value="Update-category" class="btn-secondary">
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
        $current_img = $_POST['current_img'];
        $feature = $_POST['feature'];
        $active = $_POST['active'];

        // Check if new image is selected
        if(isset($_FILES['new_img']['name'])){
            $new_img_name = $_FILES['new_img']['name'];

            // Check whether the file is selected or not
            if($new_img_name != ""){
                // Upload the new image
                $ext = end(explode('.', $new_img_name));
                $new_img_name = "veggie_" . rand(000,99999) . "_" . date("YmdHis") . "." . $ext;

                $source_path = $_FILES['new_img']['tmp_name'];
                $destination_path = "../images/category/".$new_img_name;

                $upload = move_uploaded_file($source_path, $destination_path);

                if($upload == false){
                    $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                    header("Location: " . SITEURL . 'admin/managedesk-category.php');
                    exit();
                }

                // Remove current image if exists
                if($current_img != ""){
                    $remove_path = "../images/category/".$current_img;
                    $remove = unlink($remove_path);

                    if($remove == false){
                        $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                        header("Location: " . SITEURL . 'admin/managedesk-category.php');
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
        $sql2 = "UPDATE tb_category SET 
        title ='$title',
        img_name = '$new_img_name',
        feature ='$feature', 
        active='$active'
        WHERE id = '$id'";

        //execute the query
        $risk2 =mysqli_query($conn, $sql2);
        //check whether the query sucessfully executed or not
        if ($risk2==true){
            // query executed that updated admin successfully
            session_start();
            $_SESSION['update']="<div class='success' style='color:#5dac51;'>Category Updated successfully.</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-category.php');
            exit();
        }
        else{
            //failed to update admin
            session_start();
            $_SESSION['update']="<div class='error' style='color:rgb(255,0,0)'>Failed to Update Category, Try again..!</div>";
            //redirect page to manage admin
            header("Location: " . SITEURL . 'admin/managedesk-category.php');
            exit();
        }
    }?>
    </div>
</div>

<!--footer section start-->
<?php include("partials/footer.php")?>
<!--footer section end-->