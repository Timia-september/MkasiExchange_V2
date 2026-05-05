<?php
session_start();
include 'db_config.php';
include 'languages.php';
$query = "SELECT p.*, u.username 
          FROM products p 
          JOIN users u ON p.user_id = u.id 
          ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $query);

if (!$result) { $result = false; }
?>

<!DOCTYPE html>
<html>
<head>
    <title>MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <h2 class="fw-bold mb-4"><?php echo $words['welcome']; ?></h2>
    <div class="row">
        <?php if ($result && mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-6 col-md-4 mb-4">
                <div class="card kasi-card shadow-sm h-100">
                    <img src="<?php echo $row['image_path']; ?>" class="product-img" alt="item" loading="lazy">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="price-badge">R<?php echo $row['price']; ?></span>
                            <small class="text-muted">
                                <?php echo $words['location']; ?>: <?php echo $row['location']; ?>
                            </small>
                        </div>
                        <h5 class="fw-bold"><?php echo $row['item_name']; ?></h5>
                        <p class="text-muted small"><?php echo $row['description']; ?></p>
                        
                        <a href="https://wa.me/<?php echo $row['phone'] ?>?text=<?php echo urlencode($row['item_name'] . " - " . $words['available']); ?>"`
                           class="btn btn-kasi w-100 mb-2" 
                           target="_blank">
                            <?php echo $words['chat_btn']; ?>
                        </a>
                        <form action="initiate_escrow.php" method="POST">
                            <input type="hidden" name="item_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="btn btn-outline-success w-100 mt-2">
                            <i class="bi bi-shield-lock"></i> <?php echo $words['secure_btn']; ?>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <p class="text-muted">No items found in the marketplace. Be the first to sell!</p>
            <a href="sell.php" class="btn btn-primary px-4">List Your Product</a>
        </div>
    <?php endif; ?>
</div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>