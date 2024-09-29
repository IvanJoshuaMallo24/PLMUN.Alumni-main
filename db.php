<?php
// db.php

// Database configuration
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = "12345"; // Database password
$dbname = "Alumni_Database"; // Database name

// Create a connection using MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8 for proper handling of special characters
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}

// Connection successful message (for testing, remove in production)
// echo "Connected successfully";
?>
