<?php

include ('PhpCon.php');

$query = "SELECT DISTINCT pro_cat FROM itemlist";
$result = $conn->query($query);

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
    <form method="post">
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    
      <form method="post">
      <div class="table-container">
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
            <td><input type="text" name="genDis" autocomplete="off"> </td>
            <td><input type="text" name="genDisPer" autocomplete="off"> </td>
            <td><input type="text" name="genDisQual" autocomplete="off"> </td>
        </tr>
    </tbody>  
    </table>
      </div>

      <div class="table-container">
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
            <td><input type="text" name="genDisStart" autocomplete="off" required></td>
            <td><input type="text" name="genDisEnd" autocomplete="off" required></td>
        </tr>
    </tbody>  
    </table>
      </div>

    <input type="submit" name="setGenDis" value="Set Total-Based Discount" class="custom-button1">
    </form>
    <?php   
        if (isset($_POST['setGenDis'])){
            $GeneralDiscount=$_POST['genDis'];
            $GeneralDiscountPercentage=$_POST['genDisPer'];
            $genDisQual=$_POST['genDisQual'];
            $GeneralDiscountStart=$_POST['genDisStart'];
            $GeneralDiscountEnd=$_POST['genDisEnd'];

            $sql_insert_gen_dis = "INSERT INTO gendiscount (gendis, gendisper, gendisqual, gendistart, gendisend)
                           VALUES (?, ?, ?, ?, ?)";       

            $stmt = $conn->prepare($sql_insert_gen_dis);
            $stmt->bind_param("sdsss", $GeneralDiscount, $GeneralDiscountPercentage, $genDisQual, $GeneralDiscountStart, $GeneralDiscountEnd);
            if ($stmt->execute()) {
                echo "General discount inserted successfully.";
            } else {
                echo "Error inserting general discount: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
        }

    ?>
        <form method="post">
        <div class="table-container">
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
                <td><input type="text" name="itemDisProID" autocomplete="off"> </td>
                <td><input type="text" name="itemDisProName" autocomplete="off"> </td>
                <td><select name="ItemCat_Picker">
                    <option>---</option>
                    <?php foreach ($values as $value): ?>
                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                    <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="text" name="catoritemDis" autocomplete="off"> </td>
                <td><input type="text" name="catoritemDisPer" autocomplete="off"> </td>
            </tr>
        </tbody>  
        </table>
        </div>

        <div class="table-container">
        <table class="content-table">
        <thead>
            <th>Discount Starts(YYYY-MM-DD)</th>
            <th>Discount Ends(YYYY-MM-DD)</th>
        </thead>
        <tbody>
            <td><input type="text" name=catoritemStart autocomplete="off" required> </td>
            <td><input type="text" name=catoritemEnd  autocomplete="off" required> </td>
        </tbody>
    </table>
        </div>

    <input type="submit" value="Set Item-Based Discount" name="SetItemDiscount" class="custom-button2">
    </form>
    <?php
    if (isset($_REQUEST['SetItemDiscount'])){
        if (!empty($_POST['itemDisProID']) || !empty($_POST['itemDisProName'])) {
            $ItemDiscount_ID = $_POST['itemDisProID'];
            $ItemDiscount_Name = $_POST['itemDisProName'];
            $ItemDiscount_Amount = $_POST['catoritemDis'];
            $ItemDiscount_Percent = $_POST['catoritemDisPer'];
            $ItemDiscountStart = $_POST['catoritemStart'];
            $ItemDiscountEnd = $_POST['catoritemEnd'];
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql_insert = "INSERT INTO itemdiscount (itemdis_IDQR, pro_name, itemdis, itemdisper, itemdistart, itemdisend)
                          VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql_insert);
            
            if ($stmt) {
                $stmt->bind_param("ssddss", $ItemDiscount_ID, $ItemDiscount_Name, $ItemDiscount_Amount, $ItemDiscount_Percent, $ItemDiscountStart, $ItemDiscountEnd);
            
                if ($stmt->execute()) {
                    $stmt->close();
                    echo "Item discount were set successful!";
                } else {
                    echo "Item discount were set failed: " . $stmt->error;
                }
            }  else {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
            
            $conn->close();

        } elseif(!empty($_POST['ItemCat_Picker'])){
            $Category = $_POST['ItemCat_Picker'];
            $ItemDiscount_Amount = $_POST['catoritemDis'];
            $ItemDiscount_Percent = $_POST['catoritemDisPer'];
            $ItemDiscountStart = $_POST['catoritemStart'];
            $ItemDiscountEnd = $_POST['catoritemEnd'];
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $sql_insert_cat = "INSERT INTO catdiscount (cat, catdis, catdisper, catdistart, catdisend)
                              VALUES (?, ?, ?, ?, ?)";
            
            $stmt_cat = $conn->prepare($sql_insert_cat);
            
            if ($stmt_cat) {
                $stmt_cat->bind_param("sidds", $Category, $ItemDiscount_Amount, $ItemDiscount_Percent, $ItemDiscountStart, $ItemDiscountEnd);
                $stmt_cat->execute();
                echo "Discount on Category were set successfully";
                $stmt_cat->close();
            } else {
                echo "Error: " . $sql_insert_cat . "<br>" . $conn->error;
            }
            
            $conn->close();
            
        } else{
            echo "Invalid Input";
        }
    }?>
</body>

</html>