<?php
include 'db_connect.php';


$new_user = "admin_mia"; 
$new_pass = "MKasi2026!"; 
$hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
$role = "Admin";


$check = mysqli_query($conn, "SELECT * FROM users WHERE username='$new_user'");

if(mysqli_num_rows($check) > 0) {
    echo "<h2>Error: Username already exists!</h2>";
} else {
    $sql = "INSERT INTO users (username, password, role) VALUES ('$new_user', '$hashed_pass', '$role')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<h2>New Admin Created Successfully!</h2>";
        echo "<b>Username:</b> $new_user <br>";
        echo "<b>Password:</b> $new_pass <br>";
        echo "<a href='login.php'>Go to Login</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>