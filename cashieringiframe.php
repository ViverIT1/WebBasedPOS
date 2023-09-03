<?php
require('PhpCon.php');

$query = "SELECT * FROM cashier_temp";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cashiering</title>
    <link rel="stylesheet" type="text/css" href="cashieringiframe.css">
</head>
<body>

<table class="content-table">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_id = $row["pro_ID"];
            $product_name = $row["pro_name"];
            $product_quantity = $row["pro_quantity"];
            $product_price = $row["pro_price"];
            $total_price = $row["pro_total"];
    ?>
            <tr>
                <td rowspan="1" class="input-cell"><input type="text" value="<?php echo $product_id ?>" readonly></td>
                <td class="input-cell"><input type="text" value="<?php echo $product_name ?>" readonly></td>
                <td class="input-cell"><input type="number" value="<?php echo $product_quantity ?>"></td>
                <td class="input-cell"><input type="number" value="<?php echo $product_price ?>" readonly></td>
                <td class="input-cell"><input type="number" value="<?php echo $total_price ?>" readonly></td>
                <td class="input-cell">
                    <form method="post" action="cashierRemoveProduct.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <button type="submit" onclick="refreshParent()">Remove</button>
                    </form>
                </td>
            </tr>
    <?php
        }
    }
    ?>
    </tbody>
</table>

<script>
    // Function to refresh the parent page
    function refreshParent() {
        window.parent.location.reload();
    }
</script>

</body>
</html>
