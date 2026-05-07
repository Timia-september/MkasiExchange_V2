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
                 WHERE t.buyer_id = '$user_id'
                 ORDER BY t.created_at DESC";
$buying_result = mysqli_query($conn, $buying_query);

$selling_query = "SELECT t.*, p.item_name, p.price, u.username as buyer_name 
                  FROM transactions t 
                  JOIN products p ON t.item_id = p.id 
                  JOIN users u ON t.buyer_id = u.id 
                  WHERE t.seller_id = '$user_id'
                  ORDER BY t.created_at DESC";
$selling_result = mysqli_query($conn, $selling_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $words['my_listings'] ?? 'Transactions'; ?> - MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold"><i class="bi bi-wallet2 pe-2"></i><?php echo $words['my_listings'] ?? 'My Transactions'; ?></h2>
            <a href="index.php" class="btn btn-outline-primary btn-sm"><?php echo $words['back_market'] ?? 'Back to Market'; ?></a>
        </div>

        <div class="card border-0 shadow-sm mb-5">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="card-title mb-0"><?php echo $words['buying_title'] ?? 'Buying (Escrow)'; ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo $words['item_header'] ?? 'Item'; ?></th>
                            <th><?php echo $words['seller_col'] ?? 'Seller'; ?></th>
                            <th><?php echo $words['price_label'] ?? 'Price'; ?></th>
                            <th><?php echo $words['status_label'] ?? 'Status'; ?></th>
                            <th><?php echo $words['action_col'] ?? 'Action'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($buying_result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($buying_result)): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['item_name']); ?></td>
                                <td><i class="bi bi-person-circle pe-1"></i><?php echo htmlspecialchars($row['seller_name']); ?></td>
                                <td>R <?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php if($row['status'] == 'completed'): ?>
                                        <span class="badge bg-success"><?php echo $words['completed_txt'] ?? 'Completed'; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><?php echo strtoupper($row['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($row['status'] == 'escrow'): ?>
                                        <a href="release_escrow.php?hash=<?php echo $row['unique_hash']; ?>" 
                                           class="btn btn-sm btn-success px-3" 
                                           onclick="return confirm('<?php echo $words['confirm_msg'] ?? 'Confirm receipt of item?'; ?>')">
                                           <?php echo $words['release_btn'] ?? 'Release Funds'; ?>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small"><i class="bi bi-check2-all pe-1"></i><?php echo $words['closed_txt'] ?? 'Closed'; ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center py-4 text-muted">No buying activity yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white py-3">
                <h5 class="card-title mb-0"><?php echo $words['selling_title'] ?? 'Selling'; ?></h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><?php echo $words['item_header'] ?? 'Item'; ?></th>
                            <th><?php echo $words['buyer_col'] ?? 'Buyer'; ?></th>
                            <th><?php echo $words['price_label'] ?? 'Price'; ?></th>
                            <th><?php echo $words['status_label'] ?? 'Status'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($selling_result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($selling_result)): ?>
                            <tr>
                                <td class="fw-bold"><?php echo htmlspecialchars($row['item_name']); ?></td>
                                <td><i class="bi bi-person-circle pe-1"></i><?php echo htmlspecialchars($row['buyer_name']); ?></td>
                                <td>R <?php echo number_format($row['price'], 2); ?></td>
                                <td>
                                    <?php if($row['status'] == 'completed'): ?>
                                        <span class="badge bg-success"><?php echo $words['completed_txt'] ?? 'Completed'; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark"><?php echo strtoupper($row['status']); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-4 text-muted">No sales activity yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>