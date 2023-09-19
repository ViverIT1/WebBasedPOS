<?php
require_once('PhpCon.php');
if (isset($_GET['UpID'])) {
    $proID = $_GET['UpID'];
    $productIDQR = $_POST['Product_IDQR'];
    $productName = $_POST['Product_Name'];
    $description = $_POST['Description'];
    $category = $_POST['Category'];
    $price = $_POST['Price'];
    $expiryDate = $_POST['Expiry_Date'];
    $reorderPoint = $_POST['Reorder_Point'];
    $minimumStock = $_POST['Minimum'];
    $maximumStock = $_POST['Maximum'];

    // Prepare the SQL update statement
    $query = "UPDATE itemlist SET 
              pro_IDQR =?,
              pro_name = ?,
              pro_inf = ?,
              pro_cat = ?,
              pro_price = ?,
              pro_exp = ?,
              pro_reorder = ?,
              pro_minStock = ?,
              pro_maxStock = ?
              WHERE pro_ID = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssisiiii", $productIDQR, $productName, $description, $category, $price, $expiryDate, $reorderPoint, $minimumStock, $maximumStock, $proID);


        // Execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            echo "Record updated successfully. Redirecting...";
            echo '<script>
            window.location.href = "itemanage.php";
            </script>';
            exit;
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        
        // Close the prepared statement
        mysqli_stmt_close($stmt);
    }
} else {
    echo 'Error updating product';
    echo '<a href="itemanage.php"><button>Go back</button></a>';
}
?>