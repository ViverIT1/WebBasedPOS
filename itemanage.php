<?php
include ('PhpCon.php');
$query = "SELECT * FROM itemlist";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Product Management</title>
    <link rel="stylesheet" type="text/css" href="itemanage.css">
    <script src="itemanage.js"></script>
</head>

<body>
        <div class="header">
            <h1>Product Management</h1>
            <a href="ItemAdd.php"><button class="add-button" type="button">+</button></a>
        </div>

    <form>
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <table class="content-table">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Reorder Point</th>
                <th colspan="2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <tr>
                    <td><?php echo $row['pro_IDQR']; ?></td>
                    <td><?php echo $row['pro_name']; ?></td>
                    <td><?php echo $row['pro_inf']; ?></td>
                    <td><?php echo $row['pro_cat']; ?></td>
                    <td><?php echo $row['pro_price']; ?></td>
                    <td><?php echo $row['pro_quantity']; ?></td>
                    <td><?php echo $row['pro_reorder']; ?></td>
                    <td>
                        <button><a href="itemUpSet.php?UpSetID=<?php echo $row['pro_IDQR']; ?>">Update</button>
                    </td>
                    <td>
                        <button><a href="itemRe.php?ReID=<?php echo $row['pro_IDQR']; ?>">Remove</a></button>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

</body>

</html>
