<?php
include ("PhpCon.php");

$getsupplierquery = "SELECT DISTINCT supp_name FROM supplierlist";
$getsupplierresult = $conn->query($getsupplierquery);
$suppliervalues = array();
if ($getsupplierresult->num_rows > 0) {
    while ($suprow = $getsupplierresult->fetch_assoc()) {
        $suppliervalues[] = $suprow["supp_name"];
    }
}
$getitemsql = "SELECT pro_IDQR FROM itemlist WHERE pro_quantity <= pro_reorder";
$getitemresult = $conn->query($getitemsql);
$itemvaluesID = array();
if($getitemresult->num_rows > 0){
    while($itmrow = $getitemresult->fetch_assoc()){
        $itemvaluesID[] = $itmrow["pro_IDQR"];
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
                    <?php foreach ($suppliervalues as $suppliervalue): ?>
                    <option value="<?php echo $suppliervalue; ?>"><?php echo $suppliervalue; ?></option>
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
                    <th>Product ID</th>
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
                    <td><input type="text" name="ProductID" id="ProductID" list="ProductIDList" autocomplete="off"></td>
                    <datalist id="ProductIDList">
                    <option>---</option>
                        <?php foreach($itemvaluesID as $itemvaluesID): ?>
                            <?php if(isset($itemvaluesID)): ?>
                            <option value="<?php echo $itemvaluesID; ?>"><?php echo $itemvaluesID; ?></option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            </datalist> 
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
                    <th>Product ID</th>
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
                    <td><button type="button">Sub-Total</button></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="disc-table">
            <tbody>
                <tr>
                    <td>Discount (%)<input type="text" name="" id="DiscountPer" value=""></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="tax-table">
            <tbody>
                <tr>
                    <td>Tax Inclusive (%)<input type="text" name="" id="TaxPer" value=""></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="total-table">
            <tbody>
                <tr>
                    <td>Total<input type="text" name="" id="TotalAll" value="" readonly></td>
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
  var ProductID = document.getElementById('ProductID').value;
  var productName = document.getElementById('ProductName').value;
  var unitPrice = parseFloat(document.getElementById('UnitPrice').value);
  var Total = quantity * unitPrice;
  var total = Total;
  var supplier = document.getElementById('Supplier').value;
  var PurchOrd = document.getElementById('po').value;

  dataArray.push([quantity, unit, item, ProductID, productName, unitPrice, total,
  supplier, PurchOrd]);

  // Add data to the preview table
  var previewTable = document.getElementById('preview');
  var newRow = previewTable.insertRow();
  for (var i = 0; i < 7; i++) {
    var cell = newRow.insertCell(i);
    cell.innerHTML = dataArray[dataArray.length - 1][i];
  }
  // Add a "Delete" button to the new row
  var deleteCell = newRow.insertCell(7);
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
  document.getElementById('ProductID').value = '';
  document.getElementById('ProductName').value = '';
  document.getElementById('UnitPrice').value = '';
  updateTotal();
}

function deleteRow(row) {
  var rowIndex = row.rowIndex;
  
  // Remove the corresponding data from dataArray
  dataArray.splice(rowIndex - 1, 1);
  
  // Delete the row from the HTML table
  row.parentNode.removeChild(row);
  updateTotal();
}
function updateTotal() {
  var totalAll = 0;
  var taxPercentage = parseFloat(document.getElementById('TaxPer').value) || 0;
  var discountPercentage = parseFloat(document.getElementById('DiscountPer').value) || 0;

  for (var i = 0; i < dataArray.length; i++) {
    totalAll += dataArray[i][6]; // Assuming the total is stored at index 5 in the dataArray
  }

  // Calculate tax and discount
  var taxAmount = (totalAll * taxPercentage) / 100;
  var discountAmount = (totalAll * discountPercentage) / 100;

  // Apply tax and discount
  totalAll = totalAll + taxAmount - discountAmount;

  // Update the TotalAll input field
  document.getElementById('TotalAll').value = totalAll.toFixed(2); // You can format the total as needed
}

// Add event listeners to the TaxPer and DiscountPer fields
var taxPerField = document.getElementById('TaxPer');
var discountPerField = document.getElementById('DiscountPer');

taxPerField.addEventListener('input', updateTotal);
discountPerField.addEventListener('input', updateTotal);

document.getElementById('ProductID').addEventListener('input', function() {
    var productId = this.value;
    
    if (productId.trim() !== '') {
        // Make an AJAX request to your server to fetch the product name
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'purchOrderAddProNameGet.php?productId=' + productId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = xhr.responseText;
                var productNameInput = document.getElementById('ProductName');
                productNameInput.value = response.trim() !== '' ? response : 'Product not found';
            }
        };
        xhr.send();
    } else {
        // Clear the product name input if the product ID is empty
        document.getElementById('ProductName').value = '';
    }
});

function saveToDb() {
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'purchaseOrderAddHandler.php', true);
  xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
  xhr.send(JSON.stringify(dataArray));

  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Request was successful, handle the response here if needed
        alert('Save successful!'); // Display an alert
      } else {
        // Request failed, handle the error here if needed
        alert('Save failed. Please try again.');
      }
    }
  };
}


</script>
</body>
</html>