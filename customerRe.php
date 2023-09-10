<?php
if (isset($_GET['ReID'])) {
    $cust_ID = $_GET['ReID'];
    require ('PhpCon.php');

    // Sanitize the input to prevent SQL injection (using mysqli_real_escape_string for simplicity)
    $itemID = mysqli_real_escape_string($conn, $proID);

    // Create a delete query
    $delete_query = "DELETE FROM customerlist WHERE cust_ID = $cust_ID";

    // Execute the query
    if (mysqli_query($conn, $delete_query)) {
        header('Location: customermanage.php');
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error getting supplier ID, Please try again.";
}
?>
