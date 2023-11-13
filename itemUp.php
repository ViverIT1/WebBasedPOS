<?php
include ('PhpCon.php');

if (isset($_GET['UpID'])) {
    $idHolder = $_GET['UpID'];
    $productIDQR = $_POST['Product_IDQR'];
    $productName = $_POST['Product_Name'];
    $description = $_POST['Description'];
    $category = $_POST['Category'];
    $price = $_POST['Price'];
    $reorderPoint = $_POST['Reorder_Point'];

    // Prepare the SQL update statement
    $query = "UPDATE itemlist SET 
              pro_IDQR = ?,
              pro_name = ?,
              pro_inf = ?,
              pro_cat = ?,
              pro_price = ?,
              pro_reorder = ?
              WHERE pro_IDQR = ?";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssiis", $productIDQR, $productName, $description, $category, $price, $reorderPoint, $idHolder);
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
