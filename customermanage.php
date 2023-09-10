<?php
include ('PhpCon.php');
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Customer Information Management</title>
        <link rel="stylesheet" type="text/css" href="customermanage.css">
    </head>

<body>
    <div class="header">
        <h1>Customer Information</h1>
        <a href="customeradd.php"><button class="add-button" type="button">+</button></a>
    </div>

    <form>
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <table class="content-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $query = "SELECT * FROM customerlist";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }
            else if($result){
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?php echo $row['cust_name']; ?></td>
                <td><?php echo $row['cust_con']; ?></td>
                <td><?php echo $row['cust_mail']; ?></td>
                <td><a href="customerRe.php?ReID=<?php echo $row['cust_ID']; ?>"><button>remove</button></a></td>
            </tr>
            <?php
            }}else{
                echo "Unable to fetch customer data";
            }
            ?>
        </tbody>
    </table>
</body>
</html>