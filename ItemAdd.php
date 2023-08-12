<?php
include ('PhpCon.php'); // Make sure the database connection is included
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_REQUEST['import-excel'])) {
    $file = $_FILES['import-file']['tmp_name'];
    $extension = pathinfo($_FILES['import-file']['name'], PATHINFO_EXTENSION);

    if ($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
        $obj = IOFactory::load($file);
        $worksheet = $obj->getActiveSheet();
        $data = $worksheet->toArray();

        $successCount = 0; // Counter for successfully inserted records

        // Start from the second row (index 1) to skip the header row
        for ($rowIndex = 1; $rowIndex < count($data); $rowIndex++) {
            $row = $data[$rowIndex];

            // Process the data from the Excel file
            $Product_Name = $row[0]; // Product Name
            $Product_Description = $row[1]; // Description
            $Product_Category = $row[2]; // Category
            $Product_Price = $row[3]; // Price
            $Product_Quantity = $row[4]; // Quantity
            $Product_Barcode = $row[5]; // Barcode
            $Product_Expiry = $row[6]; // Expiry Date (yyyy-mm-dd)
            $Product_Reorder = $row[7]; // Reorder point
            $Product_Maximum = $row[8] ?? 0; // Maximum Stock Level (use 0 as default if missing)
            $Product_Minimum = $row[9]; // Minimum Stock Level


            // Check if the product already exists
            $existingQuantity = 0;
            $result = mysqli_query($conn, "SELECT pro_quantity FROM itemlist WHERE pro_name = '$Product_Name'");
            
            if ($result !== false) { // Check if query was successful
                if (mysqli_num_rows($result) > 0) { // Check if there are rows returned
                    $existingData = mysqli_fetch_assoc($result);
                    $existingQuantity = $existingData['pro_quantity'];
                } else {
                    // Product does not exist, handle this case if needed
                    // For now, you can set $existingQuantity to 0 or any other appropriate value
                    $existingQuantity = 0;
                }
            } else {
                echo "Query error: " . mysqli_error($conn);
            }

            // Insert or update data based on existence
            if ($existingQuantity > 0) {
                $updatedQuantity = $existingQuantity + $Product_Quantity;
                $updateQuery = "UPDATE itemlist SET pro_quantity = '$updatedQuantity' WHERE pro_name = '$Product_Name'";
                if (mysqli_query($conn, $updateQuery)) {
                    $successCount++;
                } else {
                    echo "Update error: " . mysqli_error($conn);
                }
            } else {
                $insertQuery = "INSERT INTO itemlist (pro_inf, pro_name, pro_cat, pro_price, pro_maxStock, pro_quantity, pro_reorder, pro_barcode, pro_exp, pro_minStock) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);

                if ($stmt) {
                    $stmt->bind_param("sssssiisii", $Product_Description, $Product_Name, $Product_Category, $Product_Price, $Product_Maximum, $Product_Quantity, $Product_Reorder, $Product_Barcode, $Product_Expiry, $Product_Minimum);
                    if ($stmt->execute()) {
                        $successCount++;
                    } else {
                        echo "Insert error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Prepare error: " . $conn->error;
                }
            }
        }

        echo "$successCount records inserted or updated successfully";
    } else {
        echo "Invalid file format. Only XLSX, XLS, and CSV files are allowed.";
    }
}

$query = "SELECT DISTINCT pro_cat FROM itemlist";
$result = $conn->query($query);

$values = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $values[] = $row["pro_cat"];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="itemanage.css">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="import-file" required data-parsley-type="file" data-parsley-trigger="keyup" class="form-control"/>
        <input type="submit" name="import-excel" value="Import" class="btn btn-success">
    </form>
    <br>
            <div class="form-box">
                <form action="ItemAddHandler.php" method="post">
                    <label for="Product_Name">Product Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" required>
                    <br>
                    <label for="Description">Description:</label>
                    <input type="text" name="Description" id="Description" required>
                    <br>
                    <label for="Category">Category:</label>
                    <input type="text" list="categoryList" required>
                        <datalist id="categoryList">
                        <option>---</option>
                        <?php foreach ($values as $value): ?>
                            <?php if(isset($value)): ?>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </datalist>

                    <br>
                    <label for="Price">Price:</label>
                    <input type="text" name="Price" id="Price" required>
                    <br>
                    <label for="Quantity">Quantity:</label>
                    <input type="text" name="Quantity" id="Quantity" required>
                    <br>
                    <label for="Barcode">Barcode:</label>
                    <input type="text" name="Barcode" id="Barcode" required>
                    <br>
                    <label for="Expiry_Date">Expiry Date:</label>
                    <input type="text" name="Expiry_Date" id="Expiry_Date" required>
                    <br>
                    <label for="Reorder_Point">Reorder Point:</label>
                    <input type="text" name="Reorder_Point" id="Reorder_Point" required>
                    <br>
                    <label for="Minimum">Minimum Stock Level:</label>
                    <input type="text" name="Minimum" id="Minimum" required>
                    <br>
                    <label for="Maximum">Maximum Stock Level:</label>
                    <input type="text" name="Maximum" id="Maximum" required>
                    <br>
                    <input type="submit" value="Add">
                        <button type="button" id="closeaddpop"><a href="itemanage.php">Close</a></button>
                </form>
    </div>
</body>
</html>