<?php
$host = "localhost";
$user = "root";  // Change if needed
$pass = "";      // Default for XAMPP, change if needed
$dbname = "complaint_system";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
