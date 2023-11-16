<?php
    include("dbops.php");
// Check for a valid POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'pro_id' has been sent in the POST data
    if (isset($_POST['pro_id'])) {
        $productID = $_POST['pro_id'];
        if ($productID !== false) {
            // Perform operations using DbOperation class (as in previous examples)
            $dbOperation = new DbOperation();
            $result = $dbOperation->fetchProductdata($productID);

            if ($result) {
                // Structure the response in the desired format
                $response = array('item' => [$result]);

                // Respond with the formatted data in JSON format
                echo json_encode($response);
            } else {
                // Respond with an error message
                $response = array('error' => true, 'message' => 'Product data not found');
                echo json_encode($response);
            }
        } else {
            // Respond with an error if 'pro_id' is not a valid integer
            $response = array('error' => true, 'message' => 'Invalid product ID format');
            echo json_encode($response);
        }
    } else {
        // Respond with an error if 'pro_id' is not provided in the POST data
        $response = array('error' => true, 'message' => 'Product ID not provided');
        echo json_encode($_POST['pro_id']);
    }
} else {
    // Respond with an error if it's not a POST request
    $response = array('error' => true, 'message' => 'Invalid request method');
    echo json_encode($response);
    error_log('Request Method: ' . $_SERVER['REQUEST_METHOD']);
    error_log('Entire Request: ' . print_r($_REQUEST, true));
}
?>
