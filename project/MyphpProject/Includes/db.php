<?php


class SeggieDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    //db connection config vars for x10hosting.com to connect to deployed database.
    // private $user = "campsegg_phpuser";
    // private $pass = "phpuserpw";
     // private $dbName = "campsegg_seggiecampers";
     // private $dbHost = "198.91.81.2";

    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "seggiecampers";
    private $dbHost = "localhost:3308";

    //This method must be static, and must return an instance of the object if the object
    //does not already exist.
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    // private constructor
    private function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }

// CAMPER & STAFF CRUD FUNCTIONS    

    public function create_new_camper($name, $cabin, $initial) {
        $name = $this->real_escape_string($name);
        $cabin = $this->real_escape_string($cabin);
        $initial = $this->real_escape_string($initial);
        $this->query("INSERT INTO campers (name, type, cabin, initialBalance, storeDeposit ) VALUES ('" . $name . "', 'Camper', '" . $cabin . "', '" . $initial . "', '" . $initial . "')");
    }

    public function create_new_staff($name) {
        $name = $this->real_escape_string($name);
        $this->query("INSERT INTO campers (name, type, cabin, initialBalance, storeDeposit) VALUES ('" . $name . "', 'Staff', '-', '0.0', '0.0')");
    }

    public function get_allCamperInfo() {
        return $this->query("SELECT * FROM campers WHERE type='Camper'");
    }

    public function get_allStaffInfo() {
        return $this->query("SELECT * FROM campers WHERE type='Staff'");
    }

    public function get_camper_id_by_name($name) {

        $name = $this->real_escape_string($name);

        $camperID = $this->query("SELECT id FROM campers WHERE name = " . $name);
        if ($camperID->num_rows > 0) {
            $row = $camper->fetch_row();
            return $row[0];
        } else
            return null;
    }

    public function get_allSimilarCamper_id_by_name($name) {

        $name = $this->real_escape_string($name);

        $camperID = $this->query("SELECT id FROM campers WHERE name LIKE '%$name%'");
        if (mysqli_num_rows($camperID) < 1) {
            return null;
        } else
            return true;
    }

    public function get_all_of_type($type) {
        $type = $this->real_escape_string($type);

        return $this->query("SELECT id FROM campers WHERE type = '" . $type . "'");
    }

    public function get_camperInformation_by_camper_id($camperID) {
        return $this->query("SELECT id,type,name,cabin,initialBalance,storeDeposit FROM campers WHERE id=" . $camperID);
    }

    public function get_camperName_by_id($camperID) {
        return $this->query("SELECT name FROM campers WHERE id= " . $camperID);
    }

    public function get_allSimilarCamperInformation_by_camper_id($name) {
        return $this->query("SELECT id,type,name,cabin,storeDeposit FROM campers WHERE name LIKE '%$name%'");
    }

    public function update_camper($camperID, $type, $cabin, $initialBalance, $storeDeposit) {
        $type = $this->real_escape_string($type);
        $cabin = $this->real_escape_string($cabin);
        $initialBalance = $this->real_escape_string($initialBalance);
        $storeDeposit = $this->real_escape_string($storeDeposit);
        if ($type != "" && $cabin != "" && $initialBalance != "" && $storeDeposit != "") {
            $this->query("UPDATE campers SET type = '" . $type . "', cabin = '" . $cabin . "', initialBalance = '" . $initialBalance . "', storeDeposit = '" . $storeDeposit . "' WHERE id =" . $camperID);
        }
    }

    public function update_staff($staffID, $type, $storeDeposit) {
        $type = $this->real_escape_string($type);
        $storeDeposit = $this->real_escape_string($storeDeposit);
        if ($type != "" && $storeDeposit != "") {
            $this->query("UPDATE campers SET type = '" . $type . "', storeDeposit = '" . $storeDeposit . "' WHERE id = " . $staffID);
        }
    }

    public function delete_camper($camperID) {
        $this->query("DELETE FROM campers WHERE id = '" . $camperID . "'");
    }

    public function delete_staff($staffID) {
        $this->query("DELETE FROM campers WHERE id='" . $staffID . "'");
    }

    public function select_campers() {
        return $this->query("SELECT id FROM campers WHERE type = 'Camper'");
    }

    public function select_staff() {
        return $this->query("SELECT id FROM campers WHERE type = 'Staff'");
    }

