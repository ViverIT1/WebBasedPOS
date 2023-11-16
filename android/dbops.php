<?php

class DbOperation {
    private $conn;

    public function connect() {
        $this->conn = new mysqli('localhost', 'u863194874_3mem', 'PosRoot2023', 'u863194874_webinventorydb');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function userLogin($username, $password) {
        $this->connect();

        $sql = "SELECT * FROM userauth WHERE user_name = ? AND user_password = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        $this->closeConnection();

        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function fetchProductdata($productID) {
        $this->connect();

        if (strpos($productID, "PD") === 0) {
            // Product ID starts with "PD"
            $itemdis = $this->getItemDiscount($productID);

            // Remove "PD" from the ID to retrieve the product name and price
            $newProductID = substr($productID, 2);
            $productData = $this->getItemDetails($newProductID);

            $this->closeConnection();

            if ($itemdis && $productData) {
                $price = $productData['pro_price'] - ($productData['pro_price'] * ($itemdis['itemdisper'] / 100));
                return array(
                    'pro_name' => $productData['pro_name'],
                    'pro_price' => $price,
                    'pro_quantity' => $productData['pro_quantity']
                );
            }
        } else {
            // Product ID doesn't start with "PD", search directly in the itemlist
            
            $productDisData = $this->getItemDiscount($productID);
            $productData = $this->getItemDetails($productID);
            if(!$productDisData){
            if ($productData) {
                return array(
                    'pro_name' => $productData['pro_name'],
                    'pro_price' => $productData['pro_price'],
                    'pro_quantity' => $productData['pro_quantity']
                );
            }
            }
            else{
            $disprice = $productData['pro_price'] - ($productData['pro_price'] * ($productDisData['itemdisper'] / 100));
                return array(
                    'pro_name' => $productData['pro_name'],
                    'pro_price' => $disprice,
                    'pro_quantity' => $productData['pro_quantity']
                );
            }
        }

        return null;
    }

    private function getItemDetails($productID) {
        $query = "SELECT pro_name, pro_price, pro_quantity FROM itemlist WHERE pro_IDQR = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    private function getItemDiscount($productID) {
        $query = "SELECT itemdisper FROM itemdiscount WHERE itemdis_IDQR = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $productID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function generatereport() {
    }
    public function retrieveDis($productprice){
        
    }
    public function retrievetax() {
        $this->connect();

        $query = "SELECT taxPer FROM taxmnt LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $taxData = $result->fetch_assoc();

        $this->closeConnection();

        if ($taxData) {
            return $taxData['taxPer'];
        } else {
            return null;
        }
    }
}

?>
