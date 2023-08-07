<?php
include_once('PhpCon.php');
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_REQUEST['import-excel'])) {
    $file = $_FILES['import-file']['tmp_name'];
    $extension = pathinfo($_FILES['import-file']['name'], PATHINFO_EXTENSION);

    if ($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
        $obj = IOFactory::load($file);
        $worksheet = $obj->getActiveSheet();
        $data = $worksheet->toArray();

        // Start from the second row (index 1) to skip the header row
        for ($rowIndex = 1; $rowIndex < count($data); $rowIndex++) {
            $row = $data[$rowIndex];

            // Process the data from the Excel file
            $Product_Description = $row['2'];
            $Product_ID = $row['0'];
            $Product_Name = $row['1'];
            $Product_Category = $row['3'];
            $Product_Price = $row['4'];
            $Product_Maximum = $row['10'];
            $Product_Quantity = $row['5'];
            $Product_Reorder = $row['8'];
            $Product_Barcode = $row['6'];
            $Product_Expiry = $row['7'];
            $Product_Minimum = $row['9'];
            // Check if the ID already exists in the database
            $existingQuantity = 0;
            $result = mysqli_query($conn, "SELECT pro_quantity FROM itemlist WHERE pro_ID = '$Product_ID'");
            if (mysqli_num_rows($result) > 0) {
                $existingData = mysqli_fetch_assoc($result);
                $existingQuantity = $existingData['pro_quantity'];
            }

            // If the ID exists, update the quantity; otherwise, insert a new record
            if ($existingQuantity > 0) {
                $updatedQuantity = $existingQuantity + $Product_Quantity;
                mysqli_query($conn, "UPDATE itemlist SET pro_quantity = '$updatedQuantity' WHERE pro_ID = '$Product_ID'");
            } else {
                $sql = "INSERT INTO itemlist (pro_inf, pro_ID, pro_name, pro_cat, pro_price, pro_maxStock, pro_quantity, pro_reorder, pro_barcode, pro_exp, pro_minStock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssiiiiii", $Product_Description, $Product_ID, $Product_Name, $Product_Category, $Product_Price, $Product_Maximum, $Product_Quantity, $Product_Reorder, $Product_Barcode, $Product_Expiry, $Product_Minimum);
                $stmt->execute();
                    }        
                }

        echo "Data imported successfully.";
    } else {
        echo "Invalid file format. Only XLSX, XLS, and CSV files are allowed.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <!-- Change the name to "import-file" -->
        <input type="file" name="import-file" required data-parsley-type="file" data-parsley-trigger="keyup" class="form-control"/>
        <input type="submit" name="import-excel" value="Import" class="btn btn-success">
    </form>
    <br>
    <p class="error"<?php if(!empty($msg)){echo $msg;} ?></p>
</body>
</html>
