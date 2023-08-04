<?php
if (isset($_GET['UpID'])) {
    $proID = $_GET['UpID'];
    echo 'Success';
    echo '<a href="itemanage.php"><button>Go back</button></a>';
}
else{
    echo 'Error updating product';
    echo '<a href="itemanage.php"><button>Go back</button></a>';
}
?>
