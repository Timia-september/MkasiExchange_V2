<?php
session_start();
include 'db_config.php';
include 'languages.php';

if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if (isset($_POST['post_item_btn'])) {
    $uid = $_SESSION['user_id'];
    $name = mysqli_real_escape_string($conn, $_POST['item_name']);
    $price = $_POST['price'];
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    
    $filename = $_FILES["item_image"]["name"];
    $tempname = $_FILES["item_image"]["tmp_name"];
    $folder = "uploads/" . time() . "_" . $filename; 

    if (move_uploaded_file($tempname, $folder)) {
        $user_phone = $_SESSION['phone'] ?? ''; 
        $query = "INSERT INTO products (user_id, item_name, price, location, description, image_path, phone) 
          VALUES ('$uid', '$name', '$price', '$loc', '$desc', '$folder', '$user_phone')";
        mysqli_query($conn, $query);
        echo "<script>alert('Item listed with photo!'); window.location='index.php';</script>";
    } else {
        echo "Failed to upload image";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sell | MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?> <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 card p-4 shadow-sm border-0" style="border-radius: 20px;">
                <h2 class="text-center text-primary"><?php echo $words['nav_sell']; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold"><?php echo $words['item_label'] ?? 'Item Name'; ?></label>
                        <input type="text" name="item_name" class="form-control" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold"><?php echo $words['price_label'] ?? 'Price (R)'; ?></label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold"><?php echo $words['location_label'] ?? 'Location'; ?></label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Langa" required>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold"><?php echo $words['desc_label'] ?? 'Description'; ?></label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold"><?php echo $words['photo_label'] ?? 'Product Photo'; ?></label>
                        <input type="file" name="item_image" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" name="post_item_btn" class="btn btn-primary w-100">+ <?php echo $words['nav_sell'] ?? 'Sell Something'; ?></button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>