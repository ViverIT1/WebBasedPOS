<?php
include("PhpCon.php");

// Query the supdelivery table
$supdeliveryQuery = "SELECT DISTINCT supdel_PONO, supdel_supp FROM supdelivery";
$supdeliveryResult = $conn->query($supdeliveryQuery);
$supdelPonoValues = array();
$supdelSuppValues = array();

if ($supdeliveryResult->num_rows > 0) {
    while ($supdelRow = $supdeliveryResult->fetch_assoc()) {
        $supdelPonoValues[] = $supdelRow["supdel_PONO"];
        $supdelSuppValues[] = $supdelRow["supdel_supp"];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Delivery</title>
</head>
<body>
    <h1>Supplier Delivery</h1>

    <form method="post" action="supdelHandler.php"> 
        <label>Input PO# to deliver:</label>
        <input type="text" name="SuppPo" id="SuppPo" autocomplete="off">
        <input type="submit" value="Create supdelivery table">
    </form>
    <?php foreach ($supdelPonoValues as $loopIndex => $supdelPono): ?>
        <?php if (isset($supdelPono) || isset($supdelSuppValues[$loopIndex])): ?>
            <table>
                <thead>
                    <tr>
                        <th>Details</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Supplier Name:<?php echo $supdelSuppValues[$loopIndex]; ?></td>
                        <td><a><button>Approve</button></a></td>
                        <td><a><button>Details</button></a></td>
                        <td><a><button>Delete</button></a></td>
                    </tr>
                    <tr>
                        <td>PO#:<?php echo $supdelPono; ?></td>
                        <td colspan="3">Status:</td>
                    </tr>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>
