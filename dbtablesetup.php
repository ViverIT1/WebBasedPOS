<?php
$conn = new mysqli('localhost', 'root', '', 'webinventorydb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql_itemlist = "CREATE TABLE itemlist (
    pro_ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
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
    user_ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_role VARCHAR(15) NOT NULL,
    user_name VARCHAR(40) NOT NULL,
    user_password VARCHAR(40) NOT NULL,
    user_fullname VARCHAR(50) NOT NULL
)";

if ($conn->query($sql_itemlist) === true && $conn->query($sql_userauth) === true) {
    echo "Tables 'itemlist' and 'userauth' created successfully";

    // Insert data into 'itemlist' table
    $insert_itemlist = "INSERT INTO itemlist (pro_inf, pro_name, pro_cat, pro_price, pro_maxStock, pro_quantity, pro_barcode, pro_exp, pro_reorder, pro_minStock)
    VALUES ('Product Info 1', 'Product Name 1', 'Category 1', 10.99, 100, 50, '123456', '2023-12-31', 30, 10),
           ('Product Info 2', 'Product Name 2', 'Category 2', 20.50, 200, 100, '789012', '2024-06-30', 50, 20)";

    if ($conn->query($insert_itemlist) === true) {
        echo "Data inserted into 'itemlist' table successfully";
    } else {
        echo "Error inserting data into 'itemlist' table: " . $conn->error;
    }

    // Insert data into 'userauth' table
    $insert_userauth = "INSERT INTO userauth (user_role, user_name, user_password, user_fullname)
    VALUES ('admin', 'adminuser', 'admin123', 'Administrator')";

    if ($conn->query($insert_userauth) === true) {
        echo "Data inserted into 'userauth' table successfully";
    } else {
        echo "Error inserting data into 'userauth' table: " . $conn->error;
    }
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
