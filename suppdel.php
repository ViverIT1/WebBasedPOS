<?php
include("PhpCon.php");

// Query the supdelivery table
$supdeliveryQuery = "SELECT DISTINCT supdel_PONO, supdel_supp FROM supdelivery";
$supdeliveryResult = $conn->query($supdeliveryQuery);

if ($supdeliveryResult->num_rows > 0) {
    $supdeliveryData = array();

    while ($supdelRow = $supdeliveryResult->fetch_assoc()) {
        $supdelPono = $supdelRow["supdel_PONO"];
        $supdelSupp = $supdelRow["supdel_supp"];

        // Group data by PO number
        if (!isset($supdeliveryData[$supdelPono])) {
            $supdeliveryData[$supdelPono] = array(
                'supdelSupp' => $supdelSupp,
            );
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Delivery</title>
    <link rel="stylesheet" type="text/css" href="suppdel.css">
</head>
<body>
    <h1>Supplier Delivery</h1>

<div class="form-container">
        <form method="post" action="suppdelHandler.php">
            <label for="SuppPo">Input PO# to deliver:</label>
            <input type="text" name="SuppPo" id="SuppPo" autocomplete="off">
            <input class="action-button approve-button" type="submit" value="Create supdelivery table">
        </form>
    </div>

    <?php foreach ($supdeliveryData as $supdelPono => $data): ?>
        <table class= "order-table">
            <thead>
                <tr>
                    <th class= "details-header">Details</th>
                    <th colspan="3" class= "action-header">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class= "supplier-name">Supplier Name:<?php echo $data['supdelSupp']; ?></td>
                    <td>
                        <form method="post" action="suppdeltoinv.php">
                            <input type="hidden" name="pro_PONO" value="<?php echo $supdelPono; ?>">
                            <button type="submit" class="action-button approve-button">Delivered</button>
                        </form>
                    </td>
                    <td><a><button class= "action-button details-button">Details</button></a></td>
                    <td><a><button class= "action-button delete-button">Cancelled</button></a></td>
                </tr>
                <tr>
                    <td class="po-number">PO#:<?php echo $supdelPono; ?></td>
                    <td colspan="3" class= "status">Status:</td>
                </tr>
            </tbody>
        </table>
    <?php endforeach; ?>
</body>
</html>
