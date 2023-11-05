<?php
include("PhpCon.php");

if (isset($_POST["submit"])) {
    // Retrieve data from the form
    $occasion = $_POST["occasion"];
    $discount = $_POST["discount"];
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];

    // Prepare and execute the SQL query to insert data into the database
    $query = "INSERT INTO occdiscounts (mnt_occasion, mnt_discount, mnt_start, mnt_end) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("siss", $occasion, $discount, $start_date, $end_date);

    if ($stmt->execute()) {
        // Data inserted successfully
        echo "Discount data inserted successfully.";
    } else {
        // Error occurred while inserting data
        echo "Error: " . $stmt->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Occasion Discount</title>
    <link rel="stylesheet" type="text/css" href="discountmaintenance.css">
</head>
<body>
    <div class="header">
        <h1>Insert Discount</h1>
    </div>

    <form class="insert-form" method="post" onsubmit="return validateForm()">
        <label for="occasion">Occasion:</label>
        <input type="text" name="occasion" id="occasion" required><br><br>

        <label for="discount">Discount %:</label>
        <input type="number" name="discount" id="discount" step="0.01" required><br><br>

        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required><br><br>

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required><br><br>

        <button type="submit" name="submit">Insert Discount</button>
    </form>

    <script>
    function validateForm() {
        // Get input values
        const occasion = document.getElementById('occasion').value;
        const discount = parseFloat(document.getElementById('discount').value);
        const start_date = document.getElementById('start_date').value;
        const end_date = document.getElementById('end_date').value;

        // Input validation
        if (occasion === "" || isNaN(discount) || discount < 0 || discount > 100 || 
            !validateDate(start_date) || !validateDate(end_date) ||
            start_date === '0000-00-00' || end_date === '0000-00-00') {
            alert("Invalid input. Please check your input values.");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

        function validateDate(date) {
            const regex = /^\d{4}-\d{2}-\d{2}$/;
            return regex.test(date);
        }
    </script>
</body>
</html>

