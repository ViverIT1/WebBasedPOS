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
        $SupplierName = $_POST['Supplier_Name'];
        $SupplierAddress = $_POST['Address'];
        $SupplierConPer = $_POST['Contact_Person'];
        $SupplierMail = $_POST['Email'];
        $SupplierCon = $_POST['Contact'];

        $sql = "INSERT INTO supplierlist 
        (supp_name, supp_add, supp_conper, supp_mail, supp_con) 
        VALUES 
        (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, "sssss", $SupplierName, $SupplierAddress, $SupplierConPer, $SupplierMail, $SupplierCon);

        if (mysqli_stmt_execute($stmt)) {
            header('location: supplierAdd.php');
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
            }
    ?>
            <div class="form-box" method="post">
                <form method="post">
                    <label for="Supplier_Name">Company Name</label>
                    <input type="text" name="Supplier_Name" id="Supplier_Name" required>
                    <br>
                    <label for="Address">Address</label>
                    <input type="text" name="Address" id="Address" required>
                    <br>
                    <label for="Contact_Person">Contact Person</label>
                    <input type="text" name="Contact_Person" id="Contact_Person" required>
                    <br>
                    <label for="Email">Email</label>
                    <input type="text" name="Email" id="Email" required>
                    <br>
                    <label for="Contact">Contact</label>
                    <input type="text" name="Contact" id="Contact" required>
                    <br>
                    <button type="submit" name="AddSupplier">Add</button>
                </form>
                <a href="supplierinfo.php"><button>Exit</button></a>
            </div>
</body>
</html>