//Inventory CRUD functions

    public function create_new_item($name, $itemPrice, $consumerPrice, $quantity) {
        $name = $this->real_escape_string($name);
        $itemPrice = $this->real_escape_string($itemPrice);
        $consumerPrice = $this->real_escape_string($consumerPrice);
        $quantity = $this->real_escape_string($quantity);
        $this->query("INSERT INTO inventory (itemName, itemPrice, consumerPrice, quantity ) VALUES ('" . $name . "', '" . $itemPrice . "', '" . $consumerPrice . "', '" . $quantity . "')");
    }

    public function get_product_name($pid) {
        $result = $this->query("SELECT itemName FROM inventory WHERE id='" . $pid . "'");
        $row = mysqli_fetch_array($result);
        return $row['itemName'];
    }

    public function get_CamperPrice($pid) {
        $result = $this->query("SELECT consumerPrice FROM inventory WHERE id='" . $pid . "'");
        $row = mysqli_fetch_array($result);
        return $row['consumerPrice'];
    }

    public function get_StaffPrice($pid) {
        $result = $this->query("SELECT itemPrice FROM inventory WHERE id='" . $pid . "'");
        $row = mysqli_fetch_array($result);
        return $row['itemPrice'];
    }

    public function get_itemInfo_by_item_id($itemID) {
        return $this->query("SELECT id,itemName,itemPrice, consumerPrice,quantity FROM inventory WHERE id=" . $itemID);
    }

    public function get_allInventoryInfo() {
        return $this->query("SELECT * FROM inventory");
    }

    public function update_item($itemID, $itemName, $itemPrice, $consumerPrice, $quantity) {
        $itemName = $this->real_escape_string($itemName);
        $itemPrice = $this->real_escape_string($itemPrice);
        $consumerPrice = $this->real_escape_string($consumerPrice);
        $quantity = $this->real_escape_string($quantity);
        if ($itemName != "" && $itemPrice != "" && $consumerPrice != "" && $quantity != "")
            $this->query("UPDATE inventory SET itemName = '" . $itemName . "', itemPrice = '" . $itemPrice . "', consumerPrice = '" . $consumerPrice . "', quantity = '" . $quantity . "' WHERE id =" . $itemID);
    }

    public function remove_product($pid) {
        $pid = intval($pid);
        $max = count($_SESSION['cart']);
        for ($i = 0; $i < $max; $i++) {
            if ($pid == $_SESSION['cart'][$i]['id']) {
                unset($_SESSION['cart'][$i]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    public function get_order_total() {
        $max = count($_SESSION['cart']);
        $sum = 0;
        for ($i = 0; $i < $max; $i++) {
            $pid = $_SESSION['cart'][$i]['id'];
            $q = $_SESSION['cart'][$i]['quantity'];
            $price = get_CamperPrice($pid);
            $sum += $price * $q;
        }
        return $sum;
    }

    public function addtocart($pid, $q) { //-$q
        if (is_array($_SESSION['cart'])) {
            if (product_exists($pid))
                return;
            $max = count($_SESSION['cart']);
            echo "MAX db.php:" . $max;
            $_SESSION['cart'][$max]['id'] = $pid;
            $_SESSION['cart'][$max]['quantity'] = $q;
        } else {
            $_SESSION['cart'] = array();
            $_SESSION['cart'][0]['id'] = $pid;
            $_SESSION['cart'][0]['quantity'] = $q;
        }
    }

    public function delete_item($itemID) {
        $this->query("DELETE FROM inventory WHERE id = " . $itemID . "");
    }

    public function getUserInfo($userName, $passWord) {
        return $this->query("SELECT * FROM users WHERE Username='" . $userName . "' AND Password='" . $passWord . "'");
    }

}

function get_CamperPrice($pid) {
    // $user = "campsegg_phpuser";
    // $pass = "phpuserpw";
    // $dbName = "campsegg_seggiecampers";
     //$dbHost = "198.91.81.2";

     $user = "phpuser";
     $pass = "phpuserpw";
     $dbName = "seggiecampers";
     $dbHost = "localhost:3308";
// Create connection
    $con = mysqli_connect($dbHost, $user, $pass, $dbName);
    $result = mysqli_query($con, "SELECT consumerPrice FROM inventory WHERE id='" . $pid . "'");
    $row = mysqli_fetch_array($result);
    return $row['consumerPrice'];
}

function get_StaffPrice($pid) {
    // $user = "campsegg_phpuser";
    // $pass = "phpuserpw";
    // $dbName = "campsegg_seggiecampers";
     //$dbHost = "198.91.81.2";

     $user = "phpuser";
     $pass = "phpuserpw";
     $dbName = "seggiecampers";
     $dbHost = "localhost";
// Create connection
    $con = mysqli_connect($dbHost, $user, $pass, $dbName);
    $result = mysqli_query($con, "SELECT itemPrice FROM inventory WHERE id='" . $pid . "'");
    $row = mysqli_fetch_array($result);
    return $row['itemPrice'];
}

function product_exists($pid) {
    $pid = intval($pid);
    $max = count($_SESSION['cart']);
    $flag = 0;
    for ($i = 0; $i < $max; $i++) {
        if ($pid == $_SESSION['cart'][$i]['id']) {
            $flag = 1;
            break;
        }
    }
    return $flag;
}

?>
