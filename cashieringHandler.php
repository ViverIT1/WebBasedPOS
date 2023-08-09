<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include ('PhpCon.php'); // Include the database connection file

    $product_id = (int) trim($_POST['product']);
    $product_quantity = (int)trim($_POST['quantity']);
    $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE pro_ID = $product_id";
    $result = $conn->query($query); // Use $conn instead of $source_db

    if ($result && $result->num_rows > 0) { // Check if $result is valid before using num_rows
        $row = $result->fetch_assoc();
        $product_name = $row["pro_name"];
        $product_price = $row["pro_price"];
        $total_price = $product_quantity * $product_price;

        $insert_query = "INSERT INTO cashier_temp (pro_ID, pro_name, pro_price, pro_quantity, pro_total)
         VALUES ('$product_id','$product_name', '$product_price', '$product_quantity', '$total_price')";
        if ($conn->query($insert_query) === TRUE) {
            header('location:cashiering.php');
        }
    $conn->close(); // Close the connection
}}
header('location:cashiering.php');
?>
