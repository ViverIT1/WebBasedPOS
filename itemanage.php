<?php
include ('PhpCon.php');
$query = "SELECT * FROM itemlist";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Management</title>
    <link rel="stylesheet" type="text/css" href="itemanage.css">
    <script src="itemanage.js"></script>
</head>

<body>
        <div class="header">
            <h1>Product Management</h1>
            <a href="ItemAdd.php"><button class="add-button" type="button">+</button></a>
        </div>

    <form>
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <table class="content-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Expiry Date</th>
                <th>Reorder Point</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['pro_IDQR']; ?></td>
                    <td><?php echo $row['pro_name']; ?></td>
                    <td><?php echo $row['pro_inf']; ?></td>
                    <td><?php echo $row['pro_cat']; ?></td>
                    <td><?php echo $row['pro_price']; ?></td>
                    <td><?php echo $row['pro_quantity']; ?></td>
                    <td><?php echo $row['pro_exp']; ?></td>
                    <td><?php echo $row['pro_reorder']; ?></td>
                    <td>
                        <button><a href="itemUpSet.php?UpSetID=<?php echo $row['pro_ID']; ?>">Update</button>
                    </td>
                    <td>
                        <button><a href="itemRe.php?ReID=<?php echo $row['pro_ID']; ?>">Remove</a></button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>



    <div class="AddWindow" id="openaddpop">
        <div class="form-container">
            <div class="form-box">

                <form action="ItemAdd.php" method="post">
                    <label for="Product_ID">Product ID:</label>
                    <input type="text" name="Product_ID" id="Product_ID" autocomplete="off" required>
                    <br>
                    <label for="Product_Name">Product Name:</label>
                    <input type="text" name="Product_Name" id="Product_Name" autocomplete="off" required>
                    <br>
                    <label for="Description">Description:</label>
                    <input type="text" name="Description" id="Description" autocomplete="off" required>
                    <br>
                    <label for="Category">Category:</label>
                    <input type="text" name="Category" id="Category" autocomplete="off" required>
                    <br>
                    <label for="Price">Price:</label>
                    <input type="text" name="Price" id="Price" autocomplete="off" required>
                    <br>
                    <label for="Quantity">Quantity:</label>
                    <input type="text" name="Quantity" id="Quantity" autocomplete="off" required>
                    <br>
                    <label for="Barcode">QR Code:</label>
                    <input type="text" name="QRcode" id="QRcode" autocomplete="off" required>
                    <br>
                    <label for="Expiry_Date">Expiry Date:</label>
                    <input type="text" name="Expiry_Date" id="Expiry_Date" autocomplete="off" required>
                    <br>
                    <label for="Reorder_Point">Reorder Point:</label>
                    <input type="text" name="Reorder_Point" id="Reorder_Point" autocomplete="off" required>
                    <br>
                    <label for="Minimum">Minimum Stock Level:</label>
                    <input type="text" name="Minimum" id="Minimum" autocomplete="off" required>
                    <br>
                    <label for="Maximum">Maximum Stock Level:</label>
                    <input type="text" name="Maximum" id="Maximum" autocomplete="off" required>
                    <br>
                    <input type="submit" value="Add">
                        <button type="button" onclick="closeAddWindow()" id="closeaddpop">Close</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
