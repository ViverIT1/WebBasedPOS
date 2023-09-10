<?php
include ("PhpCon.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="supplierAdd.css">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_REQUEST['AddSupplier'])){
        $CustomerName = $_POST['Customer_Name'];
        $CustomerCon = $_POST['Customer_ContactNo'];
        $CustomerMail = $_POST['Customer_mail'];


        $sql = "INSERT INTO customerlist 
        (cust_name, cust_con, cust_mail) 
        VALUES 
        (?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sss", $CustomerName, $CustomerCon, $CustomerMail);

        if (mysqli_stmt_execute($stmt)) {
            header('location: customerAdd.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
            }
    ?>
            <div class="form-box" method="post">
                <form method="post">
                    <label for="Customer_Name">Customer Name</label>
                    <input type="text" name="Customer_Name" id="Customer_Name" required>
                    <br>
                    <label for="Customer_ContactNo">Customer Contact Number</label>
                    <input type="text" name="Customer_ContactNo" id="Customer_ContactNo" required>
                    <br>
                    <label for="Customer_mail">Email</label>
                    <input type="text" name="Customer_mail" id="Customer_mail" required>
                    <br>
                    <button type="submit" name="AddSupplier">Add</button>
                </form>
                <a href="customermanage.php"><button>Exit</button></a>
            </div>
</body>
</html>