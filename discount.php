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
        <form method="post">
            <td><input type="text" name="genDis"> </td>
            <td><input type="text" name="genDisPer"> </td>
            <td><input type="text" name="genDisQual"> </td>
        </tr>
    </tbody>  
    </table>

    <table class="content-table">
        <thead>
            <tr>
                <th>Discount Starts(YYYY-MM-DD)</th>
                <th>Discount Ends(YYYY-MM-DD)</th>
            </tr>
        </thead>
        <tbody>
        <tr>
        <form>
            <td><input type="text" name="genDisStart"></td>
            <td><input type="text" name="genDisEnd"></td>
        </tr>
    </tbody>  
    </table>

    <input type="submit" name="setGenDis" value="Set Total-Based Discount" class="custom-button1">
    </form>
    <?php   
        if (isset($_REQUEST['setGenDis'])){
            $GeneralDiscount=$_POST['genDis'];
            $GeneralDiscountPercentage=$_POST['genDisPer'];
            $genDisQual=$_POST['genDisQual'];
            $GeneralDiscountStart=$_POST['genDisStart'];
            $GeneralDiscountEnd=$_POST['genDisEnd'];

            $sql_insert_gen_dis = "INSERT INTO gendiscount (gendis, gendisper, gendisqual, gendistart, gendisend)
                           VALUES (?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql_insert_gen_dis);
            $stmt->bind_param("sdsdd", $GeneralDiscount, $GeneralDiscountPercentage, $genDisQual, $GeneralDiscountStart, $GeneralDiscountEnd);
            if ($stmt->execute()) {
                echo "General discount inserted successfully.";
            } else {
                echo "Error inserting general discount: " . $stmt->error;
            }

    $stmt->close();
    $conn->close();
}

    ?>
    
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
            <form method="post">
            <tr>
                <td><input type="text" name="itemDisProID"> </td>
                <td><input type="text" name="itemDisProName"> </td>
                <td><select name="ItemCat_Picker">
                    <option>---</option>
                    <?php foreach ($values as $value): ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="itemDis"> </td>
                <td><input type="text" name="itemDisPer"> </td>
            </tr>
        </tbody>  
        </table>
        <table class="content-table">
        <thead>
            <th>Discount Starts(YYYY-MM-DD)</th>
            <th>Discount Ends(YYYY-MM-DD)</th>
        </thead>
        <tbody>
            <td><input type="text"> </td>
            <td><input type="text"> </td>
        </tbody>
    </table>
    <input type="submit" value="Set Item-Based Discount" class="custom-button2">
    </form>
      </table>
</body>

</html>