<?php
include("PhpCon.php"); // Include your database connection file

if (isset($_POST['pro_PONO'])) {
    $proPONO = $_POST['pro_PONO'];

    // Fetch the corresponding records from supdelivery for the given PO number
    $sql_fetch_supdelivery = "SELECT * FROM supdelivery WHERE supdel_PONO = '$proPONO'";
    $result = $conn->query($sql_fetch_supdelivery);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $proIDQR = $row['pro_IDQR'];
            $supdelQuantity = $row['supdel_quantity'];

            // Update itemlist by adding supdelQuantity to the existing quantity
            $sql_update_itemlist = "UPDATE itemlist 
                SET pro_quantity = pro_quantity + $supdelQuantity 
                WHERE pro_IDQR = '$proIDQR'";

            if ($conn->query($sql_update_itemlist) === TRUE) {
                // Quantity updated successfully
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
        }

        // After processing, you can redirect back to the Supplier Delivery page
        header("supdel.php");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "No records found in supdelivery for PO#: $proPONO";
    }

    // Close the database connection
    $conn->close();
}
?>
