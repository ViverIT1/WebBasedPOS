<?php
include("dbops.php");

$response = array();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) and isset($_POST['password'])) {
        $db = new DbOperation();
        $loggedIn = $db->userLogin(
            $_POST['username'],
            $_POST['password']
        );

        if ($loggedIn) {
            $response['error'] = false;
            $response['message'] = 'Login successful';
        } else {
            $response['error'] = true;
            $response['message'] = 'Invalid username or password';
        }
        echo json_encode($response);
    }
}
?>
