<?php
// Database configuration
$host = 'localhost';         // Usually localhost
$dbname = 'mypetakom';    // Replace with your actual database name
$username = 'root';          // Change to your DB username if needed
$password = '';              // Change if your MySQL has a password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>