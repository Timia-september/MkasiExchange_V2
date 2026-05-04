<?php
include 'db_connect.php';

$username = 'admin';
$password = 'SpongeBob123';

$new_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = '$new_hash' WHERE username = '$username'";

if(mysqli_query($conn, $sql)) {
    echo "<h2>Success! Admin password is now hashed.</h2>";
    echo "<p>Try logging in now at <a href='login.php'>login.php</a></p>";
} else {
    echo "Error updating: " . mysqli_error($conn);
}
?>