<?php
require ('PhpCon.php');

$query = "SELECT pro_ID, pro_name, pro_quantity, pro_price FROM cashier_temp";
$result = $conn->query($query);

$productRows = '';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $product_id = $row["pro_ID"];
        $product_name = $row["pro_name"];
        $product_quantity = $row["pro_quantity"];
        $product_price = $row["pro_price"];

        $productRows .= "
        <tr>
            <td rowspan=\"1\" class=\"input-cell\"><input type=\"text\" value=\"$product_id\" readonly></td>
            <td class=\"input-cell\"><input type=\"text\" value=\"$product_name\" readonly></td>
            <td class=\"input-cell\"><input type=\"number\" value=\"$product_quantity\"></td>
            <td class=\"input-cell\"><input type=\"number\" value=\"$product_price\" readonly></td>
            <td class=\"input-cell\"><input type=\"text\" value=\"\" readonly></td>
        </tr>";
    }
}
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
        </tr>
    </thead>
    <tbody>
        <tr>
            <?php echo $productRows; ?>
        </tr>
    </tbody>
</table>

<div class="scnd_box">
<div class="scnd_container">
                            <div class="subtotal">
                                <div class="total_sub">SubTotal</div>
                                <div class="sub_number" id="sub_total">0.00</div>
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