<?php
include("PhpCon.php"); // Include your database connection script

$productID = $_GET['productID']; // Get the Product ID from the query string

// Initialize the $products array
$products = array();

// Check if the productID starts with "PD"
if (strpos($productID, 'PD') === 0) {
    // Product ID starts with "PD"
    $itemdis_IDQR = $productID; // Preserve the "PD" prefix
    // Remove "PD" prefix for searching in itemlist
    $itemlistProductID = substr($productID, 2);

    // Search in the itemdiscount table for "PD"-preserved product ID
    $sqlDiscount = "SELECT itemdis_IDQR, itemdisper FROM itemdiscount WHERE itemdis_IDQR = ?";
    $stmtDiscount = $conn->prepare($sqlDiscount);
    $stmtDiscount->bind_param("s", $itemdis_IDQR);

    if ($stmtDiscount->execute()) {
        $resultDiscount = $stmtDiscount->get_result();

        if ($resultDiscount->num_rows > 0) {
            while ($rowDiscount = $resultDiscount->fetch_assoc()) {
                $products[] = $rowDiscount;
            }
        } else {
            // Product not found in itemdiscount
            $response = array('message' => 'Product not found');
            echo json_encode($response);
            exit; // Exit the script to prevent further processing
        }
    } else {
        // Debugging: Check for SQL query execution errors
        $response = array('message' => 'Error executing discount query: ' . $stmtDiscount->error);
        echo json_encode($response);
        exit; // Exit the script to prevent further processing
    }

    // Search for pro_name and pro_price in itemlist using the modified product ID
    $sqlItemList = "SELECT pro_name, pro_price FROM itemlist WHERE pro_IDQR = ?";
    $stmtItemList = $conn->prepare($sqlItemList);
    $stmtItemList->bind_param("s", $itemlistProductID);

    if ($stmtItemList->execute()) {
        $resultItemList = $stmtItemList->get_result();

        if ($resultItemList->num_rows > 0) {
            while ($rowItemList = $resultItemList->fetch_assoc()) {
                $products[] = $rowItemList;
            }
        }
    }
} else {
    // Use a prepared statement to prevent SQL injection for itemlist
    $sql = "SELECT il.pro_IDQR, il.pro_name, il.pro_quantity, il.pro_price, id.itemdisper
            FROM itemlist AS il
            LEFT JOIN itemdiscount AS id ON il.pro_IDQR = id.itemdis_IDQR
            WHERE il.pro_IDQR = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productID); // Assuming pro_IDQR is a string

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
    }
}

if (!empty($products)) {
    // Product(s) found, return the JSON data
    echo json_encode($products);
} else {
    // Product not found
    $response = array('message' => 'Product not found');
    echo json_encode($response);
}


?>
