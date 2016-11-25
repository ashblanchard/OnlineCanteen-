<?php

class SeggieDB extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "phpuser";
    private $pass = "phpuserpw";
    private $dbName = "seggiecampers";
    private $dbHost = "localhost:3308";

//     192.168.2.78 - Ashley's PC
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
        $this->query("INSERT INTO campers (name, cabin, initialBalance, storeDeposit) VALUES ('" . $name . "', '" . $cabin . "', '" . $initial . "', '" . $initial . "')");
    }

    public function create_new_staff($name) {
        $name = $this->real_escape_string($name);
        $this->query("INSERT INTO campers (name, cabin, initialBalance, storeDeposit) VALUES ('" . $name . "', 'STAFF', '0', '0')");
    }

    public function get_camper_id_by_name($name) {

        $name = $this->real_escape_string($name);

        $camperID = $this->query("SELECT id FROM campers WHERE name = " . $name);
        if ($camperID->num_rows > 0) {
            $row = $camper->fetch_row();
            return $row[0];
        } else {
            return null;
        }
    }

    public function get_allSimilarCamper_id_by_name($name) {

        $name = $this->real_escape_string($name);

        $camperID = $this->query("SELECT id FROM campers WHERE name LIKE '%$name%'");
        if (mysqli_num_rows($camperID) < 1) {
            return null;
        } else {
            return true;
        }
    }

    public function get_camperInformation_by_camper_id($camperID) {
        return $this->query("SELECT id,name,cabin,initialBalance,storeDeposit FROM campers WHERE id=" . $camperID);
    }

    public function get_allSimilarCamperInformation_by_camper_id($name) {
        return $this->query("SELECT id,name,cabin,storeDeposit FROM campers WHERE name LIKE '%$name%'");
    }

    public function update_camper($camperID, $name, $cabin, $initialBalance, $storeDeposit) {
        $name = $this->real_escape_string($name);
        $cabin = $this->real_escape_string($cabin);
        $initialBalance = $this->real_escape_string($initialBalance);
        $storeDeposit = $this->real_escape_string($storeDeposit);
        $this->query("UPDATE campers SET name = '" . $name .
                "', cabin = " . $cabin
                . "', initialBalance = " . $initialBalance
                . "', storeDeposit = " . $storeDeposit
                . " WHERE id =" . $camperID);
    }

    public function delete_camper($camperID) {
        $this->query("DELETE FROM campers WHERE id = '" . $camperID . "'");
    }

//Inventory CRUD functions

    public function create_new_item($name, $itemPrice, $consumerPrice, $quantity) {
        $name = $this->real_escape_string($name);
        $itemPrice = $this->real_escape_string($itemPrice);
        $consumerPrice = $this->real_escape_string($consumerPrice);
        $quantity = $this->real_escape_string($quantity);
        $this->query("INSERT INTO inventory (itemName, itemPrice, consumerPrice, quantity ) VALUES ('" . $name . "', '" . $itemPrice . "', '" . $consumerPrice . "', '" . $quantity . "')");
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
        $this->query("UPDATE inventory SET itemName = '" . $itemName .
                "',itemPrice = '" . $itemPrice .
                "', consumerPrice = " . $consumerPrice
                . "', quantity = " . $quantity
                . " WHERE id =" . $itemID);
    }

    public function delete_item($itemID) {
        $this->query("DELETE FROM inventory WHERE id = " . $itemID . "");
    }

}

?>
