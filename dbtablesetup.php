<?php
include ("PhpCon.php");

$sql_itemlist = "CREATE TABLE itemlist (
    pro_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_IDQR VARCHAR(20),
    pro_inf VARCHAR(255) NOT NULL,
    pro_name VARCHAR(40) NOT NULL,
    pro_cat VARCHAR(30) NOT NULL,
    pro_price decimal(11,2) NOT NULL,
    pro_maxStock INT(11) NOT NULL,
    pro_quantity INT(11) NOT NULL,
    pro_exp DATE,
    pro_reorder INT(11) NOT NULL,
    pro_minStock INT(11) NOT NULL
)";//Item Database 
//add batch ID for expiration identification

$sql_cashier_temp = "CREATE TABLE cashier_temp (
    pro_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_IDQR VARCHAR(20),
    pro_name VARCHAR(40) NOT NULL,
    pro_price decimal(11,2) NOT NULL,
    pro_quantity INT(11) NOT NULL,
    pro_total decimal(11,2) NOT NULL
)"; //Cashier Cart

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
)"; //General Discount

$sql_itemdis = "CREATE TABLE itemdiscount (
    itemdis_IDQR varchar(12),
    pro_ID VARCHAR(15) NOT NULL,
    pro_name VARCHAR(40) NOT NULL,
    itemdis DECIMAL(11,2),
    itemdisper DECIMAL(11,2),
    itemdistart date NOT NULL,
    itemdisend date NOT NULL
)"; //Discount by item

$sql_catdis = "CREATE TABLE catdiscount (
    catdis_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cat VARCHAR(15) NOT NULL,
    catdis DECIMAL(11,2),
    catdisper DECIMAL(11,2),
    catdistart date NOT NULL,
    catdisend date NOT NULL
)"; //Discount by Category

$sql_supplierlist = "CREATE TABLE supplierlist (
    supp_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    supp_name VARCHAR(50) NOT NULL,
    supp_add VARCHAR(50),
    supp_conper VARCHAR(50),
    supp_mail VARCHAR(50),
    supp_con VARCHAR(50)
)"; //Supplier list

$sql_customerlist = "CREATE TABLE customerlist (
    cust_ID BIGINT(8) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cust_name VARCHAR(50) NOT NULL,
    cust_con VARCHAR(50),
    cust_mail VARCHAR(50)
)"; //Customer list

$sql_polist = "CREATE TABLE polist (
    po_PONO BIGINT(8),
    po_unit VARCHAR(50),
    po_item VARCHAR(50),
    pro_IDQR VARCHAR(50),
    pro_name VARCHAR(50),
    po_supp VARCHAR(50),
    po_quantity BIGINT(9),
    po_unitPrice DECIMAL(11,2),
    po_total DECIMAL(11,2)
)"; //Purchase Order list

$sql_supdelivery = "CREATE TABLE supdelivery (
    supdel_PONO BIGINT(8),
    supdel_unit VARCHAR(50),
    supdel_item VARCHAR(50),
    pro_IDQR VARCHAR(50),
    pro_name VARCHAR(50),
    supdel_supp VARCHAR(50),
    supdel_quantity BIGINT(9),
    supdel_unitPrice DECIMAL(11,2),
    supdel_total DECIMAL(11,2)
)"; //Supplier Delivery

if (
    $conn->query($sql_itemlist) === true &&
    $conn->query($sql_cashier_temp) === true &&
    $conn->query($sql_userauth) === true &&
    $conn->query($sql_gendis) === true &&
    $conn->query($sql_itemdis) === true &&
    $conn->query($sql_catdis) === true &&
    $conn->query($sql_supplierlist) === true &&
    $conn->query($sql_customerlist) === true &&
    $conn->query($sql_polist) === true &&
    $conn->query($sql_supdelivery)
) {
    echo "Tables 'itemlist', 'cashier_temp', 'userauth', 'gendiscount', 'itemdis', 'catdiscount',
    'supplierlist' and 'customerlist' created successfully";

    // Insert data into 'userauth' table
    $insert_userauth = "INSERT INTO userauth (user_role, user_name, user_password, user_fullname)
    VALUES ('Administrator', 'admin', 'admin123', 'Admin-kun')";

    if ($conn->query($insert_userauth) === true) {
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
