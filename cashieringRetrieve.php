<?php
include("PhpCon.php"); // Include your database connection script

$productID = $_GET['productID']; // Get the Product ID from the query string

$sql = "SELECT pro_ID, pro_name, pro_quantity, pro_price FROM itemlist WHERE pro_ID = $productID";

$result = $conn->query($sql);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

// Close the database connection
$conn->close();

// Send the product data as JSON
header("Content-Type: application/json");
echo json_encode($products);
?>
