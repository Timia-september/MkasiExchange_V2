<?php
session_start();
include 'db_config.php';
include 'languages.php';

if (isset($_POST['login_btn'])) {
    $uname = mysqli_real_escape_string($conn, $_POST['username']);
    $pass  = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$uname'";
    $run   = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($run) > 0) {
        $user = mysqli_fetch_assoc($run);
        
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role']    = $user['role'];
            
            if ($user['role'] == 'Admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
        } else {
           echo "<script>alert('" . $words['err_pass'] . "');</script>";
        }
    } else {
        echo "<script>alert('" . $words['err_user'] . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | MKasiExchange</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=1.1">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?> <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4"><?php echo $words['login_title']; ?></h3>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label"><?php echo $words['username']; ?></label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label"><?php echo $words['password']; ?></label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <button type="submit" name="login_btn" class="btn btn-primary w-100 py-2"><?php echo $words['signin_btn']; ?></button>
                        </form>
                        <div class="text-center mt-3">
                            <small><?php echo $words['need_account']; ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>