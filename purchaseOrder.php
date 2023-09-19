<?php

include ("PhpCon.php");

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purchased Order to Supplier</title>
    <link rel="stylesheet" type="text/css" href=".css">
    <script src=".js"></script>
</head>

<body>
        <div class="header">
            <h1>Purchased Order to Supplier</h1>
            <a href="purchOrderAdd.php"><button class="add-button" type="button">+</button></a>
        </div>
        <?php {?>
        <table>
    <thead>
        <tr>
            <th>Details</th>
            <th colspan="3">Action</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Supplier Name:</td>
            <td><a><button>Approve</button></a></td>
            <td><a><button>Details</button></a></td>
            <td><a><button>Delete</button></a></td>
        </tr>
        <tr>
            <td>PO#:</td>
            <td colspan="3">Status:</td>
        </tr>
    </tbody>
</table>
        <?php }?>

</body>