<?php
$conn = new mysqli('localhost', 'root', '','webinventorydb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_itemlist = "CREATE TABLE itemlist (
    pro_ID VARCHAR(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pro_inf VARCHAR(255) NOT NULL,
    pro_name VARCHAR(40) NOT NULL,
    pro_cat VARCHAR(30) NOT NULL,
    pro_price INT(11) NOT NULL,
    pro_maxStock INT(11) NOT NULL,
    pro_quantity INT(11) NOT NULL,
    pro_barcode VARCHAR(10) NOT NULL,
    pro_exp DATE,
    pro_reorder INT(11) NOT NULL,
    pro_minStock INT(11) NOT NULL
)";

$sql_userauth = "CREATE TABLE userauth (
    user_ID INT(30) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_role VARCHAR(15) NOT NULL,
    user_name VARCHAR(40) NOT NULL,
    user_password VARCHAR(40) NOT NULL,
    user_fullname VARCHAR(50) NOT NULL
)";

if ($conn->query($sql_itemlist) === true && $conn->query($sql_userauth) === true) {
    echo "Tables 'itemlist' and 'userauth' created successfully";
    echo '<a href="Homapage.html>Go Back</a>"';
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>


