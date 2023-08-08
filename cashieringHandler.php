<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ('PhpCon.php');

    $product_id = $_POST["product"];

    // Retrieve product information from the source database
    $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE id = $product_id";
    $result = $source_db->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_name = $row["pro_name"];
        $product_price = $row["pro_price"];
        $product_quantity = $row["pro_quantity"];

        $insert_query = "INSERT INTO cashier_temp (pro_ID,pro_name, price, quantity)
         VALUES ('$product_id','$product_name', $product_price, $product_quantity)";
        if ($destination_db->query($insert_query) === TRUE) {
            echo "Product information saved to destination database successfully.";
        } else {
            echo "Error:";
        }

        // Close the destination database connection
        $destination_db->close();
    } else {
        echo "No product found with the provided ID.";
    }

    // Close the source database connection
    $source_db->close();
}
?>
