<?php
session_start();
session_destroy(); // Clears all user data (ID and Role)
header("Location: index.php"); // Redirects back home
exit();
?>