<?php
include ("PhpCon.php");

$query = "SELECT DISTINCT supp_name FROM supplierlist";
$result = $conn->query($query);
$values = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $values[] = $row["supp_name"];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supplier Information</title>
    <link rel="stylesheet" type="text/css" href="purchOderAdd.css">
</head>

<body>
    <div class="form-box">
        <form action="" method="post">
            <div class="container1">
                <label for="Supplier">Supplier</label>
                <select name="Supplier" id="Supplier">
                    <option>---</option>
                    <?php foreach ($values as $value): ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                <label for="po">PO #</label>
                <input type="text" name="po" id="po" required>
            </div>
        </form>
    </div>
    <div class="table">
        <table class="content-table">
            <thead>
                <tr>
                    <th></th>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Item</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form>
                    <td></td>
                    <td><input type="text" name="Quantity" id="Quantity" autocomplete="off"></td>
                    <td><input type="text" name="Unit" id="Unit" autocomplete="off"></td>
                    <td><input type="text" name="Item" id="Item" autocomplete="off"></td>
                    <td><input type="text" name="ProductName" id="ProductName" autocomplete="off"></td>
                    <td><input type="text" name="UnitPrice" id="UnitPrice" autocomplete="off"></td>
                    
                    <button type="button" onclick="AddProduct()">Add</button>
                    </form>
                </tr>
            </tbody>
        </table>
        <table class="content-table">
            <thead>
                <tr>
                    <th>Quantity</th>
                    <th>Unit</th>
                    <th>Item</th>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="preview">

            </tbody>
        </table>
        <table class="subt-table">
            <tbody>
                <tr>
                    <td><button type="button">Click Me</button>SubTotal</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="disc-table">
            <tbody>
                <tr>
                    <td>Discount (%)<input type="text" name="" id="DiscountPer"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="tax-table">
            <tbody>
                <tr>
                    <td>Tax Inclusive (%)<input type="text" name="" id="TaxPer"></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="total-table">
            <tbody>
                <tr>
                    <td>Total<input type="text" name="" id="TotalAll" readonly></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="button-container">
        <button type="button" onclick="saveToDb()">Save</button>
        <a href=""><button type="button" class="cancel-button">Cancel</button></a>
    </div>
<script>
var dataArray = [];

function AddProduct() {
  var quantity = parseFloat(document.getElementById('Quantity').value);
  var unit = document.getElementById('Unit').value;
  var item = document.getElementById('Item').value;
  var productName = document.getElementById('ProductName').value;
  var unitPrice = parseFloat(document.getElementById('UnitPrice').value);
  var Total = quantity * unitPrice;
  var total = Total;

  dataArray.push([quantity, unit, item, productName, unitPrice, total]);

  // Add data to the preview table
  var previewTable = document.getElementById('preview');
  var newRow = previewTable.insertRow();
  for (var i = 0; i < 6; i++) {
    var cell = newRow.insertCell(i);
    cell.innerHTML = dataArray[dataArray.length - 1][i];
  }
  // Add a "Delete" button to the new row
  var deleteCell = newRow.insertCell(6);
  var deleteButton = document.createElement("button");
  deleteButton.innerHTML = "Delete";
  deleteButton.onclick = function() {
    deleteRow(newRow);
  };
  deleteCell.appendChild(deleteButton);

  // Clear input fields
  document.getElementById('Quantity').value = '';
  document.getElementById('Unit').value = '';
  document.getElementById('Item').value = '';
  document.getElementById('ProductName').value = '';
  document.getElementById('UnitPrice').value = '';

  // Recalculate discount, tax, and total
  calculateDiscount();
  calculateTax();
  calculateTotal();
}

function calculateDiscount() {
  var discountPercentage = parseFloat(document.getElementById('DiscountPer').value);
  var subTotal = calculateSubTotal();
  var discountAmount = (discountPercentage / 100) * subTotal;
  document.getElementById('DiscountAmount').value = discountAmount;
}

function calculateTax() {
  var taxPercentage = parseFloat(document.getElementById('TaxPer').value);
  var subTotal = calculateSubTotal();
  var discountAmount = parseFloat(document.getElementById('DiscountAmount').value);
  var taxableAmount = subTotal - discountAmount;
  var taxAmount = (taxPercentage / 100) * taxableAmount;
  document.getElementById('TaxAmount').value = taxAmount;
}

function calculateTotal() {
  var subTotal = calculateSubTotal();
  var discountAmount = parseFloat(document.getElementById('DiscountAmount').value);
  var taxAmount = parseFloat(document.getElementById('TaxAmount').value);
  var total = subTotal - discountAmount + taxAmount;
  document.getElementById('TotalAll').value = total;
}

function calculateSubTotal() {
  var subTotal = 0;
  for (var i = 0; i < dataArray.length; i++) {
    subTotal += dataArray[i][5]; // Access the total from the dataArray
  }
  return subTotal;
}

function deleteRow(row) {
  var rowIndex = row.rowIndex;
  
  // Remove the corresponding data from dataArray
  dataArray.splice(rowIndex - 1, 1);
  
  // Delete the row from the HTML table
  row.parentNode.removeChild(row);
  
  // Recalculate discount, tax, and total after deleting a row
  calculateDiscount();
  calculateTax();
  calculateTotal();
}

// Add event listeners to input fields for passive computation
document.getElementById('DiscountPer').addEventListener('input', calculateDiscount);
document.getElementById('TaxPer').addEventListener('input', calculateTax);

// Initial calculations
calculateDiscount();
calculateTax();
calculateTotal();

</script>
</body>
</html>