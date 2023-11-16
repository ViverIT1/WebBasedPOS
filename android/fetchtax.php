<?php
// Include the DbOperation class
include("dbops.php");

// Create an instance of DbOperation
$dbOperation = new DbOperation();

// Retrieve tax percentage
$taxPercentage = $dbOperation->retrievetax();

// Check if tax retrieval was successful
if ($taxPercentage !== null) {
    // Prepare data to send as JSON
    $responseData = array('taxPercentage' => $taxPercentage);

    // Send JSON-encoded data
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    // Handle the case where tax retrieval failed
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Failed to retrieve tax percentage.'));
}
?>
