<?php
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE webinventorydb";
if ($conn->query($sql) === true) {
    header('location:dbtablesetup.php');
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>
