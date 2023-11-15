<?php

include ("PhpCon.php");
$poquery = "SELECT DISTINCT po_PONO, po_supp  FROM polist";
$poresult = $conn->query($poquery);
$ponovalues = array();
$posuppvalues = array();
if ($poresult->num_rows > 0) {
    while ($porow = $poresult->fetch_assoc()) {
        $ponovalues[] = $porow["po_PONO"];
        $posuppvalues[] = $porow["po_supp"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purchased Order to Supplier</title>
    <link rel="stylesheet" type="text/css" href="purchaseOrder.css">
    <script src=".js"></script>
</head>

<body>
<div class="header">
    <h1>Purchased Order to Supplier</h1>
    <a href="purchOrderAdd.php"><button class="add-button" type="button">+</button></a>
</div>

<?php foreach($ponovalues as $loopIndex => $pono): ?>
    <?php if(isset($pono) || isset($posuppvalues[$loopIndex])): ?>
        <div class="table-container">
        <table class="order-table">
            <thead>
                <tr>
                    <th class="details-header">Details</th>
                    <th colspan="3" class="action-header">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="supplier-name">Supplier Name:<?php echo $posuppvalues[$loopIndex]; ?></td>
                    <td><a><button class="action-button approve-button">Approve</button></a></td>
                    <td><a><button class="action-button details-button">Details</button></a></td>
                    <td><a><button class="action-button delete-button">Delete</button></a></td>
                </tr>
                <tr>
                    <td class="po-number">PO#:<?php echo $pono; ?></td>
                    <td colspan="3" class="status">Status:</td>
                </tr>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
<?php endforeach; ?>


</body>