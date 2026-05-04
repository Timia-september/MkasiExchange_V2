<?php
// Turn on error reporting so we can see what is wrong
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>If you can see this, PHP is working!</h1>";

$host = "localhost";
$user = "root";
$pass = "";
$db   = "mkasiexchange_db"; // Double check this name in phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

if ($conn) {
    echo "<h2 style='color:green;'>Database Connected Successfully!</h2>";
} else {
    echo "<h2 style='color:red;'>Database Connection Failed: " . mysqli_connect_error() . "</h2>";
}
?>