<?php
// Create connection
$conn = new mysqli('localhost', 'root', '');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a new database
$sql = "CREATE DATABASE webinventorydb";
if ($conn->query($sql) === true) {
    header('location:dbtablesetup.php');
} else {
    echo "Error creating database: " . $conn->error;
}

// Close the connection
$conn->close();
?>
