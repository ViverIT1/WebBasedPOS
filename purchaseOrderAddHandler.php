<?php
include ("PhpCon.php");

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Receive the JSON data from the JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Loop through the data and insert it into the MySQL database
foreach ($data as $row) {
    $column1 = $row[0];
    $column2 = $row[1];
    $column3 = $row[2];

    $sql = "INSERT INTO your_table_name (column1, column2, column3) VALUES ('$column1', '$column2', '$column3')";

    if ($conn->query($sql) !== TRUE) {
        echo 'Error: ' . $conn->error;
    }
}

$conn->close();
?>
