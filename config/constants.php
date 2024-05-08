<?php
//start session
    session_start();
    ini_set('max_execution_time',600);
    //create constant for non repeating values
    define('SITEURL','http://localhost:8081/order-items/');
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'Praallika@21');
    define('DB_NAME', 'veggies_villa');
    define('DB_PORT',3307);

    $conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME,DB_PORT);
    if (!$conn){
        die("Connection Failed: " . mysqli_connect_error());
    } 
    //db connection localhost is servername, username is root and password is Pravallika@21
    $db_selected = mysqli_select_db($conn, DB_NAME);
    if (!$db_selected){
        die("Database selection failed: " . mysqli_error($conn));
    }
    date_default_timezone_set('Asia/Kolkata'); // Set your time zone 
    //select data 
//mysqli_close($conn);
?>
