<?php
include ("PhpCon.php");

// Get the product ID from the query string
$productId = $_GET['productId'];

// Query the database to fetch the product name
$sql = "SELECT pro_name FROM itemlist WHERE pro_IDQR = ?";
$stmt = $conn->prepare($sql);
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $productId);
    if ($stmt->execute()) {
        $stmt->bind_result($productName);
        $stmt->fetch();
        $stmt->close();
        // Return the product name or an empty string if not found
        echo isset($productName) ? $productName : '';
    } else {
        echo "Execution failed: " . mysqli_error($conn);
    }
} else {
    echo "Preparation failed: " . mysqli_error($conn);
}

?>
