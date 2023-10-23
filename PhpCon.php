<?php
$conn = new mysqli('localhost', 'root', '', 'webinventorydb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sqlCheck = "SELECT COUNT(*) as count FROM taxmnt";
$result = $conn->query($sqlCheck);

if ($result !== false) {
    $row = $result->fetch_assoc();
    $rowCount = $row['count'];

    if ($rowCount === 0) {
        // If there's no data, insert default values with 0
        $sqlInsertDefault = "INSERT INTO taxmnt (addPricePer, taxPer) VALUES (0, 0)";
        $conn->query($sqlInsertDefault);
    }
}
?>
