<?php
    include("PhpCon.php");

    if ($conn) {
        // Query to retrieve tax percentage from taxmnt table
        $query = "SELECT taxPer FROM taxmnt WHERE taxper >= 0";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                // Fetch the tax percentage
                $row = mysqli_fetch_assoc($result);
                $taxPercentage = $row['taxPer'];
            } else {
                // No data matching the condition
                $taxPercentage = 0.00; // Assign a default value
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            echo "Query error: " . mysqli_error($conn);
        }
    } else {
        echo "Database connection error: " . mysqli_connect_error();
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
                    <form method="post" action="cashieringRetrieve.php" id="cashierForm" autocomplete="off">
                        <div class="container">
                            <label for="product">Enter Product Code</label>
                            <input type="text" id="productQR" name="productQR" placeholder="Enter your Product">
                            <label for="product">Enter Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="1" placeholder="1">
                            <input type="submit" value="Add to cart">
                        </div>
                    </form>                              
                </div>

                <div class="table-container">
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Discount%</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="totals-container">

                <div class="subtotal">
                    <div class="total_sub">SubTotal:</div>
                    <div class="sub_number" id="sub_total">0.00</div>
                </div>
        
                <div class="perc_discnt">
                    <div class="discount_perc">Discount %:</div>
                    <div class="disc_percnumb" id="disc_perc">0.00</div>
                </div>
        
                <div class="tax">
                    <div class="tax_perc">Tax %:</div>
                    <div class="tax_percnumb" id="tax_perc"><?php echo $taxPercentage; ?></div>
                </div>

        
                <div class="total">
                    <div class="grand_ttl">Grand Total:</div>
                    <div class="total_numb" id="grand-total">0.00</div>
                    <input type="hidden" name="total" value="0">
                    <input type="hidden" name="amount_tendered" value="0">
                    <input type="hidden" name="amount_change" value="0">
                </div>
        
                <button id="popupButton" type="button" class="btn" onclick="openPopup()">Settle Payment</button>
                <div class="modal-overlay" id="modal-overlay"></div>
                <div class="popup" id="popup">
                    <div class="header">
                        <h3>Payment Method</h3>
                    </div>
                    <div class="payment-method">
                        <label for="payment-method">Payment Method:</label>
                        <select id="payment-method" name="payment-method" onchange="toggleCashReceived()">
                            <option value="">---</option>
                            <option value="gcash">GCash</option>
                            <option value="cash">Cash</option>
                        </select>
                    </div>
                    <div class="cash-received" id="cash-received-container">
                        <label for="cash-received">Cash Received:</label>
                        <input type="number" id="cash-received" name="cash-received" step="0.01" placeholder="Enter cash received">
                    </div>
                    <div class="change" id="change-container">
                        <label for="change">Change:</label>
                        <div class="change-amount" id="change-amount">0.00</div>
                    </div>
                    <div class="popup-buttons">
                        <button type="button" class="okay" onclick="printReceipt()">Print Receipt</button>
                        <button type="button" class="cancel" onclick="closePopup()">Go Back</button>
                    </div>
                </div>
                        
            <script>
                function fetchAndPopulateProducts(productID, quantity) {
                    const url = `cashieringRetrieve.php?productID=${productID}`;

                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.length > 0) {
                                const existingRow = document.querySelector(`.content-table tbody tr[data-product-id="${data[0].pro_IDQR}"]`);
                                if (existingRow) {
                                    const existingQuantityCell = existingRow.querySelector('.input-cell.quantity');
                                    const existingQuantity = parseInt(existingQuantityCell.textContent, 10);
                                    const newQuantity = existingQuantity + parseInt(quantity, 10);
                                    existingQuantityCell.textContent = newQuantity;

                                    const itemDiscountPercentage = parseFloat(data[0].itemdisper || '0.00'); // Set a default value for itemDiscountPercentage
                                    const itemPriceCell = existingRow.querySelector('.input-cell.unit-price');
                                    let itemPrice = parseFloat(itemPriceCell.textContent);
                                    // Check if "itemPrice" is available, otherwise, use the original product price
                                    if (data[0].itemPrice) {
                                        itemPrice = parseFloat(data[0].itemPrice);
                                    }
                                    const itemTotalCell = existingRow.querySelector('.input-cell.item-total');
                                    const discountTotal = (itemDiscountPercentage / 100) * (itemPrice * newQuantity);
                                    itemTotalCell.textContent = ((itemPrice * newQuantity) - discountTotal).toFixed(2);

                                    const discountPercentageCell = existingRow.querySelector('.input-cell.discount-percentage');
                                    discountPercentageCell.textContent = itemDiscountPercentage;
                                } else {
                                    const tableBody = document.querySelector('.content-table tbody');
                                    const row = document.createElement('tr');
                                    row.dataset.productId = data[0].pro_IDQR;

                                    const itemPrice = parseFloat(data[0].pro_price); // Get the item price

                                    row.innerHTML = `
                                        <td>${data[0].pro_IDQR}</td>
                                        <td>${data[0].pro_name}</td>
                                        <td class="input-cell quantity">${quantity}</td>
                                        <td class="input-cell unit-price">${itemPrice}</td>
                                        <td class="input-cell discount-percentage">${data[0].itemdisper || '0.00'}</td>
                                        <td class="input-cell item-total">${((itemPrice * quantity) - (itemPrice * quantity * (data[0].itemdisper || '0.00') / 100)).toFixed(2)}</td>
                                        <td class="input-cell">
                                            <button type="button" onclick="removeProduct(this)">Remove</button>
                                        </td>
                                    `;

                                    tableBody.appendChild(row);
                                }

                                updateSubtotal();
                                clearInputAndQuantity();
                            } else {
                                console.error('Received incomplete or undefined data from the server');
                            }
                        })
                        .catch(error => console.error(error));
                }
        
                function updateSubtotal() {
                    let subtotal = 0;
                    const itemTotalCells = document.querySelectorAll('.input-cell.item-total');
                    itemTotalCells.forEach(cell => {
                        subtotal += parseFloat(cell.textContent);
                    });
        
                    // Update the subtotal and grand total
                    document.getElementById('sub_total').textContent = subtotal.toFixed(2);
                    updateGrandTotal();
                }
        
                function updateGrandTotal() {
                const subtotal = parseFloat(document.getElementById('sub_total').textContent);
                const taxPercentage = parseFloat(document.querySelector('.tax_percnumb').textContent); // Select the element containing tax percentage

                // Fetch the discount information based on the highest gendisqual less than or equal to subtotal
                fetchDiscountForSubtotal(subtotal)
                    .then(discountPercentage => {
                        // Calculate the grand total with discount and tax
                        const discount = (discountPercentage / 100) * subtotal;
                        const tax = (taxPercentage / 100) * subtotal;
                        const grandTotal = subtotal - discount + tax;

                        // Update the grand total and discount percentage
                        document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
                        document.querySelector('.disc_percnumb').textContent = discountPercentage.toFixed(2);
                    })
                    .catch(error => console.error(error));
                }

                function fetchDiscountForSubtotal(subtotal) {
                    const url = `cashieringRetrieveGen.php?subtotal=${subtotal}`;

                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            return parseFloat(data.discountPercentage);
                        });
                }

                function fetchTaxPercentage() {
                    // Make an AJAX request to retrieve the tax percentage
                    fetchTaxPercentageFromServer()
                        .then(taxPercentage => {
                            console.log("Tax Percentage Fetched:", taxPercentage); // Debugging
                            // Update the tax percentage element
                            document.getElementById('tax_perc').textContent = taxPercentage.toFixed(2);
                            // After updating the tax percentage, recalculate the grand total
                            updateGrandTotal();
                        })
                        .catch(error => console.error(error));
                }

                function fetchTaxPercentageFromServer() {
                    // Send an API request to retrieve the tax percentage from the server
                    const url = 'cashieringRetrieveTax.php';

                    return fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            // If the data structure returned from taxRetrieve.php has changed,
                            // make sure to access the tax percentage correctly.
                            return parseFloat(data.taxPer); // Adjust this based on your JSON structure
                        });
                }

                function removeProduct(button) {
                    const row = button.parentElement.parentElement;

                    // Display a confirmation dialog before removing the item
                    const confirmRemove = confirm('Are you sure you want to remove this item from the cart?');

                    if (confirmRemove) {
                        row.remove();
                        updateSubtotal();
                    }
                }
    
                document.querySelector('#cashierForm').addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent the default form submission
                    const productID = encodeURIComponent(document.querySelector('#productQR').value);
                    const quantity = document.querySelector('#quantity').value;
                    fetchAndPopulateProducts(productID, quantity);
                });
                
                function clearInputAndQuantity() {
                document.querySelector('#productQR').value = '';
                document.querySelector('#quantity').value = 1;
                }
                // Listen to discount and tax input changes
                document.querySelector('input[name="disc_perc"]').addEventListener('input', updateGrandTotal);
                document.querySelector('input[name="tax_perc"]').addEventListener('input', updateGrandTotal);

                function openPopup() {
                    const popup = document.getElementById('popup');
                    const modalOverlay = document.getElementById('modal-overlay');
                    popup.classList.add('open-popup');
                    modalOverlay.classList.add('open');

                    toggleCashReceived();

                    const okButton = document.querySelector('.popup-buttons .okay');
                    okButton.addEventListener('click', calculateChange);

                    // Add an event listener to the "cash-received" input field
                    const cashReceivedInput = document.getElementById('cash-received');
                    cashReceivedInput.addEventListener('input', calculateChange);

                    // Get the element where we'll display the selected products
                    const popupProductList = document.getElementById('popup-product-list');

                    // Clear the previous content
                    popupProductList.innerHTML = '';

                    let subtotal = 0; // Initialize subtotal

                    document.querySelector('#payment-method').value = ''; // Select the default option initially    

                    selectedProducts.forEach(product => {
                        // Deduct discounts from the price before displaying
                        const price = parseFloat(product.price) - (parseFloat(product.price) * (parseFloat(product.discount) / 100));

                        // Calculate the total for the product
                        const productTotal = parseFloat(product.quantity) * price;

                        subtotal += productTotal; // Add the product total to the subtotal

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.name}</td>
                            <td>${price.toFixed(2)}</td>
                            <td>${product.quantity}</td>
                            <td>pcs</td> <!-- "pcs" in the unit column -->
                            <td>${productTotal.toFixed(2)}</td>
                        `;
                        popupProductList.appendChild(row);
                    });

                    // Update the Subtotal element in the popup
                    const popupSubtotal = document.querySelector('.subtotal');
                    popupSubtotal.textContent = `Subtotal: ${subtotal.toFixed(2)}`;
                }


                function closePopup() {
                    const popup = document.getElementById('popup');
                    const modalOverlay = document.getElementById('modal-overlay');
                    popup.classList.remove('open-popup');
                    modalOverlay.classList.remove('open');
                }
                // Event listener for "Settle Payment" button to open the popup
                document.getElementById('popupButton').addEventListener('click', openPopup);

                // Event listener for the modal overlay to close the popup when clicked outside
                document.getElementById('modal-overlay').addEventListener('click', closePopup);

                function toggleCashReceived() {
                    const paymentMethod = document.getElementById('payment-method').value;
                    const cashReceivedContainer = document.getElementById('cash-received-container');
                    const changeContainer = document.getElementById('change-container');

                    if (paymentMethod === 'cash') {
                        cashReceivedContainer.style.display = 'block';
                        changeContainer.style.display = 'block';
                    } else {
                        cashReceivedContainer.style.display = 'none';
                        changeContainer.style.display = 'none';
                    }
                }

                // Add an event listener to the "cash-received" input field
                const cashReceivedInput = document.getElementById('cash-received');
                cashReceivedInput.addEventListener('input', calculateChange);

                function calculateChange() {
                    const cashReceived = parseFloat(document.getElementById('cash-received').value);
                    const grandTotal = parseFloat(document.getElementById('grand-total').textContent);
                    const change = cashReceived - grandTotal;

                    // Display the calculated change
                    document.getElementById('change-amount').textContent = change.toFixed(2);

                    // Update the hidden input field for amount_change
                    document.querySelector('input[name="amount_change"]').value = change;

                    // You can also handle negative change (if cash received is less than the grand total)
                    if (change < 0) {
                        // Handle the case where the cash received is less than the grand total (e.g., show an error message)
                        console.error("Cash received is less than the grand total");
                    }
                }
// Define the generateReceiptData function
function printReceipt() {
    // Create an empty array to store receipt data
    const receiptData = [];

    // Retrieve product information from the existing HTML rows
    const productRows = document.querySelectorAll('.content-table tbody tr');
    productRows.forEach(row => {
        const productNameCell = row.querySelector('td:nth-child(2)');
        const quantityCell = row.querySelector('.input-cell.quantity');
        const unitPriceCell = row.querySelector('.input-cell.unit-price');
        const totalCell = row.querySelector('.input-cell.item-total');

        const productName = productNameCell.textContent;
        const quantity = parseInt(quantityCell.textContent, 10);
        const unitPrice = parseFloat(unitPriceCell.textContent);
        const total = parseFloat(totalCell.textContent);

        receiptData.push({
            productName,
            quantity,
            unitPrice,
            total,
        });
    });

    // Prepare the receipt content with header, product list, and footer
    let receiptContent = '';

    // Header
    receiptContent += 'Your Store Name\n';
    receiptContent += '123 Main St, City, Country\n';
    receiptContent += 'Phone: (123) 456-7890\n';
    receiptContent += 'Email: info@yourstore.com\n';

    // Get the current date
    const currentDate = new Date();
    const formattedDate = `${currentDate.toLocaleDateString()} ${currentDate.toLocaleTimeString()}`;
    receiptContent += `Date: ${formattedDate}\n`;

    receiptContent += '--------------------------------\n';

    // Header for product list
    receiptContent += 'Product                | Price   | Total\n'; // Adjusted line width
    receiptContent += '--------------------------------\n';

    receiptData.forEach((item, index) => {
        const productNameLines = wordWrap(item.productName, 16); // Adjusted line width
        const formattedUnitPrice = item.unitPrice.toFixed(2).padStart(6);
        const formattedTotal = item.total.toFixed(2).padStart(7);

        productNameLines.forEach((line, lineIndex) => {
            if (lineIndex === 0) {
                receiptContent += `${line.substring(0, 16)} x${item.quantity}`.padEnd(32); // Include quantity on the first line
            } else {
                receiptContent += `${line}`.padEnd(32); // No quantity on subsequent lines
            }
            
            receiptContent += ` | ${formattedUnitPrice} | ${formattedTotal}\n`;
        });
    });

    // Line between product list and subtotals
    receiptContent += '--------------------------------\n';

    // Calculate the subtotal, discount, tax, and grand total
    const subTotal = receiptData.reduce((total, item) => total + item.total, 0);
    const discountPercentage = parseFloat(document.querySelector('.disc_percnumb').textContent);
    const taxPercentage = parseFloat(document.querySelector('.tax_percnumb').textContent);
    const discount = (discountPercentage / 100) * subTotal;
    const tax = (taxPercentage / 100) * subTotal;
    const grandTotal = subTotal - discount + tax;

    // Subtotals
    receiptContent += `Subtotal: ${subTotal.toFixed(2).padStart(6)}\n`;
    receiptContent += `Discount: ${discount.toFixed(2).padStart(6)}\n`;
    receiptContent += `Tax: ${tax.toFixed(2).padStart(6)}\n`;

    // Line between subtotals and grand total
    receiptContent += '--------------------------------\n';

    receiptContent += `Grand Total: ${grandTotal.toFixed(2).padStart(6)}\n\n`;

    // Footer
    receiptContent += 'Thank you for shopping with us!\n';
    receiptContent += 'Visit us again at www.yourstore.com\n';

    // Create a new window for printing
    const printWindow = window.open('', '', 'width=600,height=600'); // Adjust the width
    printWindow.document.open();
    printWindow.document.write('<pre>' + receiptContent + '</pre>');
    printWindow.document.close();
    printWindow.print();
}

// Function to wrap text to a new line based on a maximum line length
function wordWrap(text, maxLineLength) {
    const words = text.split(' ');
    const lines = [];
    let currentLine = '';

    for (const word of words) {
        if (currentLine.length + word.length <= maxLineLength) {
            currentLine += (currentLine.length > 0 ? ' ' : '') + word;
        } else {
            lines.push(currentLine);
            currentLine = word;
        }
    }

    if (currentLine.length > 0) {
        lines.push(currentLine);
    }

    return lines;
}
            </script>
        </body>
        </html>