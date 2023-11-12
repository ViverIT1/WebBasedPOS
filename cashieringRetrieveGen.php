<?php
include("PhpCon.php"); // Include your database connection script

$subTotal = $_GET['subtotal'];

// Query to get the discount based on the highest gendisqual less than or equal to the subtotal
$sql = "SELECT gendisper FROM gendiscount WHERE gendisqual <= ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("d", $subTotal); // Assuming gendisqual is a decimal value

if ($stmt->execute()) {

    $combinedDiscount = 0.00;   
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the highest gendisper that meets the criteria
        $discountPercentage = 0.0;
        while ($row = $result->fetch_assoc()) {
            $discountPercentage = max($discountPercentage, $row['gendisper']);
        }

        // Now, let's retrieve the mnt_discount based on the date range
        $currentDate = date('Y-m-d'); // Get the current date

        // Query to get mnt_discount if the current date falls within the range
        $sql = "SELECT mnt_discount FROM occdiscounts WHERE mnt_start <= ? AND mnt_end >= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $currentDate, $currentDate);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $mnt_discount = 0.0;
                while ($row = $result->fetch_assoc()) {
                    $mnt_discount = max($mnt_discount, $row['mnt_discount']);
                }

                // Combine the discounts
                $combinedDiscount = $discountPercentage + $mnt_discount;

                error_log('Received Data: combinedDiscountPercentage=' . $combinedDiscount);

                echo $combinedDiscount;
            } else {
                // No matching mnt_discount found
                echo $discountPercentage;
            }
        } else {
            // Error executing the mnt_discount query
            echo json_encode(array('error' => 'Error executing mnt_discount query'));
        }
    } else {
        // No matching discount found
        echo $combinedDiscount;
    }
} else {
    // Error executing the gendiscount query
    echo json_encode(array('error' => 'Error executing discount query'));
}
?>
