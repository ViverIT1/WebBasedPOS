<?php
include("PhpCon.php");

// SQL query to retrieve header and footer data
$query = "SELECT storeName, storeAddress, storePhone, storeEmail, textbox1, textbox2, textbox3, textbox4 FROM reclay WHERE id = 1"; // Assuming id = 1 is your unique row

$result = $conn->query($query);

if ($result) {
    $data = $result->fetch_assoc();

    // Initialize arrays with default values
    $header = array(
        'storeName' => 'Default Store Name',
        'storeAddress' => 'Default Store Address',
        'storePhone' => 'Default Phone Number',
        'storeEmail' => 'Default Email'
    );

    $footer = array(
        'textbox1' => 'Default Textbox 1',
        'textbox2' => 'Default Textbox 2',
        'textbox3' => 'Default Textbox 3',
        'textbox4' => 'Default Textbox 4'
    );

    // If data is available in the database, update the arrays with the retrieved values
    if ($data) {
        $header['storeName'] = $data['storeName'];
        $header['storeAddress'] = $data['storeAddress'];
        $header['storePhone'] = $data['storePhone'];
        $header['storeEmail'] = $data['storeEmail'];

        $footer['textbox1'] = $data['textbox1'];
        $footer['textbox2'] = $data['textbox2'];
        $footer['textbox3'] = $data['textbox3'];
        $footer['textbox4'] = $data['textbox4'];
    }

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
