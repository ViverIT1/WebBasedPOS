<?php

include ('PhpCon.php');

// Step 2: Retrieve data from the database
$query = "SELECT DISTINCT pro_cat FROM itemlist";
$result = $conn->query($query);

// Initialize an array to hold the fetched values
$values = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $values[] = $row["pro_cat"];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Discount</title>
    <link rel="stylesheet" type="text/css" href="discount.css">
</head>
<body>
    <h1 class="header">Discount</h1>
    <form>
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
      </form>
      
      <table class="content-table">
    <thead>
        <tr>
            <th>Discount</th>
            <th>Discount%</th>
            <th>Total amount qualified for Discount</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="text"> </td>
            <td><input type="text"> </td>
            <td><input type="text"> </td>
        </tr>
    </tbody>  
    </table>
    <a href="#"><button>Set Total-Based Discount</button></a>
    <table class="content-table">
        <thead>
            <tr>
                <th>Product ID<h6>Leave empty if has category</h6></th>
                <th>Product Name<h6>Leave empty if has category</h6></th>
                <th>Category<h6>Leave as is if has Product</h6></th>
                <th>Discount</th>
                <th>Discount%</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text"> </td>
                <td><input type="text"> </td>
                <td><select name="selected_value">
                    <option>---</option>
                    <?php foreach ($values as $value): ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text"> </td>
                <td><input type="text"> </td>
            </tr>
        </tbody>  
        </table>
        <a href="#"><button>Set Item-Based Discount</button></a>
      </table>
</body>
</html>