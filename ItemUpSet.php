<?php
require_once('PhpCon.php');
if (isset($_GET['UpID'])) {
    $proID = $_GET['UpID'];

    $query = "SELECT * FROM itemlist WHERE pro_ID = '$proID'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo 'Error: Product ID not found in the database.';
        echo '<a href="itemanage.php"><button>Go back</button></a>';
        exit;
    }
} else {
    echo 'Error getting product ID, Please try again';
    echo '<a href="itemanage.php"><button>Go back</button></a>';
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Item Update</title>
    </head>
    <body>
        <div class="form-container">
            <div class="form-box">
                <form action="itemUp.php" method="post">
                    <input type="hidden" name="Product_ID" value="<?php echo $row['pro_ID']; ?>">
                    <label for="Product_Name">Product Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" value="<?php echo isset($row['pro_name']) ? $row['pro_name'] : ''; ?>" required>
                    <br>
                    <label for="Description">Description:</label>
                    <input type="text" name="Description" id="Description" value="<?php echo isset($row['pro_inf']) ? $row['pro_inf'] : ''; ?>" required>
                    <br>
                    <label for="Category">Category:</label>
                    <input type="text" name="Category" id="Category" value="<?php echo isset($row['pro_cat']) ? $row['pro_cat'] : ''; ?>" required>
                    <br>
                    <label for="Price">Price:</label>
                    <input type="text" name="Price" id="Price" value="<?php echo isset($row['pro_price']) ? $row['pro_price'] : ''; ?>" required>
                    <br>
                    <label for="Quantity">Quantity:</label>
                    <input type="text" name="Quantity" id="Quantity" value="<?php echo isset($row['pro_quantity']) ? $row['pro_quantity'] : ''; ?>" required>
                    <br>
                    <label for="Barcode">Barcode:</label>
                    <input type="text" name="Barcode" id="Barcode" value="<?php echo isset($row['pro_barcode']) ? $row['pro_barcode'] : ''; ?>" required>
                    <br>
                    <label for="Expiry_Date">Expiry Date:</label>
                    <input type="text" name="Expiry_Date" id="Expiry_Date" value="<?php echo isset($row['pro_exp']) ? $row['pro_exp'] : ''; ?>" required>
                    <br>
                    <label for="Reorder_Point">Reorder Point:</label>
                    <input type="text" name="Reorder_Point" id="Reorder_Point" value="<?php echo isset($row['pro_reorder']) ? $row['pro_reorder'] : ''; ?>" required>
                    <br>
                    <label for="Minimum">Minimum Stock Level:</label>
                    <input type="text" name="Minimum" id="Minimum" value="<?php echo isset($row['pro_minStock']) ? $row['pro_minStock'] : ''; ?>" required>
                    <br>
                    <label for="Maximum">Maximum Stock Level:</label>
                    <input type="text" name="Maximum" id="Maximum" value="<?php echo isset($row['pro_maxStock']) ? $row['pro_maxStock'] : ''; ?>" required>
                    <br>
                    <a href="itemUp.php"><button>Update</button></a>
                    <a href="itemanage.php"><button>Close</button></a>
            </form>
            </div>
        </div>
    </body>
</html>