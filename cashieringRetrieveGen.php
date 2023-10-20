<?php
include("PhpCon.php"); // Include your database connection script

$subTotal = $_GET['subtotal'];

// Query to get the discount based on the highest gendisqual less than or equal to the subtotal
$sql = "SELECT gendisper FROM gendiscount WHERE gendisqual <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $subTotal); // Assuming gendisqual is a decimal value

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the highest gendisper that meets the criteria
        $discountPercentage = 0.0;
        while ($row = $result->fetch_assoc()) {
            $discountPercentage = max($discountPercentage, $row['gendisper']);
        }

        // Return the discount percentage as JSON
        echo json_encode(array('discountPercentage' => $discountPercentage));
    } else {
        // No matching discount found
        echo json_encode(array('discountPercentage' => 0.0));
    }
} else {
    // Error executing the query
    echo json_encode(array('error' => 'Error executing discount query'));
}
?>
