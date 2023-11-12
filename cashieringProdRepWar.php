<?php
include("PhpCon.php");

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $customerName = $data['customer_name'];
    $discount = $data['discount'];
    $tax = $data['tax'];
    $grandTotal = $data['grandTotal'];
    $invoiceNo = $data['invoiceNo'];
    $paymentMethod = $data['paymentMethod'];
    $products = $data['products'];

    $sqlInsertProduct = "INSERT INTO sales_report (invoice_no, product_id, product_name, product_quantity, product_discount, product_total, discount, tax, grand_total, customer_name, paymeans, date_purchased) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmtProduct = $conn->prepare($sqlInsertProduct);

    foreach ($products as $product) {
        $productId = $product['productId'];
        $productName = $product['productName'];
        $productQuantity = $product['productQuantity'];
        $productDiscount = $product['productDiscount'];
        $productTotal = $product['productTotal'];

        $stmtProduct->bind_param("iisdsssssss", $invoiceNo, $productId, $productName, $productQuantity, $productDiscount, $productTotal, $discount, $tax, $grandTotal, $customerName, $paymentMethod);
        $stmtProduct->execute();
    }

    $stmtProduct->close();
    $conn->close();
    echo 'Data saved successfully';
} else {
    echo 'No data received';
}
?>
