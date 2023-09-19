<?php
include("PhpCon.php"); // Include your database connection file

if (isset($_POST['SuppPo'])) {
    $suppPo = $_POST['SuppPo'];

    // SQL query to insert data into supdelivery based on the provided PO#
    $sql_insert_supdelivery = "INSERT INTO supdelivery 
        SELECT * FROM polist WHERE po_PONO = $suppPo";

    // Execute the SQL query to insert data into supdelivery
    if ($conn->query($sql_insert_supdelivery) === TRUE) {
        // Redirect to suppdel.php
        header("Location: suppdel.php");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "Error inserting data into supdelivery: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
