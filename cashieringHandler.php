<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ('PhpCon.php'); // Include the database connection file

    $product_id = (int) trim($_POST['product']);

    $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE pro_ID = $product_id";
    $result = $conn->query($query); // Use $conn instead of $source_db

    if ($result && $result->num_rows > 0) { // Check if $result is valid before using num_rows
        $row = $result->fetch_assoc();
        $product_name = $row["pro_name"];
        $product_price = $row["pro_price"];
        $product_quantity = $row["pro_quantity"];

        $insert_query = "INSERT INTO cashier_temp (pro_ID, pro_name, pro_price, pro_quantity)
         VALUES ('$product_id','$product_name', $product_price, $product_quantity)";
        if ($conn->query($insert_query) === TRUE) {
            header('location:cashiering.php');
        }
    $conn->close(); // Close the connection
}}
header('location:cashiering.php');
?>
