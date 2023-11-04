<?php
if(isset($_POST["Product_Name"])){
$Product_IDQR = $_POST['Product_IDQR'];
$Product_Name = $_POST['Product_Name'];
$Description = $_POST['Description'];
$Category = $_POST['Category'];
$Price = $_POST['Price'];
$Quantity = 0;
$Reorder_Point = $_POST['Reorder_Point'];
$Minimum = 10;
$Maximum = 100;

$conn = new mysqli('localhost', 'root', '', 'webinventorydb');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO itemlist 
        (pro_IDQR, pro_name, pro_inf, pro_cat, pro_price, pro_quantity, pro_reorder, pro_minStock, pro_maxStock) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ssssiiiii", $Product_IDQR, $Product_Name, $Description, $Category, $Price, $Quantity, $Expiry_Date, $Reorder_Point, $Minimum, $Maximum);

if (mysqli_stmt_execute($stmt)) {
    header('location: ItemAdd.php');
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);


mysqli_stmt_close($stmt);
mysqli_close($conn);
}
?>
