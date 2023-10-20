<?php
include ("PhpCon.php");

if ($conn) {
    // Query to retrieve tax percentage from taxmnt table
    $query = "SELECT taxPer FROM taxmnt";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Fetch the tax percentage
        $row = mysqli_fetch_assoc($result);
        $taxPercentage = $row['taxPer'];

        // Close the database connection
        mysqli_close($conn);

        // Output the tax percentage (for debugging)
        echo "Tax Percentage: " . $taxPercentage;
    } else {
        echo "Query error: " . mysqli_error($conn);
    }
} else {
    echo "Database connection error: " . mysqli_connect_error();
}
?>
