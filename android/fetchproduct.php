<?php
include("PhpCon.php");

// Check for a valid POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if 'pro_id' has been sent in the POST data
    if (isset($_POST['pro_id'])) {
        // Instance of DbOperation
        $db = new DbOperation();

        // Fetch product data for the specified ID
        $getProducts = $db->fetchProductdata($_POST["pro_id"]);

        // Respond with the fetched data
        echo json_encode($getProducts);
    } else {
        // Respond with an error if 'pro_id' is not provided in the POST data
        $response = array('error' => true, 'message' => 'Product ID not provided');
        echo json_encode($response);
    }
} else {
    // Respond with an error if it's not a POST request
    $response = array('error' => true, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
