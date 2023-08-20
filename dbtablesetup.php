<?php
$conn = new mysqli('localhost', 'root', '', 'webinventorydb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_itemlist = "CREATE TABLE itemlist (
    pro_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_inf VARCHAR(255) NOT NULL,
    pro_name VARCHAR(40) NOT NULL,
    pro_cat VARCHAR(30) NOT NULL,
    pro_price decimal(11,2) NOT NULL,
    pro_maxStock INT(11) NOT NULL,
    pro_quantity INT(11) NOT NULL,
    pro_barcode VARCHAR(10) NOT NULL,
    pro_exp DATE,
    pro_reorder INT(11) NOT NULL,
    pro_minStock INT(11) NOT NULL
)";

$sql_cashier_temp = "CREATE TABLE cashier_temp (
    pro_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_name VARCHAR(40) NOT NULL,
    pro_price decimal(11,2) NOT NULL,
    pro_quantity INT(11) NOT NULL,
    pro_total decimal(11,2) NOT NULL
)";

$sql_userauth = "CREATE TABLE userauth (
    user_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_role VARCHAR(15) NOT NULL,
    user_name VARCHAR(40) NOT NULL,
    user_password VARCHAR(40) NOT NULL,
    user_fullname VARCHAR(50) NOT NULL
)";

$sql_gendis = "CREATE TABLE gendiscount (
    gendis_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gendis DECIMAL(11,2),
    gendisper DECIMAL(11,2),
    gendisqual int(8),
    gendistart date NOT NULL,
    gendisend date NOT NULL
)";

$sql_itemdis = "CREATE TABLE itemdiscount (
    itemdis_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_ID VARCHAR(15) NOT NULL,
    pro_name VARCHAR(40) NOT NULL,
    itemdis DECIMAL(11,2),
    itemdisper DECIMAL(11,2),
    itemdistart date NOT NULL,
    itemdisend date NOT NULL
)";

$sql_catdis = "CREATE TABLE catdiscount (
    catdis_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cat VARCHAR(15) NOT NULL,
    catdis DECIMAL(11,2),
    catdisper DECIMAL(11,2),
    catdistart date NOT NULL,
    catdisend date NOT NULL
)";

if (
    $conn->query($sql_itemlist) === true &&
    $conn->query($sql_cashier_temp) === true &&
    $conn->query($sql_userauth) === true &&
    $conn->query($sql_gendis) === true &&
    $conn->query($sql_itemdis) === true &&
    $conn->query($sql_catdis) === true
) {
    echo "Tables 'itemlist', 'cashier_temp', 'userauth', 'gendiscount', 'itemdis' and 'catdiscount' created successfully";

    // Insert data into 'itemlist' table
    $insert_itemlist = "INSERT INTO itemlist (pro_inf, pro_name, pro_cat, pro_price, pro_maxStock, pro_quantity, pro_barcode, pro_exp, pro_reorder, pro_minStock)
    VALUES ('Product info 1', 'Product Name 1', 'Category 1', 10.00, 100, 50, '123456', '2023-12-31', 30, 10),
           ('Product Info 2', 'Product Name 2', 'Category 2', 20.00, 200, 100, '789012', '2024-06-30', 50, 20)";

    // Insert data into 'userauth' table
    $insert_userauth = "INSERT INTO userauth (user_role, user_name, user_password, user_fullname)
    VALUES ('Administrator', 'admin', 'admin123', 'Admin-kun')";

    if ($conn->query($insert_itemlist) === true && $conn->query($insert_userauth) === true) {
        echo "Data inserted into 'itemlist' and 'userauth' tables successfully";
        echo '<a href="Homepage.html"><button>Go Back</button></a>';
    } else {
        echo "Error inserting data: " . $conn->error;
    }
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
