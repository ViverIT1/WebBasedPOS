<?php
include ("PhpCon.php");

if(isset($_POST["Product_Name"])){
$Product_IDQR = $_POST['Product_IDQR'];
$Product_Name = $_POST['Product_Name'];
$Description = $_POST['Description'];
$Category = $_POST['Category'];
$Price = $_POST['Price'];
$Quantity = 0;
$Minimum = 10;
$Maximum = 100;

$sql = "INSERT INTO itemlist 
        (pro_IDQR, pro_name, pro_inf, pro_cat, pro_price, pro_quantity, pro_minStock, pro_maxStock) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "ssssdiii", $Product_IDQR, $Product_Name, $Description, $Category, $Price, $Quantity, $Minimum, $Maximum);

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
