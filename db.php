<?php
$host = "hostName"; // Use the updated port;  // XAMPP default host
$user = "username";       // Default MySQL user
$password = "your_password";       // Default password (empty in XAMPP)
$database = "databaseName"; // Replace with your database name

// Create a connection
$conn = new mysqli($host, $user, $password, $database );

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Connected successfully!";
}
?>
