<?php

include ('PhpCon.php');

if (isset($_POST["productQR"])) {

    $product_id = $_POST['productQR'];
    $product_quantity = $_POST['quantity'];
    $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE pro_IDQR = $product_id";
    $result = $conn->query($query); 

    if ($result && $result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        $product_name = $row["pro_name"];
        $product_price = $row["pro_price"];
        $total_price = $product_quantity * $product_price;

        $insert_query = "INSERT INTO cashier_temp (pro_IDQR, pro_name, pro_price, pro_quantity, pro_total)
         VALUES ('$product_id','$product_name', '$product_price', '$product_quantity', '$total_price')";
        if ($conn->query($insert_query) === TRUE) {
            header('location:cashieringiframe.php');
        }
    $conn->close(); 
}}
header('location:cashiering.php');
?>
