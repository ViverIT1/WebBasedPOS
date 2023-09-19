<?php
// Define the path to the log file
$logFile = 'C:/xampp/htdocs/SystemError/purchaseOrderAddHandler.log';

// Function to log errors
function logError($message) {
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    // Add a timestamp to the log message
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

try {
    // Receive the JSON data from the JavaScript
    $data = json_decode(file_get_contents('php://input'), true);

    // Include your database connection code
    include("PhpCon.php");

    // Loop through the data and insert it into the MySQL database
    foreach ($data as $row) {
        $quantity = $row[0];
        $unit = $row[1];
        $item = $row[2];
        $ProductID = $row[3];
        $productName = $row[4];
        $unitPrice = $row[5];
        $total = $row[6];
        $supplier = $row[7];
        $PurchOrd = $row[8];

        $sql = "INSERT INTO polist (po_quantity, po_unit, po_item, pro_IDQR, pro_name, po_unitPrice,
        po_total, po_supp, po_PONO)
         VALUES ('$quantity', '$unit', '$item', '$ProductID', '$productName', '$unitPrice', '$total',
          '$supplier', '$PurchOrd')";

        if ($conn->query($sql) !== TRUE) {
            // Log the database error
            logError('Database Error: ' . $conn->error);
            echo 'Error: ' . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();

    // Response for a successful operation
    echo 'Data saved successfully!';
} catch (Exception $e) {
    // Log other exceptions
    logError('Exception: ' . $e->getMessage());
    echo 'An error occurred. Please try again later.';
}
?>
