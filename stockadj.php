<?php
require_once('PhpCon.php');
$query = "SELECT * FROM itemlist";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
if (isset($_REQUEST['change_quantity'])){
  $adjID = $_POST['adjid'];
  $Quantity = $_POST['quantity'];
   $query = "UPDATE itemlist SET pro_quantity = ? WHERE pro_ID = ?";

$stmt = mysqli_prepare($conn, $query);

if ($stmt) {
mysqli_stmt_bind_param($stmt, "ii", $Quantity, $adjID);

if (mysqli_stmt_execute($stmt)) {
    header('location:stockadj.php');
}
else{
  header('location:debugError.php');
}

mysqli_stmt_close($stmt);
}}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Stock Adjusment</title>
    <link rel="stylesheet" type="text/css" href="stockadj.css">
</head>
<body>
  <h1 class="header">Stock Adjusment</h1>
  <table class="content-table">

    <tr>
      <th>Product Name/Id</th>
      <th>Quantity</th>
    </tr>

<form method="post">
    <tr>
      <td><input type="number" name="adjid" value="<?php 
      if (isset($_GET['AdjID'])) {
          $AdjID1 = $_GET['AdjID'];
          require ('PhpCon.php');
          $itemAdjID = mysqli_real_escape_string($conn, $AdjID1);
          echo $itemAdjID;
        }
          // Close the database connection
          $conn->close();
      ?>"></td>
      <td><input type="number" name="quantity" required></td>
      
    </tr>
  </table>

  <button class="confirm-button" name="change_quantity" >Confirm</button>
      </form>

  <table class="content-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['pro_ID']; ?></td>
                    <td><?php echo $row['pro_name']; ?></td>
                    <td><?php echo $row['pro_cat']; ?></td>
                    <td><?php echo $row['pro_quantity']; ?></td>
                    <td>
                        <button><a href="stockadj.php?AdjID=<?php echo $row['pro_ID']; ?>">Update</button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>


</body>
</html>