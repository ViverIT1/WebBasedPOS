<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Receipt Maintenance</title>
    <link rel="stylesheet" type="text/css" href="recieptmaintenance.css">
</head>
<body>
<?php
// Include your database connection file
include("PhpCon.php");

// Initialize variables
$storeName = 'Default Store Name';
$storeAddress = 'Default Address';
$storePhone = 'Default Phone Number';
$storeEmail = 'Default Email';
$textboxValues = array('Text 1', 'Text 2', 'Text 3', 'Text 4');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values
    $storeName = $_POST["storeName"];
    $storeAddress = $_POST["storeAddress"];
    $storePhone = $_POST["storePhone"];
    $storeEmail = $_POST["storeEmail"];
    $textboxValues = array($_POST["textbox1"], $_POST["textbox2"], $_POST["textbox3"], $_POST["textbox4"]);

    // SQL to insert or update data
    $sql = "INSERT INTO reclay (id, storeName, storeAddress, storePhone, storeEmail, textbox1, textbox2, textbox3, textbox4)
            VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE storeName = VALUES(storeName), storeAddress = VALUES(storeAddress),
            storePhone = VALUES(storePhone), storeEmail = VALUES(storeEmail),
            textbox1 = VALUES(textbox1), textbox2 = VALUES(textbox2),
            textbox3 = VALUES(textbox3), textbox4 = VALUES(textbox4)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $storeName, $storeAddress, $storePhone, $storeEmail, $textboxValues[0], $textboxValues[1], $textboxValues[2], $textboxValues[3]);

    if ($stmt->execute()) {
        echo "Data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from the database
$sql = "SELECT storeName, storeAddress, storePhone, storeEmail, textbox1, textbox2, textbox3, textbox4 FROM reclay WHERE id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storeName = $row["storeName"];
    $storeAddress = $row["storeAddress"];
    $storePhone = $row["storePhone"];
    $storeEmail = $row["storeEmail"];
    $textboxValues = array($row["textbox1"], $row["textbox2"], $row["textbox3"], $row["textbox4"]);
}
?>


<h1> Temporary Receipt Maintenance</h1>

<!-- Receipt Preview Section -->
<div class="receipt-preview">
<div class="preview">
    <!-- Store Information Preview -->
    <div class="store-info">
        <h1 class="sub-title">Header</h1>
        <p>Store Name: <span><?php echo $storeName; ?></span></p>
        <p>Store Address: <span><?php echo $storeAddress; ?></span></p>
        <p>Store Phone: <span><?php echo $storePhone; ?></span></p>
        <p>Email: <span><?php echo $storeEmail; ?></span></p>
    </div>

    <!-- Date and Time Preview -->
    <div class="date-time">
        <p>Date: 02/11/2023 12:34:56</p>
    </div>

    <!-- Product Table Preview -->
    <table class="product-table">
        <thead>
        <tr>
            <th>Product</th>
            <th>Unit</th>
            <th>Qty</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Screw</td>
            <td>kg</td>
            <td>1.5</td>
            <td>120</td>
        </tr>
        </tbody>
    </table>

    <!-- Subtotal, Discount, and Tax Preview -->
    <div class="subtotal">
        Subtotal: $120.00
    </div>

    <div class="discount">
        Discount: $0.00
    </div>

    <div class="tax">
        Tax: $0.00
    </div>

    <!-- Grand Total Preview -->
    <div class="grand-total">
        Grand Total: $120.00
    </div>

    <!-- Footer Preview -->
    <div class="footer">
        <h2>Footer</h2>
        <div class="additional-textboxes">
            <p>Textbox 1: <span><?php echo $textboxValues[0]; ?></span></p>
            <p>Textbox 2: <span><?php echo $textboxValues[1]; ?></span></p>
            <p>Textbox 3: <span><?php echo $textboxValues[2]; ?></span></p>
            <p>Textbox 4: <span><?php echo $textboxValues[3]; ?></span></p>
        </div>
    </div>
</div>

</div>

<!-- Receipt Maintenance Form -->
<form method="post">
    <h2>Receipt Maintenance Form</h2>
    <input type="text" name="storeName" placeholder="Store Name" value="<?php echo $storeName; ?>">
    <input type="text" name="storeAddress" placeholder="Store Address" value="<?php echo $storeAddress; ?>">
    <input type="text" name="storePhone" placeholder="Store Phone Number" value="<?php echo $storePhone; ?>">
    <input type="text" name="storeEmail" placeholder="Email" value="<?php echo $storeEmail; ?>">
    <?php
    for ($i = 0; $i < 4; $i++) {
        echo '<input type="text" name="textbox' . ($i + 1) . '" placeholder="Textbox ' . ($i + 1) . '" value="' . $textboxValues[$i] . '">';
    }
    ?>
    <input type="submit" value="Update All Textboxes">
</form>

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>
