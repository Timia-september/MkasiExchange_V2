<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    
    $res = mysqli_query($conn, "SELECT image_path FROM products WHERE product_id='$id'");
    $row = mysqli_fetch_assoc($res);
    if($row && file_exists($row['image_path'])) {
        unlink($row['image_path']); 
    }

    
    $query = "DELETE FROM products WHERE product_id='$id'";
    
    if (mysqli_query($conn, $query)) {
        header("Location: admin_dashboard.php?msg=deleted");
    } else {
        echo "Error deleting: " . mysqli_error($conn);
    }
}
?>