<?php
$Product_ID = $_POST['Product_ID'];
$Product_Name = $_POST['Product_Name'];
$Description = $_POST['Description'];
$Category = $_POST['Category'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];
$Barcode = $_POST['Barcode'];
$Expiry_Date = $_POST['Expiry_Date'];
$Reorder_Point = $_POST['Reorder_Point'];
$Minimum = $_POST['Minimum'];
$Maximum = $_POST['Maximum'];

$conn = new mysqli('localhost', 'root', '', 'webinventorydb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO itemlist 
        (pro_ID, pro_name, pro_inf, pro_cat, pro_price, pro_quantity, pro_barcode, pro_exp, pro_reorder, pro_minStock, pro_maxStock) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "sssssiiiiii", $Product_ID, $Product_Name, $Description, $Category, $Price, $Quantity, $Barcode, $Expiry_Date, $Reorder_Point, $Minimum, $Maximum);

if (mysqli_stmt_execute($stmt)) {
    header('location:ItemAdd.php');
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
