<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require ('PhpCon.php');
    if (isset($_POST["product_id"])) {
        $product_ID = $_POST["product_id"];
        $delete_query = "DELETE FROM cashier_temp WHERE pro_ID = $product_ID";

        // Execute the query
        if (mysqli_query($conn, $delete_query)) {
            header('Location: itemanage.php');
        } else {
            echo "Error deleting item: " . mysqli_error($conn);
        }
    
        // Close the database connection
        $conn->close();
        header("Location: cashiering.php"); // Replace "cart.php" with the actual URL of your cart page
        exit();
    }
}
?>
