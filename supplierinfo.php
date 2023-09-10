<?php
include ('PhpCon.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Supplier Information</title>
    <link rel="stylesheet" type="text/css" href="supplierinfo.css">
</head>

<body>
    <div class="header">
        <h1>Supplier Information</h1>
        <a href="supplierAdd.php"><button class="add-button" type="button">+</button></a>
    </div>

    <form>
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <table class="content-table">
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Address</th>
                <th>Contact Person</th>
		        <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $query = "SELECT * FROM supplierlist";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }
            else if($result){
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['supp_name']; ?></td>
                <td><?php echo $row['supp_add']; ?></td>
                <td><?php echo $row['supp_conper']; ?></td>
                <td><button>Details</button></td>
                <td><a href="supplierinfoRe.php?ReID=<?php echo $row['supp_ID']; ?>"><button>Remove</button></a></td>
            </tr>
            <?php
                }
            }
            else{
                echo "Sorry cannot fetch Supplier's data";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <button class="prev-btn">Previous</button>
        <span class="page-num">1</span>
        <button class="next-btn">Next</button>
      </div>

</body>
</html>