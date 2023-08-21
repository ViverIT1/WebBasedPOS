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

<?php
$cartQuery = "SELECT c.pro_name, c.pro_price, c.pro_quantity,
i.itemdis, i.itemdisper, 
c.pro_price * c.pro_quantity AS pro_total
FROM cashier_temp c
LEFT JOIN itemdiscount i ON c.pro_name = i.pro_name
ORDER BY c.pro_ID";

$cartResult = $conn->query($cartQuery);

$totalPrice = 0;
$totalDiscountAmount = 0;

if ($cartResult) {
    while ($cartItem = $cartResult->fetch_assoc()) {
        $itemPrice = $cartItem['pro_price'];
        $itemQuantity = $cartItem['pro_quantity'];
        $itemTotal = $cartItem['pro_total'];
        $itemDiscount = $cartItem['itemdis'];
        $itemDiscountPercentage = $cartItem['itemdisper'];

        if ($itemDiscount !== null) {
            $discountedPrice = $itemPrice - $itemDiscount;
            $discountAmount = $itemDiscount * $itemQuantity;
            $itemTotalDiscounted = $discountedPrice * $itemQuantity;
            $totalDiscountAmount += $discountAmount;
        } elseif ($itemDiscountPercentage !== null) {
            $discountedPrice = $itemPrice * (1 - $itemDiscountPercentage);
            $discountAmount = $itemPrice - $discountedPrice;
            $itemTotalDiscounted = $discountedPrice * $itemQuantity;
            $totalDiscountAmount += $discountAmount * $itemQuantity;
        } else {
            $itemTotalDiscounted = $itemTotal;
        }

        $totalPrice += $itemTotalDiscounted;
    }
}

$totalPriceAfterDiscount = $totalPrice - $totalDiscountAmount;
?>

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
                    echo number_format($total_amount, 2); 
                } else {
                    echo "0.00";
                }
                ?>
            </div>
        </div>
        <div class="perc_discnt">
            <div class="discount_perc">Discount %</div>
            <div class="disc_percnumb" id="disc_perc">
                <?php
                if ($totalPrice > 0) {
                    $discountPercentage = ($totalDiscountAmount / $totalPrice) * 100;
                    echo number_format($discountPercentage, 2);
                } else {
                    echo "0.00";
                }
                ?>
            </div>
            <input type="hidden" name="disc_perc" value="0">
        </div>

        <div class="discount">
            <div class="disc">Discount</div>
            <div class="disc_numb" id="disc_amount">
                <?php
                echo number_format($totalDiscountAmount, 2); 
                ?>
            </div>
            <input type="hidden" name="disc_amount" value="0">
        </div>
        <div class="total">
            <h2 class="grand_ttl">Grand Total</h2>
            <div class="total_numb" id="grand-total">
                <?php
                echo number_format($totalPrice, 2);
                ?>
            </div>
            <input type="hidden" name="total" value="0">
            <input type="hidden" name="amount_tendered" value="0">
            <input type="hidden" name="amount_change" value="0">
        </div>
    </div>
</div>

<div class="iframe-cashiering">
<iframe src="cashieringiframe.php"></iframe>
</div>

<button id="popupButton" type="button">Settle Payment</button>

<?php

echo "ItemDis: " . $itemDiscount . "<br>";
echo "ItemPer: " . $itemDiscountPercentage ."<br>";

?>

    </body>
</html>