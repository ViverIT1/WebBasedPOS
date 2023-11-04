<?php
include ("PhpCon.php");

// SQL query to retrieve header and footer data
$query = "SELECT storeName, storeAddress, storePhone, storeEmail, textbox1, textbox2, textbox3, textbox4 FROM reclay WHERE id = 1"; // Assuming id = 1 is your unique row

$result = $conn->query($query);

if ($result) {
    $data = $result->fetch_assoc();

    // Create an associative array to store header and footer data
    $header = array(
        'storeName' => $data['storeName'],
        'storeAddress' => $data['storeAddress'],
        'storePhone' => $data['storePhone'],
        'storeEmail' => $data['storeEmail']
    );

    $footer = array(
        'textbox1' => $data['textbox1'],
        'textbox2' => $data['textbox2'],
        'textbox3' => $data['textbox3'],
        'textbox4' => $data['textbox4']
    );

    // Combine header and footer data into a single array
    $receiptData = array('header' => $header, 'footer' => $footer);

    // Return the data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($receiptData);
} else {
    echo 'Error in SQL query: ';
}

// Close the database connection
$conn->close();
?>
