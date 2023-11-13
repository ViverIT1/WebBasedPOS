<?php
class DbOperation {
    private $conn;

    public function connect() {
        $this->conn = new mysqli('localhost', 'u863194874_3mem', 'PosRoot2023', 'u863194874_webinventorydb');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    public function userLogin($username, $password){
        $this->connect();

        $sql = "SELECT * FROM userauth WHERE user_name = ? AND user_password = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function fetchProductdata($productID) {
        $this->connect();
        $products = array(); // Initialize the array to hold product data

        // Check if the productID starts with "PD"
        if (strpos($productID, 'PD') === 0) {
            $itemdis_IDQR = $productID; // Preserve the "PD" prefix
            $itemlistProductID = substr($productID, 2); // Remove "PD" prefix for searching in itemlist

            // Search in the itemdiscount table for "PD"-preserved product ID
            $sqlDiscount = "SELECT itemdis_IDQR, itemdisper FROM itemdiscount WHERE itemdis_IDQR = ?";
            $stmtDiscount = $this->conn->prepare($sqlDiscount);
            $stmtDiscount->bind_param("s", $itemdis_IDQR);

            if ($stmtDiscount->execute()) {
                $resultDiscount = $stmtDiscount->get_result();

                if ($resultDiscount->num_rows > 0) {
                    while ($rowDiscount = $resultDiscount->fetch_assoc()) {
                        $products[] = $rowDiscount;
                    }
                } else {
                    // Product not found in itemdiscount
                    return array('message' => 'Product not found');
                }
            } else {
                // Debugging: Check for SQL query execution errors
                return array('message' => 'Error executing discount query: ' . $stmtDiscount->error);
            }

            // Search for pro_name and pro_price in itemlist using the modified product ID
            $sqlItemList = "SELECT pro_name, pro_price FROM itemlist WHERE pro_IDQR = ?";
            $stmtItemList = $this->conn->prepare($sqlItemList);
            $stmtItemList->bind_param("s", $itemlistProductID);

            if ($stmtItemList->execute()) {
                $resultItemList = $stmtItemList->get_result();

                if ($resultItemList->num_rows > 0) {
                    while ($rowItemList = $resultItemList->fetch_assoc()) {
                        $products[] = $rowItemList;
                    }
                }
            }
        } else {
            $sql = "SELECT il.pro_IDQR, il.pro_name, il.pro_quantity, il.pro_price, id.itemdisper
                    FROM itemlist AS il
                    LEFT JOIN itemdiscount AS id ON il.pro_IDQR = id.itemdis_IDQR
                    WHERE il.pro_IDQR = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("s", $productID);

            if ($stmt->execute()) {
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $products[] = $row;
                    }
                }
            }
        }
    }

    public function generatereport(){

    }

}
?>

