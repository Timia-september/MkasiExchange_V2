<?php
session_start();
if (isset($_GET['l'])) {
    $allowed = ['en', 'zu', 'xh'];
    if (in_array($_GET['l'], $allowed)) {
        $_SESSION['lang'] = $_GET['l'];
    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();