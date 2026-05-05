<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "mkasiexchange_v2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully to MkasiExchange_V2";
?>