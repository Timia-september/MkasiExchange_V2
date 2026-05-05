<?php
session_start();
include 'db_config.php';
include 'languages.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$product_id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

$res = mysqli_query($conn, "SELECT * FROM products WHERE id = '$product_id' AND user_id = '$user_id'");
$item = mysqli_fetch_assoc($res);

if (!$item) {
    die("Item not found or access denied.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $new_price = mysqli_real_escape_string($conn, $_POST['price']);

    $update_query = "UPDATE products SET item_name = '$new_name', price = '$new_price' 
                     WHERE id = '$product_id' AND user_id = '$user_id'";
    
    if (mysqli_query($conn, $update_query)) {
        header("Location: profile.php?msg=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Item | MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>
    
    <div class="container mt-5">
        <div class="card shadow-sm mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h4>Edit Listing</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label>Item Name</label>
                        <input type="text" name="item_name" class="form-control" value="<?php echo htmlspecialchars($item['item_name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Price (R)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $item['price']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    <a href="profile.php" class="btn btn-link w-100 text-muted">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>