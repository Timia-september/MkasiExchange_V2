<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'db_config.php';
include_once 'languages.php';
global $words, $current_lang; 
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
                
                <div class="d-flex me-3">
                    <a href="change_lang.php?l=en" class="btn btn-sm <?php echo ($current_lang == 'en') ? 'btn-warning' : 'btn-outline-light'; ?> me-1">EN</a>
                    <a href="change_lang.php?l=zu" class="btn btn-sm <?php echo ($current_lang == 'zu') ? 'btn-warning' : 'btn-outline-light'; ?> me-1">ZU</a>
                    <a href="change_lang.php?l=xh" class="btn btn-sm <?php echo ($current_lang == 'xh') ? 'btn-warning' : 'btn-outline-light'; ?> me-1">XH</a>
                </div>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <div class="nav-item dropdown ms-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center fw-bold border" style="width: 40px; height: 40px; font-size: 14px;">
                                <?php 
                                    $name = $_SESSION['username'] ?? 'User';
                                    // CHANGED: Use $nameParts instead of $words to avoid overwriting your translation array
                                    $nameParts = explode(" ", $name);
                                    $initials = "";
                                    foreach ($nameParts as $w) { 
                                        if(!empty($w)) $initials .= $w[0]; 
                                    }
                                    echo strtoupper(substr($initials, 0, 2)); 
                                ?>
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item py-2" href="profile.php">
                                <?php echo $words['nav_profile'] ?? 'Profile'; ?>
                            </a></li>
    
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                                <li><a class="dropdown-item py-2 text-info" href="admin_dashboard.php">
                                    Admin Dashboard
                                </a></li>
                            <?php endif; ?>

                            <li><a class="dropdown-item py-2" href="sell.php">
                                 <?php echo $words['nav_sell'] ?? 'Sell Something'; ?>
                            </a></li>
    
                            <li><hr class="dropdown-divider"></li>

                            <li><a class="dropdown-item py-2 text-danger" href="logout.php">
                                <?php echo $words['nav_logout'] ?? 'Log out'; ?>
                            </a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a class="nav-link px-3" href="login.php"><?php echo $words['nav_login'] ?? 'Login'; ?></a>
                    <a class="nav-link fw-bold px-3" href="register.php"><?php echo $words['nav_register'] ?? 'Register'; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>