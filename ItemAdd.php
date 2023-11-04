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
            $Product_IDQR = $row[0]; // Product IDQR
            $Product_Name = $row[1]; // Product Name
            $Product_Description = $row[2]; // Description
            $Product_Category = $row[3]; // Category
            $Product_Price = $row[4]; // Price
            $Product_Expiry = $row[5]; // Expiry Date (yyyy-mm-dd)

            // Check if the product already exists based on Product IDQR
            $existingQuantity = 0;
            $result = mysqli_query($conn, "SELECT pro_quantity FROM itemlist WHERE pro_IDQR = '$Product_IDQR'");

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
                $updatedQuantity = $existingQuantity + 1; // You may want to update the quantity differently
                $updateQuery = "UPDATE itemlist SET pro_quantity = '$updatedQuantity' WHERE pro_IDQR = '$Product_IDQR'";
                if (mysqli_query($conn, $updateQuery)) {
                    $successCount++;
                } else {
                    echo "Update error: " . mysqli_error($conn);
                }
            } else {
                $insertQuery = "INSERT INTO itemlist (pro_IDQR, pro_name, pro_inf, pro_cat, pro_price, pro_exp) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertQuery);

                if ($stmt) {
                    $stmt->bind_param("ssssss", $Product_IDQR, $Product_Name, $Product_Description, $Product_Category, $Product_Price, $Product_Expiry);
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
                <label for="Product_Name">Product ID:</label>
                    <input type="text" name="Product_IDQR" id="Product_IDQR" required>
                    <br>
                    <label for="Product_Name">Product Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" required>
                    <br>
                    <label for="Description">Description:</label>
                    <input type="text" name="Description" id="Description" required>
                    <br>
                    <label for="Category">Category:</label>
                    <input type="text" list="categoryList" name="Category" autocomplete="off" required>
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
                    <input type="submit" value="Add">
                        <button type="button" id="closeaddpop"><a href="itemanage.php">Close</a></button>
                </form>
    </div>
</body>
</html>