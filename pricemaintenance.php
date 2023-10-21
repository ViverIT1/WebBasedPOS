<?php
include("PhpCon.php");
function displayCurrentValues($conn) {
    $sql = "SELECT addPricePer, taxPer FROM taxmnt ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row;
    } else {
        return array("addPricePer" => 0, "taxPer" => 0); // Return 0 as default values
    }
}

$currentValues = displayCurrentValues($conn);

if (isset($_POST['confirm'])) {
    // Get the values from the form
    $addPricePer = $_POST['additionalPrice'];
    $taxPer = $_POST['tax'];

    // Delete the older row
    $sqlDelete = "DELETE FROM taxmnt";
    $conn->query($sqlDelete);

    // Insert the new values into the database
    $sqlInsert = "INSERT INTO taxmnt (addPricePer, taxPer) VALUES (?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("dd", $addPricePer, $taxPer);

    if ($stmt->execute()) {
        $currentValues = displayCurrentValues($conn);
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Maintenance</title>
    <link rel="stylesheet" type="text/css" href="pricemaintenance.css">
</head>
<body>
    <h1>Pricing Maintenance</h1>
    <div class="pricing-container">
    <form method="POST">
        <label for="additionalPrice" class="pricing-label">Additional Price %:</label>
        <input type="text" name="additionalPrice" id="additionalPrice" class="pricing-input" placeholder="Enter additional price percentage" value="<?php echo isset($currentValues) ? $currentValues['addPricePer'] : ''; ?>">
        <label for="tax" class="pricing-label">Tax %:</label>
        <input type="text" name="tax" id="tax" class="pricing-input" placeholder="Enter Tax" value="<?php echo isset($currentValues) ? $currentValues['taxPer'] : ''; ?>">
        <button type="submit" name="confirm" class="confirm-button">Confirm</button>
    </form>
    </div>
</body>
</html>
