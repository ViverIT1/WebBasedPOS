<?php
// Add this section to your discountmaintenance.php to handle the delete action
if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["id"])) {
    // Connect to your database
    include("PhpCon.php");

    $id = $_GET["id"];
    // Add any necessary validation here to ensure the ID is valid

    $query = "DELETE FROM occdiscounts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Record deleted successfully
        header("Location: discountmaintenance.php"); // Redirect back to the main page
        exit();
    } else {
        // Error occurred while deleting
        echo "Error: " . $stmt->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discount Maintenance</title>
    <link rel="stylesheet" type="text/css" href="discountmaintenance.css">
</head>
<body>
    <div class="header">
        <h1>Discount Maintenance</h1>
        <a href="discountmaintenanceAdd.php"><button class="add-button" type="button">+</button></a>
    </div>

    <form class="search-form">
        <input type="search" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <table class="content-table">
        <thead>
            <tr>
                <th>Occasion</th>
                <th>Discount %</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th colspan="2" class="action-header">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Connect to your database and retrieve data here
                include("PhpCon.php");

                $query = "SELECT id, mnt_occasion, mnt_discount, mnt_start, mnt_end FROM occdiscounts";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo '<td contenteditable="true" class="editable" data-id="' . $row["id"] . '">' . $row["mnt_occasion"] . '</td>';
                        echo '<td contenteditable="true" class="editable" data-id="' . $row["id"] . '">' . $row["mnt_discount"] . '</td>';
                        echo '<td contenteditable="true" class="editable" data-id="' . $row["id"] . '">' . $row["mnt_start"] . '</td>';
                        echo '<td contenteditable="true" class="editable" data-id="' . $row["id"] . '">' . $row["mnt_end"] . '</td>';
                        echo '<td><a href="discountmaintenanceUp.php?id=' . $row["id"] . '"><button class="action-button update-button">Update</button></a></td>';
                        echo '<td><button class="action-button remove-button" onclick="deleteRow(' . $row["id"] . ')">Remove</button></td>';
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No data available</td></tr>";
                }

                $conn->close();
            ?>
        </tbody>
    </table>

    <script>
        function deleteRow(id) {    
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = "discountmaintenance.php?action=delete&id=" + id;
            }
        }
    </script>
</body>
</html>
