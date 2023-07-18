<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'webinventorydb');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$stmt = $conn->prepare("SELECT * FROM userauth WHERE user_name = ? AND user_password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();
echo "Number of rows: " . mysqli_num_rows($result);

if (mysqli_num_rows($result) == 1) {
    session_start();
    $_SESSION["username"] = $username;
    header("Location: http://localhost/yourdirectory/Homepage.html");
    echo "<p>Success Login</p>";
} else {
    echo "<p>Incorrect username or password.</p>";
}

mysqli_close($conn);
?>
