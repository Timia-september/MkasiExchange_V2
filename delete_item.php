<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];
    $is_admin = (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin');

    $res = mysqli_query($conn, "SELECT user_id, image_path FROM products WHERE id='$id'");
    $item = mysqli_fetch_assoc($res);

    if ($item) {
        if ($item['user_id'] == $user_id || $is_admin) {
            
            
            if (file_exists($item['image_path'])) {
                unlink($item['image_path']); 
            }

            $query = "DELETE FROM products WHERE id='$id'";
            
            if (mysqli_query($conn, $query)) {
                if ($is_admin) {
                    header("Location: admin_dashboard.php?msg=deleted");
                } else {
                    header("Location: profile.php?msg=deleted");
                }
                exit();
            } else {
                echo "Error deleting: " . mysqli_error($conn);
            }
        } else {
            die("Unauthorized: You cannot delete someone else's item.");
        }
    } else {
        die("Item not found.");
    }
}
?>