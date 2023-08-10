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
        <link rel="stylesheet" type="text/css" href="cashiering.css">
    </head>

    <body>


    <div class="input-group">
    <form method="post" action="cashieringHandler.php">
        <div class="container">
            <label for="product">Enter Product Code</label>
            <input type="text" id="product" name="product" placeholder="Enter your Product">
            <label for="product">Enter Quantity</label>
            <input type="text" id="quantity" name="quantity" value="1" placeholder="1">
            <input type="submit" value="Add to cart">
        </div>
    </form>
</div>

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
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>
    <?php
        }
    }
    ?>
</tbody>
</table>

<div class="scnd_box">
    <div class="scnd_container">
        <div class="subtotal">
            <div class="total_sub">SubTotal</div>
            <div class="sub_number" id="sub_total">
                <?php
                $subtotal_query = "SELECT SUM(pro_total) AS total_amount FROM cashier_temp";
                $subtotal_result = $conn->query($subtotal_query);

                if ($subtotal_result && $subtotal_result->num_rows > 0) {
                    $subtotal_row = $subtotal_result->fetch_assoc();
                    $total_amount = $subtotal_row["total_amount"];
                    echo $total_amount;
                } else {
                    echo "0";
                }
                $conn->close();
                ?>
            </div>
        </div>
                            <div class="perc_discnt">
                                <div class="discount_perc">Discount %</div>
                                <div class="disc_percnumb" id="disc_perc">0</div>
                                <input type="hidden" name="disc_perc" value="0">
                            </div>

                            <div class="discount">
                                <div class="disc">Discount</div>
                                <div class="disc_numb" id="disc_amount">0</div>
                                <input type="hidden" name="disc_amount" value="0">
                            </div>
                <div class="total">
                    <h2 class="grand_ttl">Grand Total</h2>
                    <div class="total_numb" id="grand-total">0.00</div>
                    <input type="hidden" name="total" value="0">
                    <input type="hidden" name="amount_tendered" value="0">
                    <input type="hidden" name="amount_change" value="0">
                 </div>
</div>
</div>

    </body>
</html>