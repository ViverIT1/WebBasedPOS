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
                <label for="customer">Customer:</label>
                <input type="text" id="cust_name" name="cust_name" placeholder="Name" value="cust" required>
        
                <div class="input-group">
                    <form method="post" action="cashieringRetrieve.php" id="cashierForm" autocomplete="off">
                        <div class="container">
                            <label for="product">Product Code</label>
                            <input type="text" id="productQR" name="productQR" placeholder="Enter your Product">
                            <label for="product">Quantity</label>
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
                        <button type="button" class="commitButton" id="commitButton" onclick="payment()">Commit</button>
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
            console.log(data); // Log the entire data object

            if (data.length > 0) {
                console.log(data[0].pro_IDQR); // Log specific properties
                console.log(data[0].pro_name);

                // Check if the product is already in the cart
                const existingRow = document.querySelector(`.content-table tbody tr[data-product-id="${data[0].pro_IDQR}"]`);

                if (existingRow) {
                    // If it's already in the cart, update the quantity and item total
                    const existingQuantityCell = existingRow.querySelector('.input-cell.quantity');
                    const existingQuantity = parseInt(existingQuantityCell.textContent, 10);
                    const newQuantity = existingQuantity + parseInt(quantity, 10);
                    existingQuantityCell.textContent = newQuantity;

                    // Get the discount information for the product from itemdiscount
                    const discountPercentageCell = existingRow.querySelector('.input-cell.discount-percentage');
                    const itemPriceCell = existingRow.querySelector('.input-cell.unit-price');
                    const itemTotalCell = existingRow.querySelector('.input-cell.item-total');

                    // Extract and convert the discount percentage to a number
                    const discountPercentageText = discountPercentageCell.textContent;
                    const discountPercentage = parseFloat(discountPercentageText.replace('%', ''));

                    const itemPrice = parseFloat(itemPriceCell.textContent);

                    // Calculate the discounted total
                    const discountTotal = (discountPercentage / 100) * (itemPrice * newQuantity);
                    itemTotalCell.textContent = ((itemPrice * newQuantity) - discountTotal).toFixed(2);

                    // Update the discount percentage in the table
                    discountPercentageCell.textContent = discountPercentage.toFixed(2); // Update the discount percentage
                } else {
                    // If it's not in the cart, add a new row
                    const tableBody = document.querySelector('.content-table tbody');
                    const row = document.createElement('tr');
                    row.dataset.productId = data[0].pro_IDQR;

                    if ("itemdis_IDQR" in data[0]) {
                        // If the product ID starts with "PD," handle it differently
                        row.innerHTML = `
                            <td>${data[0].itemdis_IDQR}</td>
                            <td>${data[1].pro_name}</td>
                            <td class="input-cell quantity">${quantity}</td>
                            <td class="input-cell unit-price">${data[1].pro_price}</td>
                            <td class="input-cell discount-percentage">${data[0].itemdisper || '0.00'}</td>
                            <td class="input-cell item-total">${((data[1].pro_price * quantity) - (data[1].pro_price * quantity * data[0].itemdisper / 100)).toFixed(2)}</td>
                            <td class="input-cell">
                                <button type="button" onclick="removeProduct(this)">Remove</button>
                            </td>
                        `;
                    } else {
                        // If the product ID does not start with "PD"
                        row.innerHTML = `
                            <td>${data[0].pro_IDQR}</td>
                            <td>${data[0].pro_name}</td>
                            <td class="input-cell quantity">${quantity}</td>
                            <td class="input-cell unit-price">${data[0].pro_price}</td>
                            <td class="input-cell discount-percentage">${data[0].itemdisper || '0.00'}</td>
                            <td class="input-cell item-total">${((data[0].pro_price * quantity) - (data[0].pro_price * quantity * data[0].itemdisper / 100)).toFixed(2)}</td>
                            <td class="input-cell">
                                <button type="button" onclick="removeProduct(this)">Remove</button>
                            </td>
                        `;
                    }
                    
                        tableBody.appendChild(row);
                                }

                                // Update the subtotal and grand total
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
                // Fetch or calculate the subtotal and taxPercentage
                const subtotal = parseFloat(document.getElementById('sub_total').textContent);
                const taxPercentage = parseFloat(document.querySelector('.tax_percnumb').textContent); // Select the element containing tax percentage

                // Fetch the discount information based on the highest gendisqual less than or equal to subtotal
                fetchDiscountForSubtotal(subtotal)
                    .then(data => {
                        // Extract the discount percentage and log it
                        const discountPercentage = parseFloat(data);

                        if (!isNaN(discountPercentage)) {
                            console.log('Parsed Discount Percentage:', discountPercentage);

                            // Update the discount percentage in your HTML
                            document.querySelector('.disc_percnumb').textContent = discountPercentage.toFixed(2);

                            // Calculate the grand total
                            const grandTotal = calculateGrandTotal(subtotal, discountPercentage, taxPercentage);

                            // Update the grand total in your HTML
                            document.getElementById('grand-total').textContent = grandTotal.toFixed(2);
                        } else {
                            console.error('Invalid Discount Percentage:', discountPercentage);
                        }
                    })
                    .catch(error => console.error(error));
                }

                function calculateGrandTotal(subtotal, discountPercentage, taxPercentage) {
                    // Calculate the grand total based on the given values
                    const discount = (discountPercentage / 100) * subtotal;
                    const tax = (taxPercentage / 100) * subtotal;
                    const grandTotal = subtotal - discount + tax;
                    return grandTotal;
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
                            if (typeof data === 'number' || !isNaN(data)) {
                                return data; // Return the discount percentage if it's a valid number
                            } else {
                                // If the response is empty or not a valid number, return a default value (0)
                                return 0;
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            return 0; // Handle any error by returning a default value (0)
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

                function genInv() {
                    let sharedInvoiceNumber; // Variable retained inside the closure

                    if (!sharedInvoiceNumber) {
                        let xhr = new XMLHttpRequest();

                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                if (xhr.status === 200) {
                                    const latestInvoice = parseInt(xhr.responseText, 10);
                                    sharedInvoiceNumber = isNaN(latestInvoice) ? 0 : latestInvoice + 1;
                                } else {
                                    console.error("Error: " + xhr.status);
                                }
                            }
                        };

                        xhr.open("GET", "cashieringInv.php", false); // Synchronous request
                        xhr.send();
                    } else {
                        sharedInvoiceNumber += 1;
                    }

                    return sharedInvoiceNumber;
                }
                // Define the generateReceiptData function
                function printReceipt() {
                    const invoiceNumber = genInv();
                    // Generate a random invoice number (you can replace this with your own logic)

                    // Create an empty array to store receipt data
                    const receiptData = [];

                    // Prepare the receipt content with header, product list, and footer
                    let receiptContent = '';

                    // AJAX request to retrieve header and footer data from the server
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', 'cashieringRetrieveRec.php', true);

                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const data = JSON.parse(xhr.responseText);

                            // Check if header and footer data are available
                            const header = data.header || {};
                            const footer = data.footer || {};

                            // Header for invoice number at the top
                            receiptContent += `Invoice: ${invoiceNumber}\n`; // Include invoice number at the top

                            // Add header lines
                            receiptContent += `${header.storeName}\n`;
                            receiptContent += `${header.storeAddress}\n`;
                            receiptContent += `${header.storePhone}\n`;
                            receiptContent += `${header.storeEmail}\n`;
                            receiptContent += '--------------------------------\n';

                            // Retrieve product information from the existing HTML rows
                            const productRows = document.querySelectorAll('.content-table tbody tr');
                            productRows.forEach(row => {
                                const productNameCell = row.querySelector('td:nth-child(2)');
                                const quantityCell = row.querySelector('.input-cell.quantity');
                                const totalCell = row.querySelector('.input-cell.item-total');
                                const discountPercentageCell = row.querySelector('.input-cell.discount-percentage');

                                const productName = productNameCell.textContent;
                                const quantity = parseInt(quantityCell.textContent, 10);
                                const total = parseFloat(totalCell.textContent);
                                const discountPercentage = parseFloat(discountPercentageCell.textContent);

                                receiptData.push({
                                    productName,
                                    quantity,
                                    total,
                                    discountPercentage,
                                });
                            });

                            // Add a line separator after product list
                            receiptContent += '--------------------------------\n';

                            // Display product list
                            receiptData.forEach((item, index) => {
                                const productName = `${item.productName} x${item.quantity}`;
                                const formattedTotal = item.total.toFixed(2).padStart(6);
                                const discountedPrice = -((item.discountPercentage / 100) * item.total).toFixed(2);

                                receiptContent += `${productName} | ${formattedTotal}\n`;
                                if (item.discountPercentage > 0) {
                                    receiptContent += `Discounted Price: ${discountedPrice}\n`;
                                }
                            });

                            // Add a line separator before subtotals
                            receiptContent += '--------------------------------\n';

                            // Calculate subtotals, discount, tax, and grand total
                            const subTotal = receiptData.reduce((total, item) => total + item.total, 0);
                            const discountPercentage = data.discountPercentage || 0; // Default to 0 if not provided
                            const taxPercentage = data.taxPercentage || 0; // Default to 0 if not provided
                            const discount = (discountPercentage / 100) * subTotal;
                            const tax = (taxPercentage / 100) * subTotal;
                            const grandTotal = subTotal - discount + tax;

                            // Display subtotals, discount, and tax
                            receiptContent += `Subtotal: ${subTotal.toFixed(2).padStart(6)}\n`;

                            // Get the discount percentage value from the document
                            const discountPercentageValue = document.querySelector('.disc_percnumb').textContent;
                            receiptContent += `Discount: ${discountPercentageValue}%\n`;

                            // Include the tax percentage in the receipt content
                            const taxPercentageValue = document.querySelector('.tax_percnumb').textContent;
                            receiptContent += `Tax: ${taxPercentageValue}%\n`;

                            receiptContent += `Grand Total: ${grandTotal.toFixed(2).padStart(6)}\n`;


                            // Include random space below the footer for proper printing
                            const randomSpace = '\n\n\n\n\n';

                            // Get cash received and change values
                            const cashReceived = parseFloat(document.getElementById('cash-received').value);
                            const change = parseFloat(document.querySelector('input[name="amount_change"]').value);

                            // Display cash received and change
                            receiptContent += `Cash Received: ${cashReceived.toFixed(2).padStart(6)}\n`;
                            receiptContent += `Change: ${change.toFixed(2).padStart(6)}\n`;

                            // Add a line separator before footer
                            receiptContent += '--------------------------------\n';

                            // Display footer lines
                            receiptContent += `${footer.textbox1}\n`;
                            receiptContent += `${footer.textbox2}\n`;
                            receiptContent += `${footer.textbox3}\n`;
                            receiptContent += `${footer.textbox4}\n`;

                            // Add extra space with plus signs as separators
                            const extraSpaces = '\n\n\n\n\n\n\n\n\n\n' + '++++++++\n\n\n\n\n\n\n\n\n\n';

                            receiptContent += extraSpaces;

                            // Create a new window for printing
                            const printWindow = window.open('', '', 'width=600,height=600');
                            printWindow.document.open();
                            printWindow.document.write('<pre>' + receiptContent + '</pre>');
                            printWindow.document.close();
                            printWindow.print();
                        } else {
                            console.log('Error fetching header and footer data from the server.');
                        }
                    };

                    xhr.send();
                }
                function payment() {
                    const paymentMethod = document.getElementById("payment-method").value;
                    
                    if (paymentMethod === "cash") {
                        validatecashpay();
                    } else if (paymentMethod === "gcash") {
                        noncashpay();
                    } else {
                        alert("Please select a payment method!");
                    }
                }

                function validatecashpay(){
                    const cashReceived = parseFloat(document.getElementById('cash-received').value);
                    const change = parseFloat(document.getElementById('change-amount').textContent);

                    if (cashReceived < change) {
                        alert('Cash received is less than the change. Amount is not enough!');
                    } else{
                        cashpay();
                    }
                }

                // Function to handle the commit button click
                function cashpay() {

                    // Extract overall Discount, Tax, and Grand Total values
                    const discount = document.getElementById("disc_perc").textContent;
                    const tax = document.getElementById("tax_perc").textContent;
                    const grandTotal = document.getElementById("grand-total").textContent;
                    const invoiceNo = genInv();
                    const customerName = document.getElementById("cust_name").value;

                    // Get the selected payment method
                    const paymentMethod = document.getElementById("payment-method").value;

                    // Array to store extracted data from each row
                    const rowData = [];

                    // Get all rows in the table body
                    const allRows = document.querySelectorAll('.content-table tbody tr');

                    // Iterate through each row
                    allRows.forEach(row => {
                        // Get the cells in the row
                        const cells = Array.from(row.cells);

                        // Check if the row structure matches the one with "itemdis_IDQR"
                        if (cells.length === 7) {
                            // Extract data from specific columns
                            const productId = cells[0].textContent; // Product ID
                            const productName = cells[1].textContent; // Product Name
                            const productQuantity = cells[2].textContent; // Product Quantity
                            const productDiscount = cells[4].textContent; // Product Discount
                            const productTotal = cells[5].textContent; // Product Total

                            // Create an object with the extracted data
                            const rowDataForRow = {
                                productId,
                                productName,
                                productQuantity,
                                productDiscount,
                                productTotal
                            };

                            // Add the object to the rowData array
                            rowData.push(rowDataForRow);
                        }
                    });

                    // Sample data to send to the server along with the extracted row data
                    const dataToSend = {
                        customer_name: customerName, // Update the key to 'customer_name'
                        discount,
                        tax,
                        grandTotal,
                        paymentMethod,
                        products: rowData,
                        invoiceNo
                    };

                        // Display an alert before sending and saving the data
                        const confirmResult = confirm("Are you sure you want to commit?");
                        if (!confirmResult) {
                            return;
                        }

                        // Create a new XMLHttpRequest object
                        var xhr = new XMLHttpRequest();

                        // Configure it: specify the type of request (POST), the URL, and set it to be asynchronous
                        xhr.open("POST", "cashieringProdRepWar.php", true);

                        // Set the request header to indicate that we are sending JSON data
                        xhr.setRequestHeader("Content-Type", "application/json");

                        // Define the callback function to handle the response from the server
                        xhr.onreadystatechange = function () {
                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                // Check if the request was successful (status code 200)
                                if (xhr.status === 200) {
                                    // Handle the response from the server
                                    console.log(xhr.responseText);
                                    alert("Data sent and saved successfully");
                                    sharedInvoiceNumber = null;
                                    // Reload the current page without using the cache
                                    location.reload();

                                    // Force a reload from the server by passing true
                                    location.reload(true);
                                } else {
                                    // Handle errors
                                    console.error("Error: " + xhr.status);
                                    alert("Error sending data to server");
                                }
                            }
                        };

                        // Convert the data object to a JSON string
                        var jsonData = JSON.stringify(dataToSend);

                        // Send the data to the server
                        xhr.send(jsonData);
                    }
                    function noncashpay(){

                    }
            </script>
        </body>
        </html>