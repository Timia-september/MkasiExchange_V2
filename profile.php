<?php
session_start();
include 'db_config.php';
include 'languages.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$user_res = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($user_res);


$my_items = mysqli_query($conn, "SELECT * FROM products WHERE user_id = '$user_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4 text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; font-size: 30px;">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
                <h3><?php echo $user['username']; ?></h3>
                <p class="text-muted"><?php echo $user['phone']; ?></p>
                <hr>
                <div class="mb-2">
                    <span class="badge rounded-pill bg-secondary px-3"><?php echo ucfirst($user['role']); ?></span>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <h4 class="mb-4"><?php echo $words['my_listings'] ?? 'My Listings'; ?></h4>
            <div class="table-responsive bg-white p-3 shadow-sm rounded">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><?php echo $words['item_header'] ?? 'Item'; ?></th>
                            <th><?php echo $words['price_label'] ?? 'Price'; ?></th>
                            <th><?php echo $words['action_col'] ?? 'Action'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($item = mysqli_fetch_assoc($my_items)): ?>
                        <tr>
                            <td><?php echo $item['item_name']; ?></td>
                            <td>R <?php echo number_format($item['price'], 2); ?></td>
                            <td>
                                <a href="edit_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-primary me-1">
                                    Edit
                                </a>
                                <a href="delete_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-outline-danger">
                                    <?php echo $words['delete_btn'] ?? 'Delete'; ?>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>