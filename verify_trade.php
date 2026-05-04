<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Please login to verify this trade.");
}

if (isset($_GET['hash'])) {
    $hash = mysqli_real_escape_string($conn, $_GET['hash']);
    $current_buyer = $_SESSION['user_id'];

    $query = "SELECT * FROM transactions WHERE unique_hash = '$hash' AND status = 'escrow' LIMIT 1";
    $run = mysqli_query($conn, $query);
    
    if ($run && mysqli_num_rows($run) > 0) {
        $trade = mysqli_fetch_assoc($run);
        
    
        if ($trade['buyer_id'] == $current_buyer) {
            $item_id = $trade['item_id'];
            
        
            mysqli_query($conn, "UPDATE transactions SET status = 'completed' WHERE unique_hash = '$hash'");
            
        
            mysqli_query($conn, "UPDATE products SET status = 'sold' WHERE product_id = '$item_id'");

            echo "<div style='text-align:center; padding:50px; font-family:sans-serif;'>
                    <h1 style='color:green;'> Trade Successful!</h1>
                    <p>The product status has been updated to SOLD.</p>
                    <a href='index.php' style='color:blue;'>Back to Market</a>
                  </div>";
        } else {
            echo "<h1> Unauthorized Buyer</h1><p>You are logged in as ID: $current_buyer, but this item belongs to Buyer ID: " . $trade['buyer_id'] . "</p>";
        }
    } else {
        echo "<h1> Invalid Code</h1><p>This trade may already be finished, or the hash doesn't match our records.</p>";
    }
}
?>