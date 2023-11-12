<?php
include("PhpCon.php");

// Fetch sales data from the database
$sql = "SELECT invoice_no, customer_name, SUM(product_quantity) AS total_quantity, SUM(grand_total) AS total_amount, MAX(date_purchased) AS date_purchased FROM sales_report GROUP BY invoice_no";
$result = $conn->query($sql);

// Check if the request is for retrieving product details based on the invoice number
if (isset($_GET['invoice_number'])) {
    // Fetch products associated with the provided invoice number
    $invoiceNumber = $_GET['invoice_number'];

    $productSql = "SELECT * FROM sales_report WHERE invoice_no = $invoiceNumber";
    $productResult = $conn->query($productSql);

    // Prepare the product details to send as a JSON response
    $products = [];
    while ($row = $productResult->fetch_assoc()) {
        $products[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($products);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link rel="stylesheet" type="text/css" href="salesreport.css">
</head>
<body>
<div class="modal-container">
        <div id="productModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Product Details</h2>
                <div id="productDetails"></div>
            </div>
        </div>
    </div>
    </div>
    <h1>Sales Report</h1>
    <div class="container">
        <div class="filter-container">
            <label for="start-date">Start Date:</label>
            <input type="date" id="start-date">
            <label for="end-date">End Date:</label>
            <input type="date" id="end-date">
        </div>
        
        <form class="search-form">
            <input type="search" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>
    <table class="content-table">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Customer Name</th>
                <th>Quantity</th>
                <th>Amount</th>
                <th>Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['invoice_no']; ?></td>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['total_quantity']; ?></td>
                        <td><?php echo $row['total_amount']; ?></td>
                        <td><?php echo $row['date_purchased']; ?></td>
                        <td><button>See Sales Details</button></td>
                    </tr>
                    <?php
                }
            } else {
                echo "0 results";
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
<script>
        function closeModal() {
            var modal = document.getElementById("productModal");
            modal.style.display = "none";
        }

        function showProductDetails(invoiceNumber) {
    var modal = document.getElementById("productModal");
    var productDetails = document.getElementById("productDetails");

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "salesreport.php?invoice_number=" + invoiceNumber, true);

    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var products = JSON.parse(xhr.responseText);
                var detailsHTML = "";

                products.forEach(function(product) {
                    for (var key in product) {
                        if (key === 'product_id') {
                            detailsHTML += "<p>Product ID: " + product[key] + "</p>";
                        } else if (key === 'product_name') {
                            detailsHTML += "<p>Product Name: " + product[key] + "</p>";
                        } else if (key === 'product_quantity') {
                            detailsHTML += "<p>Quantity: " + product[key] + "</p>";
                        } else if (key === 'product_discount') {
                            detailsHTML += "<p>Discount: " + product[key] + "</p>";
                        } else if (key === 'product_total') {
                            detailsHTML += "<p>Total: " + product[key] + "</p>";
                        } else if (key === 'discount') {
                            detailsHTML += "<p>Discount: " + product[key] + "</p>";
                        } else if (key === 'tax') {
                            detailsHTML += "<p>Tax: " + product[key] + "</p>";
                        } else if (key === 'grand_total') {
                            detailsHTML += "<p>Grand Total: " + product[key] + "</p>";
                        }
                    }
                    detailsHTML += "<hr>";
                });

                productDetails.innerHTML = detailsHTML;
                modal.style.display = "block";
            } else {
                console.error("Error: " + xhr.status);
                alert("Error fetching product details");
            }
        }
    };

    xhr.send();
}

    // Button click event listener
    var buttons = document.querySelectorAll('button');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var row = this.parentNode.parentNode;
            var cells = row.getElementsByTagName("td");
            var invoiceNumber = cells[0].innerHTML;

            showProductDetails(invoiceNumber);
        });
    });

</script>
</html>