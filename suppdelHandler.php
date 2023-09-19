<?php
include("PhpCon.php"); // Include your database connection file

if (isset($_POST['SuppPo'])) {
    // SQL query to create the supdelivery table based on the structure of polist
    $sql_polist_structure = "SHOW COLUMNS FROM polist";
    $result = $conn->query($sql_polist_structure);

    if ($result->num_rows > 0) {
        $supdelivery_columns = array();

        while ($row = $result->fetch_assoc()) {
            $column_name = $row["Field"];
            $column_type = $row["Type"];

            // Adjust the column name to use "supdel_" prefix
            $supdel_column_name = "supdel_" . $column_name;

            // Add the column and type to the array
            $supdelivery_columns[] = "$supdel_column_name $column_type";
        }

        // Create the SQL query for creating the supdelivery table
        $sql_supdelivery = "CREATE TABLE supdelivery (
            " . implode(",\n        ", $supdelivery_columns) . "
        )";

        // Execute the SQL query to create the supdelivery table
        if ($conn->query($sql_supdelivery) === TRUE) {
            echo "supdelivery table created successfully.";
        } else {
            echo "Error creating supdelivery table: " . $conn->error;
        }
    } else {
        echo "No columns found in the polist table.";
    }

    // Close the database connection
    $conn->close();
}
?>
