<?php
if (isset($_POST["product"])) {
    include ('PhpCon.php'); // Include the database connection file

    $product_id = $_POST['productQR'];
    $product_quantity = $_POST['quantity'];
    $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE pro_IDQR = $product_id";
    $result = $conn->query($query); // Use $conn instead of $source_db

    if ($result && $result->num_rows > 0) { // Check if $result is valid before using num_rows
        $row = $result->fetch_assoc();
        $product_name = $row["pro_name"];
        $product_price = $row["pro_price"];
        $total_price = $product_quantity * $product_price;

        $insert_query = "INSERT INTO cashier_temp (pro_IDQR, pro_name, pro_price, pro_quantity, pro_total)
         VALUES ('$product_id','$product_name', '$product_price', '$product_quantity', '$total_price')";
        if ($conn->query($insert_query) === TRUE) {
            header('location:cashieringiframe.php');
        }
    $conn->close(); // Close the connection
}}
header('location:cashiering.php');
?>
