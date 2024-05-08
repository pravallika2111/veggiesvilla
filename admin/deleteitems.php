<!--menu section start-->
<?php 
include("../config/constants.php");

if(isset($_GET['id']) && isset($_GET['img_name'])){
    $id = $_GET['id'];
    $img_name = $_GET['img_name'];

    // Remove image file if it exists
    if($img_name != ""){
        $remove_path = "../images/items/".$img_name;
        if(file_exists($remove_path)){
            $remove = unlink($remove_path);
            if($remove == false){
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image.</div>";
                header("Location: " . SITEURL . 'admin/managedesk-category.php');
                die();
            }
        }
    }

    // Check the SQL Query
    $sql = "DELETE FROM tb_veggies WHERE id=$id";
    $risk = mysqli_query($conn, $sql);

    if($risk==true){
        $_SESSION['delete'] = "<div class='success' style='color:#5dac51;'>Item Deleted Successfully.</div>";
        header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
        exit();
    }
    else{
        $_SESSION['delete'] = "<div class='error' style='color:rgb(255,0,0)'>Failed to Delete Item " . mysqli_error($conn) . "</div>";
        header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
        exit();
    }
}
else{
    $_SESSION['delete'] = "<div class='error' style='color:rgb(255,0,0)'>ID or Image Name not set.</div>";
    header("Location: " . SITEURL . 'admin/managedesk-veggies.php');
    exit();
}
?>
