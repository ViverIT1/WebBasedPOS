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
    <link rel="stylesheet" type="text/css" href=".css">
    <script src=".js"></script>
</head>

<body>
<div class="header">
    <h1>Purchased Order to Supplier</h1>
    <a href="purchOrderAdd.php"><button class="add-button" type="button">+</button></a>
</div>

<?php foreach($ponovalues as $loopIndex => $pono): ?>
    <?php if(isset($pono) || isset($posuppvalues[$loopIndex])): ?>
        <table>
            <thead>
                <tr>
                    <th>Details</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Supplier Name:<?php echo $posuppvalues[$loopIndex]; ?></td>
                    <td><a><button>Approve</button></a></td>
                    <td><a><button>Details</button></a></td>
                    <td><a><button>Delete</button></a></td>
                </tr>
                <tr>
                    <td>PO#:<?php echo $pono; ?></td>
                    <td colspan="3">Status:</td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>
<?php endforeach; ?>


</body>