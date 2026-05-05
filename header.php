<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'db_config.php';
include_once 'languages.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #001f3f;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="img/logo.png" alt="MKasi Logo" class="me-2" style="height: 45px; width: auto;">
            <span class="logo-text">MKasiExchange <span class="text-warning">C2C</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav ms-auto align-items-center">
                
                
                <div class="d-flex me-lg-3 my-2 my-lg-0">
                    <a href="change_lang.php?l=en" class="btn btn-sm btn-outline-light me-1">EN</a>
                    <a href="change_lang.php?l=zu" class="btn btn-sm btn-outline-light me-1">ZU</a>
                    <a href="change_lang.php?l=xh" class="btn btn-sm btn-outline-light">XH</a>
                </div>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a class="nav-link fw-bold px-3 text-white" href="profile.php">
                        Hi, <?php echo htmlspecialchars($_SESSION['username'] ?? 'User'); ?>
                    </a>

                    
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                        <a class="nav-link text-info fw-bold px-3" href="admin_dashboard.php">Dashboard</a>
                    <?php endif; ?>

                    
                    <?php if (!isset($hide_sell) || $hide_sell !== true): ?>
                        <a class="nav-link fw-bold px-3" href="sell.php"><?php echo $words['nav_sell'] ?? 'Sell'; ?></a>
                    <?php endif; ?>

                    <a class="nav-link fw-bold px-3" href="logout.php"><?php echo $words['nav_logout'] ?? 'Logout'; ?></a>

                <?php else: ?>
                    <a class="nav-link px-3" href="login.php"><?php echo $words['nav_login'] ?? 'Login'; ?></a>
                    <a class="nav-link fw-bold px-3" href="register.php"><?php echo $words['nav_register'] ?? 'Register'; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>