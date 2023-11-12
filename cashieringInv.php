<?php
include("PhpCon.php");

$sql = "SELECT MAX(invoice_no) as latest_invoice FROM sales_report";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row["latest_invoice"];
} else {
    echo 0;
}

$conn->close();
?>
