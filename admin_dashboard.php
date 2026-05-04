<?php
session_start();
include 'db_connect.php';


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("Location: index.php");
    exit();
}


$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="fw-bold mb-4">Admin Management Control</h2>
        
        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card bg-primary text-white shadow-sm border-0 p-3">
                    <h3><?php echo $user_count; ?></h3>
                    <p class="mb-0">Total Registered Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white shadow-sm border-0 p-3">
                    <h3><?php echo $product_count; ?></h3>
                    <p class="mb-0">Active Listings</p>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="mb-3">Recent Listings</h4>
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $products = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 10");
                        while($item = mysqli_fetch_assoc($products)):
                        ?>
                        <tr>
                            <td><?php echo $item['item_name']; ?></td>
                            <td>R<?php echo $item['price']; ?></td>
                            <td><?php echo $item['location']; ?></td>
                            <td>
                                <a href="delete_item.php?id=<?php echo $item['product_id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>