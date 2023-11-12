<?php
ob_start();
$username = $_POST['username'];
$password = $_POST['password'];

include("PhpCon.php");

$stmt = $conn->prepare("SELECT * FROM userauth WHERE user_name = ? AND user_password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) == 1) {
    session_start();
    $_SESSION["username"] = $username;
    header("Location:next.php");
} else {
    echo "<p>Incorrect username or password.</p>";
}

mysqli_close($conn);
?>
