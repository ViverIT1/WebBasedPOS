<?php
include ("PhpCon.php");

$response=array();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['pro_id'])){
        $db = new DbOperation();
        $getProducts = $db->fetchProductdata(
            $_POST["pro_id"]
        );
    }
}

?>