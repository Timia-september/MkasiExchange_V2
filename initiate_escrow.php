<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to secure an item.'); window.location='login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = mysqli_real_escape_string($conn, $_POST['item_id']);
    $buyer_id = $_SESSION['user_id'];
    $hash = bin2hex(random_bytes(16));

    
    $item_query = "SELECT user_id FROM products WHERE product_id = '$item_id' LIMIT 1";
    $item_result = mysqli_query($conn, $item_query);

    if ($item_result && mysqli_num_rows($item_result) > 0) {
        $item_data = mysqli_fetch_assoc($item_result);
        $seller_id = $item_data['user_id'];

        $escrow_query = "INSERT INTO transactions (item_id, buyer_id, seller_id, unique_hash, status) 
                         VALUES ('$item_id', '$buyer_id', '$seller_id', '$hash', 'escrow')";
        
        if (mysqli_query($conn, $escrow_query)) {
            mysqli_query($conn, "UPDATE products SET status = 'pending' WHERE product_id = '$item_id'");
            
            echo "<script>alert('Success! Item secured in Escrow.'); window.location='index.php';</script>";
        } else {
            die("Database Error: " . mysqli_error($conn));
        }
    } else {
        die("Error: Product not found in database.");
    }
}
?>