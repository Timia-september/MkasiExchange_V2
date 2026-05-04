<?php
include 'db_connect.php';

$user = "admin";
$pass = "SpongeBob123"; 
$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
$role = "Admin";


mysqli_query($conn, "DELETE FROM users WHERE username='$user'");

$sql = "INSERT INTO users (username, password, role) VALUES ('$user', '$hashed_pass', '$role')";

if(mysqli_query($conn, $sql)){
    echo "<h1>Admin Created Successfully!</h1>";
    echo "<p>You can now login with <b>$user</b> and your password.</p>";
    echo "<a href='login.php'>Go to Login</a>";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>