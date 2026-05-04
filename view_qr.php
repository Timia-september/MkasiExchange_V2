<?php
include 'db_connect.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    die("Please login to view your trade QR codes.");
}

$seller_id = $_SESSION['user_id'];

$query = "SELECT t.*, p.item_name 
          FROM transactions t 
          JOIN products p ON t.item_id = p.product_id 
          WHERE t.seller_id = '$seller_id' AND t.status = 'escrow' 
          ORDER BY t.created_at DESC LIMIT 1";

$run = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($run);

if ($data) {
    
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $verify_url = $protocol . $_SERVER['HTTP_HOST'] . "/MKasiExchange-C2C/verify_trade.php?hash=" . $data['unique_hash'];
    
    
    $qr_api_url = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($verify_url);
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Trade QR | MKasiExchange</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="bg-light text-center p-5">
        <div class="card shadow-sm p-4 d-inline-block" style="max-width: 400px;">
            <h3 class="fw-bold">Release Payment</h3>
            <p class="text-muted">Item: <strong><?php echo $data['item_name']; ?></strong></p>
            <hr>
            <p>Show this QR code to the buyer when you meet.</p>
            
            <div class="bg-white p-3 border mb-3">
                <img src="<?php echo $qr_api_url; ?>" alt="Trade QR Code" class="img-fluid">
            </div>

            <p class="small text-danger">⚠️ Do not show this until the buyer has inspected the product.</p>
            <a href="index.php" class="btn btn-kasi w-100">Back to Market</a>
        </div>
    </body>
    </html>
<?php 
} else { 
    echo "<div class='container mt-5 text-center'><h3>No pending sales found.</h3><a href='index.php'>Go back</a></div>"; 
} 
?>