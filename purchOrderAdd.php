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
                <select name="Supplier">
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
                    <td></td>
                    <td><input type="text" name="Quantity" autocomplete="off"></td>
                    <td><input type="text" name="Unit" autocomplete="off"></td>
                    <td><input type="text" name="Item" autocomplete="off"></td>
                    <td><input type="text" name="ProductName" autocomplete="off"></td>
                    <td><input type="text" name="UnitPrice" autocomplete="off"></td>
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
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
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
                    <td>Discount (%)<input type="text" name=""></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="tax-table">
            <tbody>
                <tr>
                    <td>Tax Inclusive (%)<input type="text" name=""></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <table class="total-table">
            <tbody>
                <tr>
                    <td>Total</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="button-container">
        <button type="submit" class="save-button">Save</button>
        <button type="button" class="cancel-button">Cancel</button>
    </div>

</body>
</html>