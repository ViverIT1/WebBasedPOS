<?php
$conn = new mysqli('localhost', 'root', '', 'webinventorydb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
