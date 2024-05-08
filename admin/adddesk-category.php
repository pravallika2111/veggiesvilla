<?php
include("partials/menu.php");
?>
<style>
.tbl-30{
    width:30%;
}
</style>
<div class="main">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br>
        <?php
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br> 
        <form action="" method="post" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td><label>Title: </label></td>
                    <td><input type="text" name="title" placeholder="Category Name"></input></td>
                </tr>
                <tr>
                <td><label>Select image: </label></td>
                    <td><input type="file" name="img" ></td>
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
                        <input type="submit" name="submit" value="Add-Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    <?php
    //process the value and save in database
    //check wheather the button is clicked or not
        if(isset($_POST['submit']))
        {
            //button clicked
            // obtin values of the form
            $title = mysqli_real_escape_string($conn,$_POST['title']);
            //check radio buttons are working or not
            if (isset($_POST['feature'])){
                //if button selected get values from form or set default
                $feature = $_POST['feature'];
            }
            else{
                $feature = 'no';
            }
            if (isset($_POST['active'])){
                $active = $_POST['active'];
            }
            else{
                $active = 'no';
            }
            //check whether image is selected or not
            //print_r($_FILES['img']); in place if echo i used print_r because echo won't shows the value of array
            //die();

            if(isset($_FILES['img']['name'])){
                //name have value then upload img
                //to upload image we need img name, source path and destination path
                $img_name=$_FILES['img']['name'];
                //upload img only img is selected
                if($img_name!="")
                {
                    //if two images have same name then we need to auto rename the file
                    //get extension of the image like .jpg, .png, eg "chicken.jpg" divides into to parts chicken-1 jpg-1
                    $ext = end(explode('.', $img_name));
                    //adding date and time at the end of the image because it is unique forever
                    $current_datetime = date("YmdHis");
                    //rename the img
                    $img_name = "category_". str_replace(' ', '_', strtolower(basename($img_name, '.' . $ext))) . "_".rand(000,99999)."_" . $current_datetime . '.'.$ext;
                    //here the output img name is category_randomnumber between 000 to 999 and our extension .jpg is added at end (category_(....).jpg) 
                    $source_path = $_FILES['img']['tmp_name'];

                    $destination_path="../images/category/".$img_name;
                    //upload img
                    $upload = move_uploaded_file($source_path, $destination_path);
                    //check whether the img is uploaded or not
                    //if img is not uploaded stop the process and redirect with a msg
                    if($upload==false){
                        $_SESSION['upload']="<div class=error style='color:rgb(250,0,0)'>Faile to upload image</div>";
                        header("LOCATION: ". SITEURL . "admin/adddesk-category.php");
                        //stope the process
                        die();
                    }            
                }
            }
            else{
                //don't upload img
                $img_name="";
            }

            //create sql query to insert into db
            $sql = "INSERT INTO tb_category SET title='$title', img_name='$img_name', feature = '$feature', active='$active'";
            //execute the query and save in database
            $risk = mysqli_query($conn, $sql);
            //check data is adding or not into the table
            if ($risk==true){
                session_start();
                //query executing and category added
                $_SESSION['add'] = "<div class='success' style='color:#5dac51;'>Category added successfully</div>";
                //redirect to manage category page
                header("LOCATION: " . SITEURL . "admin/managedesk-category.php");
                exit();
            }
            else{
                //fail to add category
                session_start();
                $_SESSION['add'] = "<div class='error' style='color:rgb(255,0,0);'>Failed to add Category</div>";
                header("LOCATION: " . SITEURL . "admin/adddesk-category.php");
                exit();
            }
        }
    ?>
    </div>
</div>
<?php
include("partials/footer.php");
?>
