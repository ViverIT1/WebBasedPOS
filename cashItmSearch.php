<?php
include("PhpCon.php");

if ($conn) {
    $query = "SELECT pro_IDQR, pro_name FROM itemlist WHERE pro_IDQR LIKE ? OR pro_name LIKE ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        $searchQuery = "%" . $_GET['query'] . "%";
        mysqli_stmt_bind_param($stmt, "ss", $searchQuery, $searchQuery);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $items = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $items[] = $row;
        }

        echo json_encode($items);

        mysqli_stmt_close($stmt);
    } else {
        echo "Prepare statement error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Database connection error: " . mysqli_connect_error();
}
?>
