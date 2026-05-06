<?php
session_start();
if (isset($_GET['l'])) {
    $allowed = ['en', 'zu', 'xh'];
    if (in_array($_GET['l'], $allowed)) {
        $_SESSION['lang'] = $_GET['l'];
    }
}

$back = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header("Location: " . $back);
exit();
?>