<nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="index.php">
            <img src="img/logo.png" alt="MKasi Logo" class="navbar-logo me-2"> 
            MKasiExchange <span class="text-warning ms-1">C2C</span>
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
                    <a class="nav-link fw-bold px-3" href="sell.php"><?php echo $words['nav_sell']; ?></a>
                    <a class="nav-link fw-bold px-3" href="logout.php"><?php echo $words['nav_logout']; ?></a>
                <?php else: ?>
                    <a class="nav-link" href="login.php"><?php echo $words['nav_login']; ?></a>
                    <a class="nav-link fw-bold px-3" href="register.php"><?php echo $words['nav_register']; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>