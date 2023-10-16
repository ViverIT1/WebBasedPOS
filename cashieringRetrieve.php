<?php
include("PhpCon.php"); // Include your database connection script

$productID = $_GET['productID']; // Get the Product ID from the query string

// Use a prepared statement to prevent SQL injection
$sql = "SELECT pro_IDQR, pro_name, pro_quantity, pro_price FROM itemlist WHERE pro_IDQR = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $productID); // Assuming pro_IDQR is a string

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        // Product found, return the JSON data
        echo json_encode($products);
    } else {
        // Product not found, return a JSON message
        $response = array('message' => 'Product not found');
        echo json_encode($response);
    }
} else {
    // Handle the case when the SQL query fails
    $response = array('message' => 'Error in SQL query');
    echo json_encode($response);
}

?>
