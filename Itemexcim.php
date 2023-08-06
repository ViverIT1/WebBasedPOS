<?php
require_once ('PhpCon.php');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel Importer</title>
</head>
<body>
    <form class="" action="" enctype="multipart/form-data" method="post">
        <input type="file" name="ex" required value="">
        <button type="submit" name="im">Import</button>
    </form> 
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST["im"])){
    $fileName = $_FILES["ex"]["name"];
    $fileExtention = explode('.', $fileName);
    $fileExtention = strtolower(end($fileExtention));

    $newFileName = date("Y.m.d") . "-" . date("h.i.sa") . "-" .$fileExtention;

    $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $newFileName; // Change "uploads/" to your desired directory.
    move_uploaded_file($_FILES["ex"]["tmp_name"], $targetDirectory);

    error_reporting(0);
    ini_set('display_errors', 0);

    require "excrd/excel_reader2.php";
    require "excrd/SpreadsheetReader.php";

    $reader = new SpreadsheetReader($targetDirectory);
    foreach($reader as $key => $row){
        $Product_ID = $row[0];
        $Product_Description = $row[1];
        $Product_Name = $row[2];
        $Product_Category = $row[3];
        $Product_Price = $row[4];
        $Product_Quantity = $row[5];
        $Product_Barcode = $row[6];
        $Product_Expiry = $row[7];
        $Product_Reorder = $row[8];
        $Product_Minimum = $row[9];
        $Product_Maximum = $row[10];

        mysqli_query($conn, "INSERT INTO itemlist VALUES('$Product_ID','$Product_Description',
        '$Product_Name','$Product_Category','$Product_Price','$Product_Quantity','$Product_Barcode',
        '$Product_Expiry','$Product_Reorder','$Product_Minimum','$Product_Maximum')");
    }
}

?>
</body>
</html>
