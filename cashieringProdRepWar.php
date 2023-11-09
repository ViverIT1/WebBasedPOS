<?php
// Include the file for database connection
include("PhpCon.php");

// Read the raw POST data
$jsonData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($jsonData, true);

// Check if the data is valid
if ($data && isset($data['username'], $data['email'])) {
    // Process the data and update the sales report
    // Note: You should replace the following lines with your actual database operations.

    // Example: Insert data into the sales_report table
    $insertQuery = "INSERT INTO sales_report (customer_name, product_id, product_name, product_quantity, product_discount, product_total, discount, tax, grand_total, date_purchased)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sissddddds", $data['username'], $productID, $productName, $quantity, $productDiscount, $productTotal, $discount, $tax, $grandTotal);

    // Sample values (replace with actual data)
    $productID = 123;
    $productName = 'Sample Product';
    $quantity = 2;
    $productDiscount = 5.00;
    $productTotal = 100.00;
    $discount = 10.00;
    $tax = 8.00;
    $grandTotal = 98.00;

    $stmt->execute();

    // Close the statement
    $stmt->close();

    // Send a success response to the client
    http_response_code(200);
    echo "Data sent and saved successfully";
} else {
    // Send an error response to the client
    http_response_code(400);
    echo "Invalid data received";
}

// Close the database connection
$conn->close();
?>
