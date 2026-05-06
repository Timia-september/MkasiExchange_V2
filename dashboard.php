<?php
session_start();
include 'db_config.php';
include 'languages.php';
global $words;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$buying_query = "SELECT t.*, p.item_name, p.price, u.username as seller_name 
                 FROM transactions t 
                 JOIN products p ON t.item_id = p.id 
                 JOIN users u ON t.seller_id = u.id 
                 WHERE t.buyer_id = '$user_id'";
$buying_result = mysqli_query($conn, $buying_query);


$selling_query = "SELECT t.*, p.item_name, p.price, u.username as buyer_name 
                  FROM transactions t 
                  JOIN products p ON t.item_id = p.id 
                  JOIN users u ON t.buyer_id = u.id 
                  WHERE t.seller_id = '$user_id'";
$selling_result = mysqli_query($conn, $selling_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>
    
    <div class="container mt-5">
        <h2 class="mb-4"><?php echo $words['my_listings'] ?? 'My Transactions'; ?></h2>

        <h4 class="text-primary">Buying (Escrow)</h4>
        <div class="table-responsive mb-5">
            <table class="table bg-white shadow-sm rounded">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Seller</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($buying_result)): ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['seller_name']; ?></td>
                        <td>R <?php echo $row['price']; ?></td>
                        <td><span class="badge bg-info"><?php echo $row['status']; ?></span></td>
                        <td>
                            <?php if($row['status'] == 'escrow'): ?>
                                <a href="release_escrow.php?hash=<?php echo $row['unique_hash']; ?>" 
                                   class="btn btn-sm btn-success" 
                                   onclick="return confirm('Confirm receipt of item?')">Release Funds</a>
                            <?php else: ?>
                                <span class="text-muted small">Closed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <h4 class="text-success">Selling</h4>
        <div class="table-responsive">
            <table class="table bg-white shadow-sm rounded">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Buyer</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($selling_result)): ?>
                    <tr>
                        <td><?php echo $row['item_name']; ?></td>
                        <td><?php echo $row['buyer_name']; ?></td>
                        <td>R <?php echo $row['price']; ?></td>
                        <td>
                            <span class="badge <?php echo ($row['status'] == 'completed') ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>