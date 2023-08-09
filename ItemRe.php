<?php
if (isset($_GET['ReID'])) {
    $proID = $_GET['ReID'];
    require ('PhpCon.php');

    // Sanitize the input to prevent SQL injection (using mysqli_real_escape_string for simplicity)
    $itemID = mysqli_real_escape_string($conn, $proID);

    // Create a delete query
    $delete_query = "DELETE FROM itemlist WHERE pro_ID = $itemID";

    // Execute the query
    if (mysqli_query($conn, $delete_query)) {
        header('Location: itemanage.php');
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error getting Product ID, Please try again.";
}
?>
