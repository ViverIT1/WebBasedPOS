<?php
include("PhpCon.php");

$mnt_occasion = $mnt_discount = $mnt_start = $mnt_end = "";
$updateSuccess = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $mnt_occasion = $_POST["mnt_occasion"];
    $mnt_discount = $_POST["mnt_discount"];
    $mnt_start = $_POST["mnt_start"];
    $mnt_end = $_POST["mnt_end"];

    // Add database update logic here
    $query = "UPDATE occdiscounts SET mnt_occasion = ?, mnt_discount = ?, mnt_start = ?, mnt_end = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $mnt_occasion, $mnt_discount, $mnt_start, $mnt_end, $_GET['id']);

    if ($stmt->execute()) {
        $updateSuccess = true;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

if (isset($_GET['id'])) {
    $ocid = $_GET['id'];
    $disID = mysqli_real_escape_string($conn, $ocid);

    $query = "SELECT * FROM occdiscounts WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $disID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $mnt_occasion = $row['mnt_occasion'];
        $mnt_discount = $row['mnt_discount'];
        $mnt_start = $row['mnt_start'];
        $mnt_end = $row['mnt_end'];
    } else {
        echo "Record not found for id: " . $disID;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Discount</title>
    <link rel="stylesheet" type="text/css" href="discountmaintenance.css">
</head>
<body>
    <div class="header">
        <h1>Update Discount</h1>
    </div>

    <?php if ($updateSuccess) : ?>
    <div class="success-message">Record updated successfully.</div>
    <?php endif; ?>

    <form class="update-form" method="post">
    <input type="hidden" name="action" value="update">
    <label for="mnt_occasion">Occasion:</label>
    <input type="text" name="mnt_occasion" required pattern="[A-Za-z\s]+" value="<?php echo htmlspecialchars($mnt_occasion, ENT_QUOTES); ?>"><br><br>

    <label for="mnt_discount">Discount %:</label>
    <input type="number" name="mnt_discount" step="0.01" required min="0" max="100" value="<?php echo htmlspecialchars($mnt_discount, ENT_QUOTES); ?>"><br><br>

    <label for="mnt_start">Start Date:</label>
    <input type="date" name="mnt_start" required value="<?php echo htmlspecialchars($mnt_start, ENT_QUOTES); ?>"><br><br>

    <label for="mnt_end">End Date:</label>
    <input type="date" name="mnt_end" required value="<?php echo htmlspecialchars($mnt_end, ENT_QUOTES); ?>"><br><br>

    <button type="submit" id="update" name="update">Update Discount</button>
    </form>
</body>
</html>
