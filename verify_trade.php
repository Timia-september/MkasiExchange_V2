<?php
include 'db_config.php';
include 'languages.php'; 
session_start();
global $words; 

if (!isset($_SESSION['user_id'])) {
    die("Please login to verify this trade.");
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Verify Trade - MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>

    <div class="container mt-5 text-center">
        <?php
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
                    
                    mysqli_query($conn, "UPDATE products SET status = 'sold' WHERE id = '$item_id'");

                    echo "<div class='card shadow-sm p-5 border-0'>
                            <h1 class='text-success fw-bold'>" . ($words['trade_complete'] ?? 'Trade Successful!') . "</h1>
                            <p class='text-muted'>" . ($words['status_sold'] ?? 'The product status has been updated to SOLD.') . "</p>
                            <div class='mt-4'>
                                <a href='index.php' class='btn btn-primary px-4'>" . ($words['back_market'] ?? 'Back to Market') . "</a>
                            </div>
                          </div>";
                } else {
                    echo "<div class='alert alert-danger'>
                            <h4>Unauthorized</h4>
                            <p>You do not have permission to verify this specific trade.</p>
                          </div>";
                }
            } else {
                echo "<div class='alert alert-warning'>
                        <h4>" . ($words['err_user'] ?? 'Invalid or Expired') . "</h4>
                        <p>This trade may already be finished or the code is incorrect.</p>
                        <a href='index.php' class='btn btn-outline-secondary mt-3'>Back Home</a>
                      </div>";
            }
        }
        ?>
    </div>
</body>
</html>